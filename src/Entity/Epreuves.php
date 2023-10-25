<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use App\Grafikat\UploadBundle\Annotation\Uploadable;
use App\Grafikat\UploadBundle\Annotation\UploadableField;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Epreuves
 *
 * @ORM\Table(name="epreuves")
 * @ORM\Entity(repositoryClass="App\Repository\EpreuvesRepository")
 * @Uploadable()
 */
class Epreuves
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Matieres", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $matieres;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Classes", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $classes;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;
    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255, nullable=true)
     */
    private $type;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }


    //upload file (image)

    /**
     * @var string
     *
     * @ORM\Column(name="filename", type="string", length=255)
     */
    private $filename;

    /**
     * @UploadableField(filename = "filename", path="uploads/epreuves")
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
     * @return epreuves
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
     * Set name.
     *
     * @param string $name
     *
     * @return Epreuves
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
     * Set matieres.
     *
     * @param \App\Entity\Matieres $matieres
     *
     * @return Epreuves
     */
    public function setMatieres(\App\Entity\Matieres $matieres)
    {
        $this->matieres = $matieres;

        return $this;
    }

    /**
     * Get matieres.
     *
     * @return \App\Entity\Matieres
     */
    public function getMatieres()
    {
        return $this->matieres;
    }

    /**
     * Set classes.
     *
     * @param \App\Entity\Classes $classes
     *
     * @return Epreuves
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

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Epreuves
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
}
