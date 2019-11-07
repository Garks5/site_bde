<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ComponentsRepository")
 */
class Components
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $Quantity;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Order", inversedBy="components")
     */
    private $IdOrder;

    public function __construct()
    {
        $this->IdOrder = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantity(): ?int
    {
        return $this->Quantity;
    }

    public function setQuantity(int $Quantity): self
    {
        $this->Quantity = $Quantity;

        return $this;
    }

    /**
     * @return Collection|Order[]
     */
    public function getIdOrder(): Collection
    {
        return $this->IdOrder;
    }

    public function addIdOrder(Order $idOrder): self
    {
        if (!$this->IdOrder->contains($idOrder)) {
            $this->IdOrder[] = $idOrder;
        }

        return $this;
    }

    public function removeIdOrder(Order $idOrder): self
    {
        if ($this->IdOrder->contains($idOrder)) {
            $this->IdOrder->removeElement($idOrder);
        }

        return $this;
    }
}
