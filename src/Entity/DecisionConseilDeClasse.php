<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\Students;
/**
 * DecisionConseilDeClasse
 *
 * @ORM\Table(name="decision_conseil_de_classe")
 * @ORM\Entity(repositoryClass="App\Repository\DecisionConseilDeClasseRepository")
 */
class DecisionConseilDeClasse
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
     * @ORM\Column(name="appreciation", type="string", length=255, nullable=true)
     */
    private $appreciation;

    /**
     * @var string
     *
     * @ORM\Column(name="absence", type="string", length=255)
     */
    private $absence;

    /**
     * @var string
     *
     * @ORM\Column(name="bulletin", type="string", length=255)
     * @Assert\File(maxSize="2000k",
     * mimeTypes = {"application/pdf", "application/x-pdf"},
     * mimeTypesMessage = "Please upload a valid PDF",)
     * 
     */
    private $bulletin;

    /**
     * @var int
     *
     * @ORM\Column(name="exclusion", type="smallint", nullable=true)
     */
    private $exclusion;
    
    
    /**
     * @var int
     *
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $deuxiemeSequence;
    
    /**
     * @var int
     *
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $premiereSequence;
    
    
    
    /**
     * @var int
     *
     * @ORM\Column(name="trimestre", type="smallint", nullable=true)
     */
    private $trimestre;
    
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Students", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $student;

   
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
     * Set appreciation
     *
     * @param string $appreciation
     *
     * @return DecisionConseilDeClasse
     */
    public function setAppreciation($appreciation)
    {
        $this->appreciation = $appreciation;

        return $this;
    }

    /**
     * Get appreciation
     *
     * @return string
     */
    public function getAppreciation()
    {
        return $this->appreciation;
    }

    /**
     * Set absence
     *
     * @param string $absence
     *
     * @return DecisionConseilDeClasse
     */
    public function setAbsence($absence)
    {
        $this->absence = $absence;
        
        return $this;
    }

    /**
     * Get absence
     *
     * @return string
     */
    public function getAbsence()
    {
        return $this->absence;
    }

    /**
     * Set exclusion
     *
     * @param integer $exclusion
     *
     * @return DecisionConseilDeClasse
     */
    public function setExclusion($exclusion)
    {
        $this->exclusion = $exclusion;

        return $this;
    }

    /**
     * Get exclusion
     *
     * @return int
     */
    public function getExclusion()
    {
        return $this->exclusion;
    }

    /**
     * Set student
     *
     * @param \App\Entity\Students $student
     *
     * @return DecisionConseilDeClasse
     */
    public function setStudent(Students $student)
    {
        $this->student = $student;

        return $this;
    }

    /**
     * Get student
     *
     * @return \App\Entity\Students
     */
    public function getStudent()
    {
        return $this->student;
    }

    /**
     * Set trimestre
     *
     * @param integer $trimestre
     *
     * @return DecisionConseilDeClasse
     */
    public function setTrimestre($trimestre)
    {
        $this->trimestre = $trimestre;

        return $this;
    }

    /**
     * Get trimestre
     *
     * @return integer
     */
    public function getTrimestre()
    {
        return $this->trimestre;
    }

    /**
     * Set deuxiemeSequence
     *
     * @param integer $deuxiemeSequence
     *
     * @return DecisionConseilDeClasse
     */
    public function setDeuxiemeSequence($deuxiemeSequence)
    {
        $this->deuxiemeSequence = $deuxiemeSequence;

        return $this;
    }

    /**
     * Get deuxiemeSequence
     *
     * @return integer
     */
    public function getDeuxiemeSequence()
    {
        return $this->deuxiemeSequence;
    }

    /**
     * Set premiereSequence
     *
     * @param integer $premiereSequence
     *
     * @return DecisionConseilDeClasse
     */
    public function setPremiereSequence($premiereSequence)
    {
        $this->premiereSequence = $premiereSequence;

        return $this;
    }

    /**
     * Get premiereSequence
     *
     * @return integer
     */
    public function getPremiereSequence()
    {
        return $this->premiereSequence;
    }

    /**
     * Set bulletin
     *
     * @param string $bulletin
     *
     * @return DecisionConseilDeClasse
     */
    public function setBulletin($bulletin)
    {
        $this->bulletin = $bulletin;

        return $this;
    }

    /**
     * Get bulletin
     *
     * @return string
     */
    public function getBulletin()
    {
        return $this->bulletin;
    }
}
