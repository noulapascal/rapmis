<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Modules
 *
 * @ORM\Table(name="modules")
 * @ORM\Entity(repositoryClass="App\Repository\ModulesRepository")
 */
class Modules
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100)
     */
    private $name;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Matieres", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $matieres;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Classes", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $classes;

    /**
     * @var float
     *
     * @ORM\Column(name="coeff", type="float")
     */
    private $coeff;


    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return Modules
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description.
     *
     * @param string|null $description
     *
     * @return Modules
     */
    public function setDescription($description = null)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string|null
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set coeff.
     *
     * @param float $coeff
     *
     * @return Modules
     */
    public function setCoeff($coeff)
    {
        $this->coeff = $coeff;

        return $this;
    }

    /**
     * Get coeff.
     *
     * @return float
     */
    public function getCoeff()
    {
        return $this->coeff;
    }

    /**
     * @return mixed
     */
    public function getMatieres()
    {
        return $this->matieres;
    }

    /**
     * @param mixed $matieres
     */
    public function setMatieres($matieres)
    {
        $this->matieres = $matieres;
    }


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->matieres = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add matiere.
     *
     * @param \App\Entity\Matieres $matiere
     *
     * @return Modules
     */
    public function addMatiere(\App\Entity\Matieres $matiere)
    {
        $this->matieres[] = $matiere;

        return $this;
    }

    /**
     * Remove matiere.
     *
     * @param \App\Entity\Matieres $matiere
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeMatiere(\App\Entity\Matieres $matiere)
    {
        return $this->matieres->removeElement($matiere);
    }

    /**
     * Set classes.
     *
     * @param \App\Entity\Classes $classes
     *
     * @return Modules
     */
    public function setClasses(\App\Entity\Classes $classes)
    {
        $this->classes = $classes;

        return $this;
    }

    /**
     * Get classes.
     *
     * @return \App\Entity\Classes
     */
    public function getClasses()
    {
        return $this->classes;
    }
}
