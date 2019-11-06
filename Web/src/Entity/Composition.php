<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CompositionRepository")
 */
class Composition
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
    private $quantity;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Order", inversedBy="compositions")
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
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

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
