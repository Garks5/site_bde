<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\InscriptionsRepository")
 */
class Inscriptions
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Activities", inversedBy="inscriptions")
     */
    private $Activities;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Users", inversedBy="inscriptions")
     */
    private $Users;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getActivities(): ?Activities
    {
        return $this->Activities;
    }

    public function setActivities(?Activities $Activities): self
    {
        $this->Activities = $Activities;

        return $this;
    }
}
