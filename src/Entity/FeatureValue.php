<?php

namespace App\Entity;

use App\Repository\FeatureValueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FeatureValueRepository::class)]
class FeatureValue
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'featureValues')]
    private ?self $parent = null;

    #[ORM\OneToMany(mappedBy: 'parent', targetEntity: self::class)]
    private Collection $featureValues;

    #[ORM\OneToMany(mappedBy: 'featureValue', targetEntity: Feature::class)]
    private Collection $features;

    #[ORM\Column(length: 255)]
    private ?string $value = null;

    #[ORM\OneToMany(mappedBy: 'featureValue', targetEntity: PurchaseOrderFeatureValue::class)]
    private Collection $purchaseOrderFeatureValues;

    public function __construct()
    {
        $this->featureValues = new ArrayCollection();
        $this->features = new ArrayCollection();
        $this->purchaseOrderFeatureValues = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
    public function getFeatureValues(): Collection
    {
        return $this->featureValues;
    }

    public function addFeatureValue(self $featureValue): self
    {
        if (!$this->featureValues->contains($featureValue)) {
            $this->featureValues->add($featureValue);
            $featureValue->setParent($this);
        }

        return $this;
    }

    public function removeFeatureValue(self $featureValue): self
    {
        if ($this->featureValues->removeElement($featureValue)) {
            // set the owning side to null (unless already changed)
            if ($featureValue->getParent() === $this) {
                $featureValue->setParent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Feature>
     */
    public function getFeatures(): Collection
    {
        return $this->features;
    }

    public function addFeatures(Feature $features): self
    {
        if (!$this->features->contains($features)) {
            $this->features->add($features);
            $features->setFeatureValue($this);
        }

        return $this;
    }

    public function removeFeatures(Feature $features): self
    {
        if ($this->features->removeElement($features)) {
            // set the owning side to null (unless already changed)
            if ($features->getFeatureValue() === $this) {
                $features->setFeatureValue(null);
            }
        }

        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return Collection<int, PurchaseOrderFeatureValue>
     */
    public function getPurchaseOrderFeatureValues(): Collection
    {
        return $this->purchaseOrderFeatureValues;
    }

    public function addPurchaseOrderFeatureValue(PurchaseOrderFeatureValue $purchaseOrderFeatureValue): self
    {
        if (!$this->purchaseOrderFeatureValues->contains($purchaseOrderFeatureValue)) {
            $this->purchaseOrderFeatureValues->add($purchaseOrderFeatureValue);
            $purchaseOrderFeatureValue->setFeatureValue($this);
        }

        return $this;
    }

    public function removePurchaseOrderFeatureValue(PurchaseOrderFeatureValue $purchaseOrderFeatureValue): self
    {
        if ($this->purchaseOrderFeatureValues->removeElement($purchaseOrderFeatureValue)) {
            // set the owning side to null (unless already changed)
            if ($purchaseOrderFeatureValue->getFeatureValue() === $this) {
                $purchaseOrderFeatureValue->setFeatureValue(null);
            }
        }

        return $this;
    }
}
