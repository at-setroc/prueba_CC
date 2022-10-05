<?php

namespace App\Service;

use App\Entity\Category;
use App\Entity\PurchaseOrder;
use App\Entity\Feature;
use App\Entity\FeatureValue;
use App\Entity\PurchaseOrderFeatureValue;
use App\Service\DataBaseManagement\DataBaseManagementFactory;
use Doctrine\Persistence\ManagerRegistry;

class PurchaseOrderService
{
    public function __construct(
        ManagerRegistry             $registry,
        DataBaseManagementFactory   $db
    ) {
        $this->em = $registry->getManager();
        $this->db = $db->initialize();
    }

    /**
     * Función para crear un registro de pedido de producto
     *
     * @param   array   $data               Datos de las características del producto
     * @param   string  $userIdentifier     Información para identificar al usuario que ha realizado el pedido
     * 
     * @return boolean
     */
    public function savePurchaseOrder(array $data, string $userIdentifier): bool 
    {
        $featuresValues = array();
        
        // Creamos el PurchaseOrder
        $po = new PurchaseOrder($userIdentifier);

        // Buscamos o creamos los FeatureValues
        foreach($data as $key => $value) {
            
            // Recorremos los valores para las características, siempre que no sean nulos
            if(is_string($key) && !is_null($value) && $value != "") {
                
                $feature = $this->em->getRepository(Feature::class)->findOneByCodeName($key);
                if (!$feature) {
                    return false;
                }
                
                // Buscamos el valor para esa característica
                $featureValue = $this->em->getRepository(FeatureValue::class)->findOneBy([
                    "feature" => $feature,
                    "value"   => $value
                ]);

                // Si no existe, lo creamos
                if(!$featureValue) {
                    $featureValue = new FeatureValue($value);
                    $featureValue->setFeature($feature);

                    try {
                        $this->db->save($featureValue);
                    } catch (\Throwable $th) {
                        return false;
                    }
                }
                
                $featuresValues[] = $featureValue;
            }
        }
        
        try {
            $this->db->save($po);
        } catch (\Throwable $th) {
            return false;
        }
        
        // Guardamos la relación entre el pedido y los valores de las características        
        foreach($featuresValues as $fv) {
            $poFv = new PurchaseOrderFeatureValue;
            $poFv->setFeatureValue($fv)
                ->setPurchaseOrder($po);

            try {
                $this->db->save($poFv);
            } catch (\Throwable $th) {
                return false;
            }
        }

        return true;
    }

}