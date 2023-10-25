<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use App\Grafikat\UploadBundle\Annotation\Uploadable;
use App\Grafikat\UploadBundle\Annotation\UploadableField;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Staff
 *
 * @ORM\Table(name="staff")
 * @ORM\Entity(repositoryClass="App\Repository\StaffRepository")
 * @Uploadable()
 */
class Staff
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
     * @var string
     *
     * @ORM\Column(name="fonction", type="string", length=255)
     */
    private $fonction;

    /**
     * @var string|null
     *
     * @ORM\Column(name="tel", type="string", length=50, nullable=true)
     */
    private $tel;

    /**
     * @var string
     *
     * @ORM\Column(name="sexe", type="string", length=25, nullable=false)
     */
    private $sexe;


    /**
     * @var string|null
     *
     * @ORM\Column(name="mail", type="string", length=50, nullable=true)
     */
    private $mail;

    /** date de creation de l'enseignant
     * @var \DateTime|null
     *
     * @ORM\Column(name="test", type="datetime", nullable=true)
     */
    private $dateCreate;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Etablissements", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $etablissements;

    //upload file (image)

    /**
     * @var string
     *
     * @ORM\Column(name="filename", type="string", length=255,nullable=true)
     */
    private $filename;

    /**
     * @UploadableField(filename = "filename", path="uploads/staff")
     */
    public $file;

    /*
     * @var \DateTime
     * @ORM\Column(name"updated_at", type="datetime", nullable=true)
     */
    private $UpdatedAt;

     /**
     * @ORM\OneToOne(targetEntity="App\Entity\Staff", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     * @Assert\NotBlank(message="Please enter staff Name.", groups={"Profile"})
     */
    protected $staff;
    

    public function getStaff() {
        return $this->staff;   
    }
public function setStaff($staff)
    {
        $this->staff=$staff;
    }
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

    public function __toString()
    {
        return $this->getName();
    }

    /**
     * Set filename.
     *
     * @param string $filename
     *
     * @return staff
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
     * @return Staff
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
     * Set fonction.
     *
     * @param string $fonction
     *
     * @return Staff
     */
    public function setFonction($fonction)
    {
        $this->fonction = $fonction;

        return $this;
    }

    /**
     * Get fonction.
     *
     * @return string
     */
    public function getFonction()
    {
        return $this->fonction;
    }

    /**
     * Set tel.
     *
     * @param string|null $tel
     *
     * @return Staff
     */
    public function setTel($tel = null)
    {
        $this->tel = $tel;

        return $this;
    }

    /**
     * Get tel.
     *
     * @return string|null
     */
    public function getTel()
    {
        return $this->tel;
    }

    /**
     * Set staff.
     *
     * @param \DateTime|null $staff
     *
     * @return staff
     */
    public function setDateCreate($dateCreate = null)
    {
        $this->dateCreate = $dateCreate;

        return $this;
    }

    /**
     * Get dateCreate.
     *
     * @return \DateTime|null
     */
    public function getDateCreate()
    {
        return $this->dateCreate;
    }

    /**
     * Set mail.
     *
     * @param string|null $mail
     *
     * @return Staff
     */
    public function setMail($mail = null)
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Get mail.
     *
     * @return string|null
     */
    public function getMail()
    {
        return $this->mail;
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
     * @return string
     */
    public function getSexe()
    {
        return $this->sexe;
    }

    /**
     * @param string $sexe
     */
    public function setSexe(string $sexe)
    {
        $this->sexe = $sexe;
    }




}
