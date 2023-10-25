<?php

namespace App\Entity;

use App\Repository\DevoirRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DevoirRepository::class)
 */
class Devoir
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $homework;

    /**
     * @ORM\ManyToOne(targetEntity=Matieres::class, inversedBy="devoirs")
     * @ORM\JoinColumn( nullable=true, onDelete="CASCADE")
     */
    private $subject;

    /**
     * @ORM\ManyToOne(targetEntity=Classes::class, inversedBy="devoirs")
     */
    private $class;

    /**
     * @ORM\Column(type="date")
     */
    private $givenOn;

    /**
     * @ORM\Column(type="date")
     */
    private $doBefore;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updateAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDevoir(): ?string
    {
        return $this->homework;
    }

    public function setDevoir(string $homework): self
    {
        $this->homework = $homework;

        return $this;
    }

    public function getMatieres(): ?Matieres
    {
        return $this->matieres;
    }

    public function setMatieres(?Matieres $matieres): self
    {
        $this->matieres = $matieres;

        return $this;
    }

    public function getgivenOn(): ?\DateTimeInterface
    {
        return $this->givenOn;
    }

    public function setgivenOn(\DateTimeInterface $givenOn): self
    {
        $this->givenOn = $givenOn;

        return $this;
    }

    public function getDoBefore(): ?\DateTimeInterface
    {
        return $this->doBefore;
    }

    public function setDoBefore(\DateTimeInterface $doBefore): self
    {
        $this->doBefore = $doBefore;

        return $this;
    }

    /**
     * Set matiere
     *
     * @param \App\Entity\Matieres $matiere
     *
     * @return Devoir
     */
    public function setMatiere(\App\Entity\Matieres $matiere = null)
    {
        $this->matiere = $matiere;

        return $this;
    }

    /**
     * Get matiere
     *
     * @return \App\Entity\Matieres
     */
    public function getMatiere()
    {
        return $this->matiere;
    }

    /**
     * Set classe
     *
     * @param \App\Entity\Classes $classe
     *
     * @return Devoir
     */
    public function setClasse(\App\Entity\Classes $classe = null)
    {
        $this->classe = $classe;

        return $this;
    }

    /**
     * Get classe
     *
     * @return \App\Entity\Classes
     */
    public function getClasse()
    {
        return $this->classe;
    }

    public function getUpdateAt(): ?\DateTimeInterface
    {
        return $this->updateAt;
    }

    public function setUpdateAt(?\DateTimeInterface $updateAt): self
    {
        $this->updateAt = $updateAt;

        return $this;
    }

    public function getHomework(): ?string
    {
        return $this->homework;
    }

    public function setHomework(string $homework): self
    {
        $this->homework = $homework;

        return $this;
    }

    public function getSubject(): ?Matieres
    {
        return $this->subject;
    }

    public function setSubject(?Matieres $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    public function getClass(): ?Classes
    {
        return $this->class;
    }

    public function setClass(?Classes $class): self
    {
        $this->class = $class;

        return $this;
    }
}
