<?php

namespace App\Entity;

use App\Repository\FeatureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FeatureRepository::class)]
class Feature
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'features')]
    private ?Category $category = null;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'features')]
    private ?self $parent = null;

    #[ORM\OneToMany(mappedBy: 'parent', targetEntity: self::class)]
    private Collection $features;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\Column(length: 100)]
    private ?string $codeName = null;

    #[ORM\Column]
    private ?int $formOrder = null;

    #[ORM\Column]
    private ?bool $active = null;

    #[ORM\Column]
    private ?bool $required = null;

    #[ORM\Column]
    private ?bool $nextFeatureInSameSection = null;

    #[ORM\ManyToOne(inversedBy: 'features')]
    private ?FieldType $fieldType = null;

    #[ORM\OneToMany(mappedBy: 'feature', targetEntity: FeatureValue::class)]
    private Collection $featureValues;

    #[ORM\Column(nullable: true)]
    private ?int $minLength = null;

    #[ORM\Column(nullable: true)]
    private ?int $maxLength = null;

    public function __construct()
    {
        $this->features = new ArrayCollection();
        $this->featureValues = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getFeatures(): Collection
    {
        return $this->features;
    }

    public function addFeature(self $feature): self
    {
        if (!$this->features->contains($feature)) {
            $this->features->add($feature);
            $feature->setParent($this);
        }

        return $this;
    }

    public function removeFeature(self $feature): self
    {
        if ($this->features->removeElement($feature)) {
            // set the owning side to null (unless already changed)
            if ($feature->getParent() === $this) {
                $feature->setParent(null);
            }
        }

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCodeName(): ?string
    {
        return $this->codeName;
    }

    public function setCodeName(string $codeName): self
    {
        $this->codeName = $codeName;

        return $this;
    }

    public function getFormOrder(): ?int
    {
        return $this->formOrder;
    }

    public function setFormOrder(int $formOrder): self
    {
        $this->formOrder = $formOrder;

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function isRequired(): ?bool
    {
        return $this->required;
    }

    public function setRequired(bool $required): self
    {
        $this->required = $required;

        return $this;
    }

    public function isNextFeatureInSameSection(): ?bool
    {
        return $this->nextFeatureInSameSection;
    }

    public function setNextFeatureInSameSection(bool $nextFeatureInSameSection): self
    {
        $this->nextFeatureInSameSection = $nextFeatureInSameSection;

        return $this;
    }

    public function getFieldType(): ?FieldType
    {
        return $this->fieldType;
    }

    public function setFieldType(?FieldType $fieldType): self
    {
        $this->fieldType = $fieldType;

        return $this;
    }

    /**
     * @return Collection<int, FeatureValue>
     */
    public function getFeatureValues(): Collection
    {
        return $this->featureValues;
    }

    public function addFeatureValue(FeatureValue $featureValue): self
    {
        if (!$this->featureValues->contains($featureValue)) {
            $this->featureValues->add($featureValue);
            $featureValue->setFeature($this);
        }

        return $this;
    }

    public function removeFeatureValue(FeatureValue $featureValue): self
    {
        if ($this->featureValues->removeElement($featureValue)) {
            // set the owning side to null (unless already changed)
            if ($featureValue->getFeature() === $this) {
                $featureValue->setFeature(null);
            }
        }

        return $this;
    }

    public function getMinLength(): ?int
    {
        return $this->minLength;
    }

    public function setMinLength(?int $minLength): self
    {
        $this->minLength = $minLength;

        return $this;
    }

    public function getMaxLength(): ?int
    {
        return $this->maxLength;
    }

    public function setMaxLength(?int $maxLength): self
    {
        $this->maxLength = $maxLength;

        return $this;
    }
}
