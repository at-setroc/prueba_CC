<?php

namespace App\Form;

use App\Entity\Feature;
use App\Entity\FeatureValue;
use App\Repository\FeatureRepository;
use App\Repository\FeatureValueRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;

class PurchaseOrderType extends AbstractType
{
    public function __construct(
        FeatureRepository      $featureRepository,
        FeatureValueRepository $featureValueRepository,
    ) {
        $this->featureRepo      = $featureRepository;
        $this->featureValueRepo = $featureValueRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        if(empty($options["data"]) || !is_array($options["data"]) ) {
            return;
        }
        
        $features = $options["data"];

        // Se añaden los campos
        foreach ($features as $feature) {
            $this->addField($builder, $feature);
        }

        $formModifier = function (FormInterface $form, $field = null, $data = null) {
            
            $fieldFeature      = $this->featureRepo->findOneByCodeName($field->getName());
            $fieldFeatureValue = $this->featureValueRepo->findOneBy([
                "feature"   => $fieldFeature,
                "value"     => $data
            ]);

            $featureChildren = $this->featureRepo->findBy([
                "parent"    => $fieldFeature,
                "category"  => $fieldFeature->getCategory()
            ]);

            foreach ($featureChildren as $child) {
                
                $choices = $this->featureValueRepo->findBy([
                    "parent"  => $fieldFeatureValue,
                    "feature" => $child
                ]);

                $childChoices = array();
                if (!is_null($data)) {
                    foreach ($choices as $choice) {
                        $childChoices[$choice->getValue()] = $choice->getValue();
                    }
                }

                $this->addField($form, $child, $childChoices);
            }
        };

        // Se añaden los listeners
        foreach ($features as $f) {
            $builder->get($f->getCodeName())->addEventListener(
                FormEvents::POST_SUBMIT,
                function (FormEvent $event) use ($formModifier) {    
                    $formModifier($event->getForm()->getParent(), $event->getForm(), $event->getForm()->getData());
                }
            );
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            "trim" => true,
        ]);
    }


    /* * * * * * * * * * * * */
    /* FUNCIONES AUXILIARES  */
    /* * * * * * * * * * * * */

    /**
     * Función que añade un campo al formulario dependiendo de la característica del segundo parámetro.
     *
     * @param FormBuilderInterface $builder     Constructor del formulario
     * @param Feature              $feature     Característica que se utilizará para aplicar el tipo de campo
     * @param ?array               $choices     Opciones para un campo a añadir
     
     * @return void
     */
    public function addField( $builder, Feature $feature, array $choices = null) : void
    {        
        $featureConfig = $this->getFieldconfig($feature, $choices);

        $builder->add($feature->getCodeName(), $featureConfig["type"], $featureConfig["options"]);
    }

    /**
     * Función para obtener los parámetros del campo de la característica indicada.
     *
     * @param Feature $feature  Característica
     * @param ?array  $choices  Opciones
     * 
     * @return array  $config   Parámetros del campo
     */
    private function getFieldConfig(Feature $feature, $choices = null): array
    {
        $config                    = array();
        $config["options"]         = array();
        
        $type = (empty($feature->getFieldType())) ? null : $feature->getFieldType()->getCodeName();

        switch ($type) {
            
            case 'numeric':
                $config["type"] = IntegerType::class;

                $config["options"]["attr"]["class"] = "form-control";

                if (!empty($feature->getMinLength())) {
                    $config["options"]["attr"]["min"] = str_pad("1", $feature->getMinLength(), "0", STR_PAD_RIGHT);
                }
                if (!empty($feature->getMaxLength())) {
                    $config["options"]["attr"]["max"] = str_pad("9", $feature->getMinLength(), "9", STR_PAD_RIGHT);
                }

                break;
            
            case 'select':
                $config["type"] = ChoiceType::class;

                $config["options"]["attr"]["class"] = "form-select";
                $config["options"]["placeholder"]   = $feature->getName();
                
                // Establecemos los valores del select
                if (!empty($choices)) {
                    $config["options"]["choices"] = $choices;
                } else if (empty($feature->getParent())) {
                    $config["options"]["choices"] = array();
                    $choices = $feature->getFeatureValues();

                    foreach ($choices as $choice) {
                        $config["options"]["choices"][$choice->getValue()] = $choice->getValue();
                    }
                }

                // Comprobamos si tiene "subfeatures"
                if (!empty(count($feature->getFeatures()))) {
                    $config["options"]["attr"]["class"] .= " feature-parent";
                }

                // Comprobamos si es dependiente de otra categoría
                if ($feature->getParent()) {
                    $config["options"]["attr"]["class"] .= " child_".$feature->getParent()->getCodeName();
                }

                break;
            
            default: // text (Por defecto, el de texto)

                $config["type"] = TextType::class;

                $config["options"]["attr"]["class"] = "form-control";

                if (!empty($feature->getMinLength())) {
                    $config["options"]["attr"]["minlength"] = $feature->getMinLength();
                }

                if (!empty($feature->getMaxLength())) {
                    $config["options"]["attr"]["maxlength"] = $feature->getMaxLength();
                }
                break;
        }

        $config["options"]["label"]    = $feature->getName();
        $config["options"]["required"] = $feature->isRequired();

        if ($feature->isNextFeatureInSameSection()) {
            if (empty($config["options"]["attr"]["class"])) {
                $config["options"]["attr"]["class"]  = "next_in_same_section";
            } else {
                $config["options"]["attr"]["class"] .= " next_in_same_section";
            }
        }

        return $config;
    }
    
}
