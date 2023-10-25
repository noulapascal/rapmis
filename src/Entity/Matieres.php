<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Matieres
 *
 * @ORM\Table(name="matieres")
 * @ORM\Entity(repositoryClass="App\Repository\MatieresRepository")
 */
class Matieres
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
     * @ORM\Column(name="name", type="string", length=40)
     */
    private $name;


    /**
     * @var string|null
     *
     * @ORM\Column(name="intitule", type="string", length=25, nullable=true)
     */
    private $intitule;


        /**
     * @ORM\OneToMany(targetEntity=Lacunes::class, mappedBy="matieres")
     */
    private $lacunes;

    /**
     * @ORM\OneToMany(targetEntity=Devoir::class, mappedBy="matieres")
     */
    private $devoirs;
    
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
     * @return Matieres
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
     * Set intitule.
     *
     * @param string|null $intitule
     *
     * @return Matieres
     */
    public function setIntitule($intitule = null)
    {
        $this->intitule = $intitule;

        return $this;
    }

    /**
     * Get intitule.
     *
     * @return string|null
     */
    public function getIntitule()
    {
        return $this->intitule;
    }


    public function __toString()
    {
        // TODO: Implement __toString() method.
        return $this->getName();
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->programmes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->lacunes = new ArrayCollection();
        $this->devoirs = new ArrayCollection();
    }

    
    
    
    
    
    /**
     * Add lacune
     *
     * @param \App\Entity\Lacunes $lacune
     *
     * @return Matieres
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
     * Add homework
     *
     * @param \App\Entity\Devoir $homework
     *
     * @return Matieres
     */
    public function addDevoir(\App\Entity\Devoir $homework)
    {
        $this->devoirs[] = $homework;

        return $this;
    }

    /**
     * Remove homework
     *
     * @param \App\Entity\Devoir $homework
     */
    public function removeDevoir(\App\Entity\Devoir $homework)
    {
        $this->devoirs->removeElement($homework);
    }

    /**
     * Get devoirs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDevoirs()
    {
        return $this->devoirs;
    }
}
