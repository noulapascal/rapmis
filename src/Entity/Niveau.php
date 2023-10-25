<?php

namespace App\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use Doctrine\ORM\Mapping as ORM;

/**
 * Niveau
 *
 * @ORM\Table(name="niveau")
 * @ORM\Entity(repositoryClass="App\Repository\NiveauRepository")
 */
class Niveau
{
    
    public function __construct()
    {
        $this->programmes = new ArrayCollection();
                $this->matieres = new \Doctrine\Common\Collections\ArrayCollection();
                $this->suggestions = new ArrayCollection();

    }
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;
    
    
    /**
     * @ORM\OneToMany(targetEntity=Suggestions::class, mappedBy="niveau")
     */
    private $suggestions;



    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Matieres", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $matieres;
    
    
    

    /**
     * @var string
     *
     * @ORM\Column(name="type_etablissement", type="string", length=255)
     */
    private $typeEtablissement;
    
    
    
     /**
     * @ORM\OneToMany(targetEntity=Programme::class, mappedBy="niveau")
     */
    private $programmes;
    
    
    
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
     * @return Niveau
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
     * @return Niveau
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

    public function __toString()
    {
        // TODO: Implement __toString() method.
        if(!empty($this->getName())){
        return $this->getName();    
        }
        else{
            return 'non defini';
        }
    }

    /**
     * Constructor
     */
  

    /**
     * Add matiere.
     *
     * @param \App\Entity\Matieres $matiere
     *
     * @return Niveau
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
     * Add suggestion
     *
     * @param \App\Entity\Suggestions $suggestion
     *
     * @return Niveau
     */
    public function addSuggestion(\App\Entity\Suggestions $suggestion)
    {
        $this->suggestions[] = $suggestion;

        return $this;
    }

    /**
     * Remove suggestion
     *
     * @param \App\Entity\Suggestions $suggestion
     */
    public function removeSuggestion(\App\Entity\Suggestions $suggestion)
    {
        $this->suggestions->removeElement($suggestion);
    }

    /**
     * Get suggestions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSuggestions()
    {
        return $this->suggestions;
    }

    /**
     * Add programme
     *
     * @param \App\Entity\Programme $programme
     *
     * @return Niveau
     */
    public function addProgramme(\App\Entity\Programme $programme)
    {
        $this->programmes[] = $programme;

        return $this;
    }

    /**
     * Remove programme
     *
     * @param \App\Entity\Programme $programme
     */
    public function removeProgramme(\App\Entity\Programme $programme)
    {
        $this->programmes->removeElement($programme);
    }

    /**
     * Get programmes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProgrammes()
    {
        return $this->programmes;
    }
    
    
    
    
    /**
     * Set typeEtablissement
     *
     * @param string $typeEtablissement
     *
     * @return Niveau
     */
    public function setTypeEtablissement($typeEtablissement)
    {
        $this->typeEtablissement = $typeEtablissement;

        return $this;
    }

    /**
     * Get typeEtablissement
     *
     * @return string
     */
    public function getTypeEtablissement()
    {
        return $this->typeEtablissement;
    }
}
