<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Matieres ;
/**
 * Suggestions
 *
 * @ORM\Table(name="suggestions")
 * @ORM\Entity(repositoryClass="App\Repository\SuggestionsRepository")
 */
class Suggestions
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
    private $suggestions;

     /**
     * @ORM\ManyToOne(targetEntity=Niveau::class, inversedBy="suggestions")
     * @ORM\JoinColumn( nullable=false, onDelete="CASCADE")
     */
    private $niveau;

    /**
     * @ORM\Column(type="string", length=255)
     */
    
    private $chapitre;

/*
    /**
     * @ORM\ManyToOne(targetEntity=Programme::class, inversedBy="suggestions")
     *
    private $programme;
*/
    /**
     * @ORM\ManyToOne(targetEntity=Matieres::class, inversedBy="observations")
     */
    private $Matieres;


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
     * Set niveau
     *
     * @param \App\Entity\Niveau $niveau
     *
     * @return Suggestions
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
     * Set chapitre
     *
     * @param \App\Entity\Chapitre $chapitre
     *
     * @return Suggestions
     */
   

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
     * Set matieres
     *
     * @param \App\Entity\Matieres $matieres
     *
     * @return Suggestions
     */
    public function setMatieres($matieres = null)
    {
        $this->Matieres = $matieres;

        return $this;
    }

    /**
     * Get matieres
     *
     * @return \App\Entity\Matieres
     */
    public function getMatieres()
    {
        return $this->Matieres;
    }

    /**
     * Set libelle
     *
     * @param string $libelle
     *
     * @return Suggestions
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
     * @return Suggestions
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
     * Set chapitre
     *
     * @param string $chapitre
     *
     * @return Suggestions
     */
    public function setChapitre($chapitre)
    {
        $this->chapitre = $chapitre;

        return $this;
    }
}
