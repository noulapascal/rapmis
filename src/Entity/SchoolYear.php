<?php

namespace App\Entity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * SchoolYear
 * @UniqueEntity(fields="beginningYear", message="This year already exist")
 * @ORM\Table(name="school_year")
 * @ORM\Entity(repositoryClass="App\Repository\SchoolYearRepository")
 */
class SchoolYear
{
    /**
     * @var int
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="libelle", type="string", length=255, nullable = true)
     */
    private $libelle;

    /**
     * @var int
     *
     * @ORM\Column(name="beginningYear", type="integer")
     */
    private $beginningYear;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable = true)
     */
    private $description;


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
     * Set beginningYear
     *
     * @param integer $beginningYear
     *
     * @return SchoolYear
     */
    public function setBeginningYear($beginningYear)
    {
        $this->beginningYear = $beginningYear;

        return $this;
    }

    /**
     * Get beginningYear
     *
     * @return int
     */
    public function getBeginningYear()
    {
        return $this->beginningYear;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return SchoolYear
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
    public function __toString() {
        $svt = $this->beginningYear+1;
        return $this->beginningYear.' / '. $svt;
        
    }

    /**
     * Set libelle
     *
     * @param string $libelle
     *
     * @return SchoolYear
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
}
