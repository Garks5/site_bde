<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\InscriptionRepository")
 */
class Inscription
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Activity", inversedBy="inscriptions")
     */
    private $IdActivity;

    public function __construct()
    {
        $this->IdActivity = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Activity[]
     */
    public function getIdActivity(): Collection
    {
        return $this->IdActivity;
    }

    public function addIdActivity(Activity $idActivity): self
    {
        if (!$this->IdActivity->contains($idActivity)) {
            $this->IdActivity[] = $idActivity;
        }

        return $this;
    }

    public function removeIdActivity(Activity $idActivity): self
    {
        if ($this->IdActivity->contains($idActivity)) {
            $this->IdActivity->removeElement($idActivity);
        }

        return $this;
    }
}
