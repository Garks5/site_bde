<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UsersRepository")
 */
class Users
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $mail;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $mdp;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $localisation;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Roles", inversedBy="users")
     */
    private $Roles;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Commentaries", mappedBy="Users")
     */
    private $commentaries;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Votes", mappedBy="Users")
     */
    private $votes;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Activities", mappedBy="Users")
     */
    private $activities;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Pictures", mappedBy="Users")
     */
    private $pictures;

    public function __construct()
    {
        $this->commentaries = new ArrayCollection();
        $this->votes = new ArrayCollection();
        $this->activities = new ArrayCollection();
        $this->pictures = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getMdp(): ?string
    {
        return $this->mdp;
    }

    public function setMdp(string $mdp): self
    {
        $this->mdp = $mdp;

        return $this;
    }

    public function getLacalisation(): ?string
    {
        return $this->lacalisation;
    }

    public function setLacalisation(string $lacalisation): self
    {
        $this->lacalisation = $lacalisation;

        return $this;
    }

    public function getRoles(): ?Roles
    {
        return $this->Roles;
    }

    public function setRoles(?Roles $Roles): self
    {
        $this->Roles = $Roles;

        return $this;
    }

    /**
     * @return Collection|Commentaries[]
     */
    public function getCommentaries(): Collection
    {
        return $this->commentaries;
    }

    public function addCommentary(Commentaries $commentary): self
    {
        if (!$this->commentaries->contains($commentary)) {
            $this->commentaries[] = $commentary;
            $commentary->setUsers($this);
        }

        return $this;
    }

    public function removeCommentary(Commentaries $commentary): self
    {
        if ($this->commentaries->contains($commentary)) {
            $this->commentaries->removeElement($commentary);
            // set the owning side to null (unless already changed)
            if ($commentary->getUsers() === $this) {
                $commentary->setUsers(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Votes[]
     */
    public function getVotes(): Collection
    {
        return $this->votes;
    }

    public function addVote(Votes $vote): self
    {
        if (!$this->votes->contains($vote)) {
            $this->votes[] = $vote;
            $vote->setUsers($this);
        }

        return $this;
    }

    public function removeVote(Votes $vote): self
    {
        if ($this->votes->contains($vote)) {
            $this->votes->removeElement($vote);
            // set the owning side to null (unless already changed)
            if ($vote->getUsers() === $this) {
                $vote->setUsers(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Activities[]
     */
    public function getActivities(): Collection
    {
        return $this->activities;
    }

    public function addActivity(Activities $activity): self
    {
        if (!$this->activities->contains($activity)) {
            $this->activities[] = $activity;
            $activity->setUsers($this);
        }

        return $this;
    }

    public function removeActivity(Activities $activity): self
    {
        if ($this->activities->contains($activity)) {
            $this->activities->removeElement($activity);
            // set the owning side to null (unless already changed)
            if ($activity->getUsers() === $this) {
                $activity->setUsers(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Pictures[]
     */
    public function getPictures(): Collection
    {
        return $this->pictures;
    }

    public function addPicture(Pictures $picture): self
    {
        if (!$this->pictures->contains($picture)) {
            $this->pictures[] = $picture;
            $picture->setUsers($this);
        }

        return $this;
    }

    public function removePicture(Pictures $picture): self
    {
        if ($this->pictures->contains($picture)) {
            $this->pictures->removeElement($picture);
            // set the owning side to null (unless already changed)
            if ($picture->getUsers() === $this) {
                $picture->setUsers(null);
            }
        }

        return $this;
    }
}
