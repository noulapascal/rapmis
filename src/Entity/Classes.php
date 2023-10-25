<?php

namespace App\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Grafikat\UploadBundle\Annotation\Uploadable;
use App\Grafikat\UploadBundle\Annotation\UploadableField;
/**
 * Classes
 * @ORM\Table(name="classes")
 * @ORM\Entity(repositoryClass="App\Repository\ClassesRepository")
 */
class Classes
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
     * @ORM\Column(name="name", type="string", length=50)
     */
    private $name;

        /**
     * @ORM\OneToMany(targetEntity="App\Entity\Students", mappedBy="classes")
     * @ORM\JoinColumn(nullable=false)
     */
        protected $students;
        
        /** date de la rentrée
     * @var \DateTime|null
     *
     * @ORM\Column(name="datedebut", type="datetime", nullable=true)
     */
    private $dateDebut;

    /** date de fin des cours
     * @var \DateTime|null
     *
     * @ORM\Column(name="datefin", type="datetime", nullable=true)
     */
    private $dateFin;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Niveau", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $niveau;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SchoolYear", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $schoolYear;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Etablissements", cascade={"persist"})
     * @ORM\JoinColumn( nullable=false, onDelete="CASCADE")
     * 
     */
    private $etablissements;

    /**
     * @var string
     *
     * @ORM\Column(name="filename", type="string", length=255,nullable=true)
     */
    private $filename;

    /**
     * @UploadableField(filename = "filename", path="uploads/logo")
     */
    public $emploiDuTemps;
    
    
     


    /*
     * @var \DateTime
     * @ORM\Column(name"updated_at", type="datetime", nullable=true)
     */
    private $updateAt;
    
            
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
     * @return Classes
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
     * @return mixed
     */
    public function getEtablissements()
    {
        return $this->etablissements;
    }

    /**
     * @param mixed $etablissements
     */
    public function setEtablissements($etablissements)
    {
        $this->etablissements = $etablissements;
    }

    /**
     * @return mixed
     */
    public function getNiveau()
    {
        return $this->niveau;
    }

    /**
     * @param mixed $niveau
     */
    public function setNiveau($niveau)
    {
        $this->niveau = $niveau;
    }

    public function __toString()
    {
        // TODO: Implement __toString() method.

        return (string)($this->getNiveau().''.$this->getName());
    }

    /**
     * @return \DateTime|null
     */
    public function getDateDebut()
    {
        return $this->dateDebut;
    }

    /**
     * @param \DateTime|null $dateDebut
     */
    public function setDateDebut($dateDebut)
    {
        $this->dateDebut = $dateDebut;
    }

    /**
     * @return \DateTime|null
     */
    public function getDateFin()
    {
        return $this->dateFin;
    }

    /**
     * @param \DateTime|null $dateFin
     */
    public function setDateFin($dateFin)
    {
        $this->dateFin = $dateFin;
    }



    /**
     * Set filename
     *
     * @param string $filename
     *
     * @return Classes
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
    

    

    /**
     * Set schoolYear
     *
     * @param \App\Entity\SchoolYear $schoolYear
     *
     * @return Classes
     */
    public function setSchoolYear(\App\Entity\SchoolYear $schoolYear = null)
    {
        $this->schoolYear = $schoolYear;

        return $this;
    }

    /**
     * Get schoolYear
     *
     * @return \App\Entity\SchoolYear
     */
    public function getSchoolYear()
    {
        return $this->schoolYear;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->students = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add student
     *
     * @param \App\Entity\Students $student
     *
     * @return Classes
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
     * Get students
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getStudents()
    {
        return $this->students;
    }
}
