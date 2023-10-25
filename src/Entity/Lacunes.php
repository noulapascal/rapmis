<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Students;

/**
 * Lacunes
 *
 * @ORM\Table(name="lacunes")
 * @ORM\Entity(repositoryClass="App\Repository\LacunesRepository")
 */
class Lacunes
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $libelle;

    /**
     * @ORM\ManyToOne(targetEntity=Chapitre::class, inversedBy="lacunes")
     * @ORM\JoinColumn( nullable=true, onDelete="CASCADE")
     */
    private $chapitre;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $suggestions;

    /**
     * @ORM\ManyToOne(targetEntity=Niveau::class, inversedBy="lacunes")
     */
    private $niveau;

    /**
     * @ORM\ManyToOne(targetEntity=Matieres::class, inversedBy="lacunes")
     */
    private $matieres;


    /**
     * @ORM\Column(type="string", length=255)
     */
    private $observations;

        /**
     * @ORM\ManyToMany(targetEntity=Students::class, inversedBy="lacunes")
     */
    private $students;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updateAt;




    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set libelle
     *
     * @param string $libelle
     *
     * @return Lacunes
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * Get libelle
     *
     * @return string
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * Set suggestions
     *
     * @param string $suggestions
     *
     * @return Lacunes
     */
    public function setSuggestions($suggestions)
    {
        $this->suggestions = $suggestions;

        return $this;
    }

    /**
     * Get suggestions
     *
     * @return string
     */
    public function getSuggestions()
    {
        return $this->suggestions;
    }

    /**
     * Set observations
     *
     * @param string $observations
     *
     * @return Lacunes
     */
    public function setObservations($observations)
    {
        $this->observations = $observations;

        return $this;
    }

    /**
     * Get observations
     *
     * @return string
     */
    public function getObservations()
    {
        return $this->observations;
    }

    /**
     * Set chapitre
     *
     * @param \App\Entity\Chapitre $chapitre
     *
     * @return Lacunes
     */
    public function setChapitre(\App\Entity\Chapitre $chapitre = null)
    {
        $this->chapitre = $chapitre;

        return $this;
    }

    /**
     * Get chapitre
     *
     * @return \App\Entity\Chapitre
     */
    public function getChapitre()
    {
        return $this->chapitre;
    }

    /**
     * Set niveau
     *
     * @param \App\Entity\Niveau $niveau
     *
     * @return Lacunes
     */
    public function setNiveau(\App\Entity\Niveau $niveau = null)
    {
        $this->niveau = $niveau;

        return $this;
    }

    /**
     * Get niveau
     *
     * @return \App\Entity\Niveau
     */
    public function getNiveau()
    {
        return $this->niveau;
    }

    /**
     * Set matieres
     *
     * @param \App\Entity\Matieres $matieres
     *
     * @return Lacunes
     */
    public function setMatieres(\App\Entity\Matieres $matieres = null)
    {
        $this->matieres = $matieres;

        return $this;
    }

    /**
     * Get matieres
     *
     * @return \App\Entity\Matieres
     */
    public function getMatieres()
    {
        return $this->matieres;
    }

    /**
     * Set students
     *
     * @param \App\Entity\student $students
     *
     * @return Lacunes
     */
    
    public function __construct()
    {
        $this->students = new \Doctrine\Common\Collections\ArrayCollection();
        $this->lacunes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add student
     *
     * @param \App\Entity\Students $student
     *
     * @return Lacunes
     */
    public function addStudent(\App\Entity\Students $student)
    {
        $this->students[] = $student;

        return $this;
    }

    /**
     * Remove student
     *
     * @param \App\Entity\Students $student
     */
    public function removeStudent(\App\Entity\Students $student)
    {
        $this->students->removeElement($student);
    }

    /**
     * Add lacune
     *
     * @param \App\Entity\Lacunes $lacune
     *
     * @return Lacunes
     */
    public function addLacune(\App\Entity\Lacunes $lacune)
    {
        $this->lacunes[] = $lacune;

        return $this;
    }

    /**
     * Remove lacune
     *
     * @param \App\Entity\Lacunes $lacune
     */
    public function removeLacune(\App\Entity\Lacunes $lacune)
    {
        $this->lacunes->removeElement($lacune);
    }

    /**
     * Get lacunes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLacunes()
    {
        return $this->lacunes;
    }

    /**
     * Get students
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getStudents()
    {
        return $this->students;
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
}
