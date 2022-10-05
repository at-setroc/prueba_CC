<?php

namespace App\Entity;

use App\Repository\PurchaseOrderFeatureValueRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PurchaseOrderFeatureValueRepository::class)]
class PurchaseOrderFeatureValue
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'purchaseOrderFeatureValues')]
    private ?PurchaseOrder $purchaseOrder = null;

    #[ORM\ManyToOne(inversedBy: 'purchaseOrderFeatureValues')]
    private ?FeatureValue $featureValue = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPurchaseOrder(): ?PurchaseOrder
    {
        return $this->purchaseOrder;
    }

    public function setPurchaseOrder(?PurchaseOrder $purchaseOrder): self
    {
        $this->purchaseOrder = $purchaseOrder;

        return $this;
    }

    public function getFeatureValue(): ?FeatureValue
    {
        return $this->featureValue;
    }

    public function setFeatureValue(?FeatureValue $featureValue): self
    {
        $this->featureValue = $featureValue;

        return $this;
    }
}
