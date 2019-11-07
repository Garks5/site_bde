<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrderRepository")
 */
class Order
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $available;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="orders")
     */
    private $IdUser;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Components", mappedBy="IdOrder")
     */
    private $components;

    public function __construct()
    {
        $this->components = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAvailable(): ?bool
    {
        return $this->available;
    }

    public function setAvailable(bool $available): self
    {
        $this->available = $available;

        return $this;
    }

    public function getIdUser(): ?User
    {
        return $this->IdUser;
    }

    public function setIdUser(?User $IdUser): self
    {
        $this->IdUser = $IdUser;

        return $this;
    }

    /**
     * @return Collection|Components[]
     */
    public function getComponents(): Collection
    {
        return $this->components;
    }

    public function addComponent(Components $component): self
    {
        if (!$this->components->contains($component)) {
            $this->components[] = $component;
            $component->addIdOrder($this);
        }

        return $this;
    }

    public function removeComponent(Components $component): self
    {
        if ($this->components->contains($component)) {
            $this->components->removeElement($component);
            $component->removeIdOrder($this);
        }

        return $this;
    }
}
