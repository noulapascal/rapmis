<?php

namespace App\Entity;

use App\App;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use App\Grafikat\UploadBundle\Annotation\Uploadable;
use App\Grafikat\UploadBundle\Annotation\UploadableField;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * Etablissements
 * @UniqueEntity(fields="sigle", message="Already use by another school please change it    ")
 * @ORM\Table(name="etablissements")
 * @ORM\Entity(repositoryClass="App\Repository\EtablissementsRepository")
 * @Uploadable()
 */
class Etablissements
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string|null
     *
     * @ORM\Column(name="sigle", type="string", length=20, nullable=true)
     */
    private $sigle;
    
    
    
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Classes",mappedBy="etablissements" )
     */
    private $classes;
    
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_creation", type="datetime")
     */
    private $dateCreation;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;


    
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\City")
     * @Assert\NotBlank()
     */
    
    private $city;
    /**
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Subdivision")
     */
    
    private $subdivision;
    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\SectionEduc", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $sectioneduc;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Addresses", cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $adresses;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Type_etablissements", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $type_etablissements;

    //upload file (image)

    /**
     * @var string
     *
     * @ORM\Column(name="filename", type="string", length=255,nullable=true)
     */
    private $filename;

    /**
     * @UploadableField(filename = "filename", path="uploads/logo")
     */
    public $file;

    /*
     * @var \DateTime
     * @ORM\Column(name"updated_at", type="datetime", nullable=true)
     */
    private $UpdatedAt;

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->UpdatedAt;
    }

    /**
     * @param mixed $UpdatedAt
     */
    public function setUpdatedAt($UpdatedAt)
    {
        $this->UpdatedAt = $UpdatedAt;
    }


    /**
     * @return File/null
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param File $file/null
     *
     */
    public function setFile($file)
    {
        $this->file = $file;
    }


    /**
     * Set filename.
     *
     * @param string $filename
     *
     * @return etablissements
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;

        return $this;
    }

    /**
     * Get filename.
     *
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }


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
     * @return Etablissements
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
     * Set sigle.
     *
     * @param string|null $sigle
     *
     * @return Etablissements
     */
    public function setSigle($sigle = null)
    {
        $this->sigle = $sigle;

        return $this;
    }

    /**
     * Get sigle.
     *
     * @return string|null
     */
    public function getSigle()
    {
        return $this->sigle;
    }

    /**
     * Set dateCreation.
     *
     * @param \DateTime $dateCreation
     *
     * @return Etablissements
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    /**
     * Get dateCreation.
     *
     * @return \DateTime
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * Set description.
     *
     * @param string $description
     *
     * @return Etablissements
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @return mixed
     */
    public function getSectioneduc()
    {
        return $this->sectioneduc;
    }

    /**
     * @param mixed $sectioneduc
     */
    public function setSectioneduc($sectioneduc)
    {
        $this->sectioneduc = $sectioneduc;
    }

    /**
     * @return mixed
     */
    public function getAdresses()
    {
        return $this->adresses;
    }

    /**
     * @param mixed $adresses
     */
    public function setAdresses($adresses)
    {
        $this->adresses = $adresses;
    }


    /**
     * Get type_etablissements
     *
     * @return \App\Entity\Type_etablissements
     */
    public function getType_Etablissements()
    {
        return $this->type_etablissements;
    }

    /**
     * @param mixed $type_etablissements
     */
    public function setType_Etablissements($type_etablissements)
    {
        $this->type_etablissements = $type_etablissements;
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
        $this->sectioneduc = new \Doctrine\Common\Collections\ArrayCollection();
        $this->classes = new ArrayCollection();
    }

    /**
     * Add sectioneduc.
     *
     * @param \App\Entity\SectionEduc $sectioneduc
     *
     * @return Etablissements
     */
    public function addSectioneduc(\App\Entity\SectionEduc $sectioneduc)
    {
        $this->sectioneduc[] = $sectioneduc;

        return $this;
    }

    /**
     * Remove sectioneduc.
     *
     * @param \App\Entity\SectionEduc $sectioneduc
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeSectioneduc(\App\Entity\SectionEduc $sectioneduc)
    {
        return $this->sectioneduc->removeElement($sectioneduc);
    }

    /**
     * Set typeEtablissements.
     *
     * @param \App\Entity\Type_etablissements $typeEtablissements
     *
     * @return Etablissements
     */
    public function setTypeEtablissements(\App\Entity\Type_etablissements $typeEtablissements)
    {
        $this->type_etablissements = $typeEtablissements;

        return $this;
    }

    /**
     * Get typeEtablissements.
     *
     * @return \App\Entity\Type_etablissements
     */
    public function getTypeEtablissements()
    {
        return $this->type_etablissements;
    }



    /**
     * Set classes
     *
     * @param \App\Entity\Classes $classes
     *
     * @return Etablissements
     */
    public function setClasses(\App\Entity\Classes $classes)
    {
        $this->classes = $classes;

        return $this;
    }

    /**
     * Get classes
     *
     * @return \App\Entity\Classes
     */
    public function getClasses()
    {
        return $this->classes;
    }

    /**
     * Add class
     *
     * @param \App\Entity\Classes $class
     *
     * @return Etablissements
     */
    public function addClass(\App\Entity\Classes $class)
    {
        $this->classes[] = $class;

        return $this;
    }

    /**
     * Remove class
     *
     * @param \App\Entity\Classes $class
     */
    public function removeClass(\App\Entity\Classes $class)
    {
        $this->classes->removeElement($class);
    }

    /**
     * Set subdivision
     *
     * @param \App\Entity\Subdivision $subdivision
     *
     * @return Etablissements
     */
    public function setSubdivision(\App\Entity\Subdivision $subdivision = null)
    {
        $this->subdivision = $subdivision;

        return $this;
    }

    /**
     * Get subdivision
     *
     * @return \App\Entity\Subdivision
     */
    public function getSubdivision()
    {
        return $this->subdivision;
    }
}
