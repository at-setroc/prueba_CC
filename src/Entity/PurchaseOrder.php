<?php

namespace App\Entity;

use App\Repository\PurchaseOrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PurchaseOrderRepository::class)]
class PurchaseOrder
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $requester = null;

    #[ORM\OneToMany(mappedBy: 'purchaseOrder', targetEntity: PurchaseOrderFeatureValue::class)]
    private Collection $purchaseOrderFeatureValues;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $creationDate = null;

    public function __construct(string $requester = null)
    {
        $this->purchaseOrderFeatureValues = new ArrayCollection();
        $this->requester                  = $requester;
        $this->creationDate               = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRequester(): ?string
    {
        return $this->requester;
    }

    public function setRequester(string $requester): self
    {
        $this->requester = $requester;

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
            $purchaseOrderFeatureValue->setPurchaseOrder($this);
        }

        return $this;
    }

    public function removePurchaseOrderFeatureValue(PurchaseOrderFeatureValue $purchaseOrderFeatureValue): self
    {
        if ($this->purchaseOrderFeatureValues->removeElement($purchaseOrderFeatureValue)) {
            // set the owning side to null (unless already changed)
            if ($purchaseOrderFeatureValue->getPurchaseOrder() === $this) {
                $purchaseOrderFeatureValue->setPurchaseOrder(null);
            }
        }

        return $this;
    }

    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->creationDate;
    }

    public function setCreationDate(\DateTimeInterface $creationDate): self
    {
        $this->creationDate = $creationDate;

        return $this;
    }
}
