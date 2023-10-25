<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Chapitre;


use App\Grafikat\UploadBundle\Annotation\Uploadable;
use App\Grafikat\UploadBundle\Annotation\UploadableField;
/**
 * Programme
 *
 * @ORM\Table(name="programme")
 * @ORM\Entity(repositoryClass="App\Repository\ProgrammeRepository")
 */
class Programme
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
    private $intitule;

    /**
     * @ORM\OneToMany(targetEntity=Chapitre::class, mappedBy="programme")
     */
    private $chapitres;

    /**
     * @ORM\ManyToOne(targetEntity=Matieres::class, inversedBy="programmes" )
     */
    private $matiere;

    /**
     * @ORM\ManyToOne(targetEntity=Niveau::class, inversedBy="programmes")
     */
    private $niveau;

    
    /**
     * @var string
     *
     * @ORM\Column(name="filename", type="string", length=255)
     */
    private $filename;

    /**
     * @UploadableField(filename = "filename", path="uploads/logo")
     */
    public $fichier;
    
     /*   /**
     * @ORM\OneToMany(targetEntity=Suggestions::class, mappedBy="chapitre")
     *
    private $suggestions;
    */
    
    
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
     * Constructor
     */
    public function __construct()
    {
        $this->chapitres = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add chapitre
     *
     * @param \App\Entity\Chapitre $chapitre
     *
     * @return Programme
     */
    public function addChapitre(\App\Entity\Chapitre $chapitre)
    {
        $this->chapitres[] = $chapitre;

        return $this;
    }

    /**
     * Remove chapitre
     *
     * @param \App\Entity\Chapitre $chapitre
     */
    public function removeChapitre(\App\Entity\Chapitre $chapitre)
    {
        $this->chapitres->removeElement($chapitre);
    }

    /**
     * Get chapitres
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getChapitres()
    {
        return $this->chapitres;
    }

    /**
     * Set matiere
     *
     * @param \App\Entity\Matieres $matiere
     *
     * @return Programme
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
     * Set niveau
     *
     * @param \App\Entity\Niveau $niveau
     *
     * @return Programme
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
     * Set intitule
     *
     * @param string $intitule
     *
     * @return Programme
     */
    public function setIntitule($intitule)
    {
        $this->intitule = $intitule;

        return $this;
    }

    /**
     * Get intitule
     *
     * @return string
     */
    public function getIntitule()
    {
        return $this->intitule;
    }

    /**
     * Set filename
     *
     * @param string $filename
     *
     * @return Programme
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;

        return $this;
    }

    /**
     * Get filename
     *
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }
    
    public function __toString() {
        return strval( $this->niveau);
    }

   
}
