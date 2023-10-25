<?php

namespace App\Entity;


use Symfony\Component\Mailer\Transport\Smtp\EsmtpTransport;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use App\Grafikat\UploadBundle\Annotation\Uploadable;
use App\Grafikat\UploadBundle\Annotation\UploadableField;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

/**
 * students
 *
 * @ORM\Table(name="students")
 * @ORM\Entity(repositoryClass="App\Repository\StudentsRepository")
 * @Uploadable()
 * @ORM\HasLifecycleCallbacks()
 */
class Students
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
     * @ORM\Column(name="name", type="string", length=150, nullable=false)
     */
    private $name;

    /**
     * @var string|null
     *
     * @ORM\Column(name="firstName", type="string", length=150, nullable=false)
     */
    private $firstName;



    /**
     * @var string|null
     *
     * @ORM\Column(name="pere", type="string", length=100, nullable=true)
     */
    private $pere;

    /**
     * @var string|null
     *
     * @ORM\Column(name="mere", type="string", length=100, nullable=true)
     */
    private $mere;

    /**
     * @var string|null
     *
     * @ORM\Column(name="tuteur", type="string", length=100, nullable=true)
     */
    private $tuteur;
    

    /**
     * @var string|null
     *
     * @ORM\Column(name="matricule", type="string", length=100, nullable=true)
     */
    private $matricule;

    /**
     * @var string|null
     *
     * @ORM\Column(name="tel_pere", type="string", length=50, nullable=true)
     */
    private $telPere;

    /**
     * @var string|null
     *
     * @ORM\Column(name="tel_mere", type="string", length=50, nullable=true)
     */
    private $telMere;

    /**
     * @var string|null
     *
     * @ORM\Column(name="tel_tuteur", type="string", length=50, nullable=true)
     */
    private $telTuteur;


    /**
     * email du père
     * @var string|null
     *
     * @ORM\Column(name="email_pere", type="string", length=100, nullable=true)
     */
    private $emailPere;

    /**
     * email de la mère
     * @var string|null
     *
     * @ORM\Column(name="email_mere", type="string", length=100, nullable=true)
     */
    private $emailMere;

    /**
     * email du tuteur
     * @var string|null
     *
     * @ORM\Column(name="email_tuteur", type="string", length=100, nullable=true)
     */
    private $emailTuteur;


    /**
     * profession du père
     * @var string|null
     *
     * @ORM\Column(name="prof_pere", type="string", length=100, nullable=true)
     */
    private $profPere;

    /**
     * profession de la mère
     * @var string|null
     *
     * @ORM\Column(name="prof_mere", type="string", length=100, nullable=true)
     */
    private $profMere;

    /**
     * profession tuteur
     * @var string|null
     *
     * @ORM\Column(name="prof_tuteur", type="string", length=100, nullable=true)
     */
    private $profTuteur;

    /**
     * residence des parents
     * @var string|null
     *
     * @ORM\Column(name="residence_parents", type="string", length=100, nullable=true)
     */
    private $residenceParents;

    /**
     * proches
     * @var string|null
     *
     * @ORM\Column(name="proche1", type="string", length=100, nullable=true)
     */
    private $proche1;

    /**
     * tel proches
     * @var string|null
     *
     * @ORM\Column(name="tel_proche1", type="string", length=50, nullable=true)
     */
    private $telProche1;

    /**
     * proches
     * @var string|null
     *
     * @ORM\Column(name="proche2", type="string", length=100, nullable=true)
     */
    private $proche2;

    /**
     * tel proches
     * @var string|null
     *
     * @ORM\Column(name="tel_proche2", type="string", length=50, nullable=true)
     */
    private $telProche2;


    /**
     * proches
     * @var string|null
     *
     * @ORM\Column(name="proche3", type="string", length=100, nullable=true)
     */
    private $proche3;

    /**
     * tel proches
     * @var string|null
     *
     * @ORM\Column(name="tel_proche3", type="string", length=50, nullable=true)
     */
    private $telProche3;

    /**
     * @var bool
     *
     * @ORM\Column(name="nouveau", type="boolean")
     */
    private $nouveau;

    /**
     * @var bool
     *
     * @ORM\Column(name="redoublant", type="boolean")
     */
    private $redoublant;



    /**
     * vrai pour accès par etude de dossier, faux pour accès par concour
     * @var bool
     *
     * @ORM\Column(name="etude_dossier", type="boolean")
     */
    private $etudeDossier;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_de_naissance", type="date", nullable=true)
     */
    private $dateDeNaissance;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="annee_scolaire", type="string", length=255, nullable=true)
     */
    private $anneeScolaire;

    /**
     * @var string
     *
     * @ORM\Column(name="lieu_de_naissance", type="string", length=100, nullable=true)
     */
    private $lieuDeNaissance;

    /**
     * @var string|null
     *
     * @ORM\Column(name="cycle", type="string", length=50, nullable=true)
     */
    private $cycle;

    /**
     * @var string|null
     *
     * @ORM\Column(name="serie", type="string", length=50, nullable=true)
     */
    private $serie;

    /**
     * @var float|null
     *
     * @ORM\Column(name="moy_passage_classe", type="float", nullable=true)
     */
    private $moyPassageClasse;

    /**
     * @var int|null
     *
     * @ORM\Column(name="rang", type="integer", nullable=true)
     */
    private $rang;

    /**
     * @var string/null
     *
     * @ORM\Column(name="last_school", type="string", length=125, nullable=true)
     */
    private $lastSchool;

    /**
     * @var string/null
     *
     * @ORM\Column(name="name_chef_last_school", type="string", length=100, nullable=true)
     */
    private $nameChefLastSchool;

    /**
     * @var string
     *
     * @ORM\Column(name="sexe", type="string", length=25, nullable=false)
     */
    private $sexe;


    /** date de l'inscription
     * @var \DateTime|null
     *
     * @ORM\Column(name="test", type="datetime", nullable=true)
     */
    private $dateCreate;

    //Bulletin santé

    /**
     * @var string|null
     *
     * @ORM\Column(name="groupe_sanguin", type="string", length=25, nullable=true)
     */
    private $groupeSanguin;

    /**
     * @var string|null
     *
     * @ORM\Column(name="pathogie_particuliere", type="string", length=150, nullable=true)
     */
    private $pathogieParticuliere;

    /**
     * @var string|null
     *
     * @ORM\Column(name="allergie_alimentaire", type="text", nullable=true)
     */
    private $allergieAlimentaire;

    /**
     * @var string|null
     *
     * @ORM\Column(name="allergie_medicamenteuse", type="text", nullable=true)
     */
    private $allergieMedicamenteuse;

    /**
     * @var string/null
     *
     * @ORM\Column(name="dispense", type="string", length=255, nullable=true)
     */
    private $dispense;

    /**
     * @var string/null
     *
     * @ORM\Column(name="medecin_familiale", type="string", length=255, nullable=true)
     */
    private $medecinFamiliale;

    /**
     * @var string|null
     *
     * @ORM\Column(name="tel_medecin_familiale", type="string", length=50, nullable=true)
     */
    private $telMedecinFamiliale;

    /**
     * @var string|null
     *
     * @ORM\Column(name="assurance_famille", type="string", length=150, nullable=true)
     */
    private $assuranceFamille;

    /**
     * @var string|null
     *
     * @ORM\Column(name="hopital_agree", type="string", length=100, nullable=true)
     */
    private $hopitalAgree;

    /**
     * @var string|null
     *
     * @ORM\Column(name="rhesus", type="string", length=100, nullable=true)
     */
    private $rhesus;

    /**
     * @var string|null
     *
     * @ORM\Column(name="inaptitude", type="string", length=255, nullable=true)
     */
    private $inaptitude;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Classes",inversedBy="students", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $classes;
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Distinction",cascade={"persist"},mappedBy="student")
     * @ORM\JoinColumn(nullable=true)
     */
    private $distinctions;


    //upload file (image)

    /**
     * @var string|null
     *
     * @ORM\Column(name="filename", type="string", length=255, nullable=true)
     */
    private $filename;

    /**
     * @UploadableField(filename = "filename", path="uploads/students")
     */
    public $file;

    //upload file (inaptitude)

    /**
     * @var string|null
     *
     * @ORM\Column(name="inapte", type="string", length=255, nullable=true)
     */
    private $inapte;

    /**
     * @UploadableField(filename = "inapte", path="uploads/students/inaptes")
     */
    public $justificationInaptitude;

    /**
     * @var string
     *
     * @ORM\Column(name="responsable", type="string", length=255)
     */
    private $responsable;

    /**
     * tel responsable
     * @var string
     *
     * @ORM\Column(name="tel_responsable", type="string", length=50,nullable = true)
     */
    private $telResponsable;

    /**
     * email responsable
     * @var string
     *
     * @ORM\Column(name="email_responsable", type="string", length=50, nullable = true)
     */
    private $emailResponsable;


    /*
     * @var \DateTime
     * @ORM\Column(name"updated_at", type="datetime", nullable=true)
     */
    private $UpdatedAt;

    /**
     * @ORM\ManyToMany(targetEntity=Lacunes::class, mappedBy="students")
     */
    private $lacunes;
    
    
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
     * Constructor
     */
    public function __construct()
    {
        $this->distinctions = new \Doctrine\Common\Collections\ArrayCollection();
        $this->lacunes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Students
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return Students
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set pere
     *
     * @param string $pere
     *
     * @return Students
     */
    public function setPere($pere)
    {
        $this->pere = $pere;

        return $this;
    }

    /**
     * Get pere
     *
     * @return string
     */
    public function getPere()
    {
        return $this->pere;
    }

    /**
     * Set mere
     *
     * @param string $mere
     *
     * @return Students
     */
    public function setMere($mere)
    {
        $this->mere = $mere;

        return $this;
    }

    /**
     * Get mere
     *
     * @return string
     */
    public function getMere()
    {
        return $this->mere;
    }

    /**
     * Set tuteur
     *
     * @param string $tuteur
     *
     * @return Students
     */
    public function setTuteur($tuteur)
    {
        $this->tuteur = $tuteur;

        return $this;
    }

    /**
     * Get tuteur
     *
     * @return string
     */
    public function getTuteur()
    {
        return $this->tuteur;
    }

    /**
     * Set matricule
     *
     * @param string $matricule
     *
     * @return Students
     */
    public function setMatricule($matricule)
    {
        $this->matricule = $matricule;

        return $this;
    }

    /**
     * Get matricule
     *
     * @return string
     */
    public function getMatricule()
    {
        return $this->matricule;
    }

    /**
     * Set telPere
     *
     * @param string $telPere
     *
     * @return Students
     */
    public function setTelPere($telPere)
    {
        $this->telPere = $telPere;

        return $this;
    }

    /**
     * Get telPere
     *
     * @return string
     */
    public function getTelPere()
    {
        return $this->telPere;
    }

    /**
     * Set telMere
     *
     * @param string $telMere
     *
     * @return Students
     */
    public function setTelMere($telMere)
    {
        $this->telMere = $telMere;

        return $this;
    }

    /**
     * Get telMere
     *
     * @return string
     */
    public function getTelMere()
    {
        return $this->telMere;
    }

    /**
     * Set telTuteur
     *
     * @param string $telTuteur
     *
     * @return Students
     */
    public function setTelTuteur($telTuteur)
    {
        $this->telTuteur = $telTuteur;

        return $this;
    }

    /**
     * Get telTuteur
     *
     * @return string
     */
    public function getTelTuteur()
    {
        return $this->telTuteur;
    }

    /**
     * Set emailPere
     *
     * @param string $emailPere
     *
     * @return Students
     */
    public function setEmailPere($emailPere)
    {
        $this->emailPere = $emailPere;

        return $this;
    }

    /**
     * Get emailPere
     *
     * @return string
     */
    public function getEmailPere()
    {
        return $this->emailPere;
    }

    /**
     * Set emailMere
     *
     * @param string $emailMere
     *
     * @return Students
     */
    public function setEmailMere($emailMere)
    {
        $this->emailMere = $emailMere;

        return $this;
    }

    /**
     * Get emailMere
     *
     * @return string
     */
    public function getEmailMere()
    {
        return $this->emailMere;
    }

    /**
     * Set emailTuteur
     *
     * @param string $emailTuteur
     *
     * @return Students
     */
    public function setEmailTuteur($emailTuteur)
    {
        $this->emailTuteur = $emailTuteur;

        return $this;
    }

    /**
     * Get emailTuteur
     *
     * @return string
     */
    public function getEmailTuteur()
    {
        return $this->emailTuteur;
    }

    /**
     * Set profPere
     *
     * @param string $profPere
     *
     * @return Students
     */
    public function setProfPere($profPere)
    {
        $this->profPere = $profPere;

        return $this;
    }

    /**
     * Get profPere
     *
     * @return string
     */
    public function getProfPere()
    {
        return $this->profPere;
    }

    /**
     * Set profMere
     *
     * @param string $profMere
     *
     * @return Students
     */
    public function setProfMere($profMere)
    {
        $this->profMere = $profMere;

        return $this;
    }

    /**
     * Get profMere
     *
     * @return string
     */
    public function getProfMere()
    {
        return $this->profMere;
    }

    /**
     * Set profTuteur
     *
     * @param string $profTuteur
     *
     * @return Students
     */
    public function setProfTuteur($profTuteur)
    {
        $this->profTuteur = $profTuteur;

        return $this;
    }

    /**
     * Get profTuteur
     *
     * @return string
     */
    public function getProfTuteur()
    {
        return $this->profTuteur;
    }

    /**
     * Set residenceParents
     *
     * @param string $residenceParents
     *
     * @return Students
     */
    public function setResidenceParents($residenceParents)
    {
        $this->residenceParents = $residenceParents;

        return $this;
    }

    /**
     * Get residenceParents
     *
     * @return string
     */
    public function getResidenceParents()
    {
        return $this->residenceParents;
    }

    /**
     * Set proche1
     *
     * @param string $proche1
     *
     * @return Students
     */
    public function setProche1($proche1)
    {
        $this->proche1 = $proche1;

        return $this;
    }

    /**
     * Get proche1
     *
     * @return string
     */
    public function getProche1()
    {
        return $this->proche1;
    }

    /**
     * Set telProche1
     *
     * @param string $telProche1
     *
     * @return Students
     */
    public function setTelProche1($telProche1)
    {
        $this->telProche1 = $telProche1;

        return $this;
    }

    /**
     * Get telProche1
     *
     * @return string
     */
    public function getTelProche1()
    {
        return $this->telProche1;
    }

    /**
     * Set proche2
     *
     * @param string $proche2
     *
     * @return Students
     */
    public function setProche2($proche2)
    {
        $this->proche2 = $proche2;

        return $this;
    }

    /**
     * Get proche2
     *
     * @return string
     */
    public function getProche2()
    {
        return $this->proche2;
    }

    /**
     * Set telProche2
     *
     * @param string $telProche2
     *
     * @return Students
     */
    public function setTelProche2($telProche2)
    {
        $this->telProche2 = $telProche2;

        return $this;
    }

    /**
     * Get telProche2
     *
     * @return string
     */
    public function getTelProche2()
    {
        return $this->telProche2;
    }

    /**
     * Set proche3
     *
     * @param string $proche3
     *
     * @return Students
     */
    public function setProche3($proche3)
    {
        $this->proche3 = $proche3;

        return $this;
    }

    /**
     * Get proche3
     *
     * @return string
     */
    public function getProche3()
    {
        return $this->proche3;
    }

    /**
     * Set telProche3
     *
     * @param string $telProche3
     *
     * @return Students
     */
    public function setTelProche3($telProche3)
    {
        $this->telProche3 = $telProche3;

        return $this;
    }

    /**
     * Get telProche3
     *
     * @return string
     */
    public function getTelProche3()
    {
        return $this->telProche3;
    }

    /**
     * Set nouveau
     *
     * @param boolean $nouveau
     *
     * @return Students
     */
    public function setNouveau($nouveau)
    {
        $this->nouveau = $nouveau;

        return $this;
    }

    /**
     * Get nouveau
     *
     * @return boolean
     */
    public function getNouveau()
    {
        return $this->nouveau;
    }

    /**
     * Set redoublant
     *
     * @param boolean $redoublant
     *
     * @return Students
     */
    public function setRedoublant($redoublant)
    {
        $this->redoublant = $redoublant;

        return $this;
    }

    /**
     * Get redoublant
     *
     * @return boolean
     */
    public function getRedoublant()
    {
        return $this->redoublant;
    }

    /**
     * Set etudeDossier
     *
     * @param boolean $etudeDossier
     *
     * @return Students
     */
    public function setEtudeDossier($etudeDossier)
    {
        $this->etudeDossier = $etudeDossier;

        return $this;
    }

    /**
     * Get etudeDossier
     *
     * @return boolean
     */
    public function getEtudeDossier()
    {
        return $this->etudeDossier;
    }

    /**
     * Set dateDeNaissance
     *
     * @param \DateTime $dateDeNaissance
     *
     * @return Students
     */
    public function setDateDeNaissance($dateDeNaissance)
    {
        $this->dateDeNaissance = $dateDeNaissance;

        return $this;
    }

    /**
     * Get dateDeNaissance
     *
     * @return \DateTime
     */
    public function getDateDeNaissance()
    {
        return $this->dateDeNaissance;
    }

    /**
     * Set anneeScolaire
     *
     * @param string $anneeScolaire
     *
     * @return Students
     */
    public function setAnneeScolaire($anneeScolaire)
    {
        $this->anneeScolaire = $anneeScolaire;

        return $this;
    }

    /**
     * Get anneeScolaire
     *
     * @return string
     */
    public function getAnneeScolaire()
    {
        return $this->anneeScolaire;
    }

    /**
     * Set lieuDeNaissance
     *
     * @param string $lieuDeNaissance
     *
     * @return Students
     */
    public function setLieuDeNaissance($lieuDeNaissance)
    {
        $this->lieuDeNaissance = $lieuDeNaissance;

        return $this;
    }

    /**
     * Get lieuDeNaissance
     *
     * @return string
     */
    public function getLieuDeNaissance()
    {
        return $this->lieuDeNaissance;
    }

    /**
     * Set cycle
     *
     * @param string $cycle
     *
     * @return Students
     */
    public function setCycle($cycle)
    {
        $this->cycle = $cycle;

        return $this;
    }

    /**
     * Get cycle
     *
     * @return string
     */
    public function getCycle()
    {
        return $this->cycle;
    }

    /**
     * Set serie
     *
     * @param string $serie
     *
     * @return Students
     */
    public function setSerie($serie)
    {
        $this->serie = $serie;

        return $this;
    }

    /**
     * Get serie
     *
     * @return string
     */
    public function getSerie()
    {
        return $this->serie;
    }

    /**
     * Set moyPassageClasse
     *
     * @param float $moyPassageClasse
     *
     * @return Students
     */
    public function setMoyPassageClasse($moyPassageClasse)
    {
        $this->moyPassageClasse = $moyPassageClasse;

        return $this;
    }

    /**
     * Get moyPassageClasse
     *
     * @return float
     */
    public function getMoyPassageClasse()
    {
        return $this->moyPassageClasse;
    }

    /**
     * Set rang
     *
     * @param integer $rang
     *
     * @return Students
     */
    public function setRang($rang)
    {
        $this->rang = $rang;

        return $this;
    }

    /**
     * Get rang
     *
     * @return integer
     */
    public function getRang()
    {
        return $this->rang;
    }

    /**
     * Set lastSchool
     *
     * @param string $lastSchool
     *
     * @return Students
     */
    public function setLastSchool($lastSchool)
    {
        $this->lastSchool = $lastSchool;

        return $this;
    }

    /**
     * Get lastSchool
     *
     * @return string
     */
    public function getLastSchool()
    {
        return $this->lastSchool;
    }

    /**
     * Set nameChefLastSchool
     *
     * @param string $nameChefLastSchool
     *
     * @return Students
     */
    public function setNameChefLastSchool($nameChefLastSchool)
    {
        $this->nameChefLastSchool = $nameChefLastSchool;

        return $this;
    }

    /**
     * Get nameChefLastSchool
     *
     * @return string
     */
    public function getNameChefLastSchool()
    {
        return $this->nameChefLastSchool;
    }

    /**
     * Set sexe
     *
     * @param string $sexe
     *
     * @return Students
     */
    public function setSexe($sexe)
    {
        $this->sexe = $sexe;

        return $this;
    }

    /**
     * Get sexe
     *
     * @return string
     */
    public function getSexe()
    {
        return $this->sexe;
    }

    /**
     * Set dateCreate
     *
     * @param \DateTime $dateCreate
     *
     * @return Students
     */
    public function setDateCreate($dateCreate)
    {
        $this->dateCreate = $dateCreate;

        return $this;
    }

    /**
     * Get dateCreate
     *
     * @return \DateTime
     */
    public function getDateCreate()
    {
        return $this->dateCreate;
    }

    /**
     * Set groupeSanguin
     *
     * @param string $groupeSanguin
     *
     * @return Students
     */
    public function setGroupeSanguin($groupeSanguin)
    {
        $this->groupeSanguin = $groupeSanguin;

        return $this;
    }

    /**
     * Get groupeSanguin
     *
     * @return string
     */
    public function getGroupeSanguin()
    {
        return $this->groupeSanguin;
    }

    /**
     * Set pathogieParticuliere
     *
     * @param string $pathogieParticuliere
     *
     * @return Students
     */
    public function setPathogieParticuliere($pathogieParticuliere)
    {
        $this->pathogieParticuliere = $pathogieParticuliere;

        return $this;
    }

    /**
     * Get pathogieParticuliere
     *
     * @return string
     */
    public function getPathogieParticuliere()
    {
        return $this->pathogieParticuliere;
    }

    /**
     * Set allergieAlimentaire
     *
     * @param string $allergieAlimentaire
     *
     * @return Students
     */
    public function setAllergieAlimentaire($allergieAlimentaire)
    {
        $this->allergieAlimentaire = $allergieAlimentaire;

        return $this;
    }

    /**
     * Get allergieAlimentaire
     *
     * @return string
     */
    public function getAllergieAlimentaire()
    {
        return $this->allergieAlimentaire;
    }

    /**
     * Set allergieMedicamenteuse
     *
     * @param string $allergieMedicamenteuse
     *
     * @return Students
     */
    public function setAllergieMedicamenteuse($allergieMedicamenteuse)
    {
        $this->allergieMedicamenteuse = $allergieMedicamenteuse;

        return $this;
    }

    /**
     * Get allergieMedicamenteuse
     *
     * @return string
     */
    public function getAllergieMedicamenteuse()
    {
        return $this->allergieMedicamenteuse;
    }

    /**
     * Set dispense
     *
     * @param string $dispense
     *
     * @return Students
     */
    public function setDispense($dispense)
    {
        $this->dispense = $dispense;

        return $this;
    }

    /**
     * Get dispense
     *
     * @return string
     */
    public function getDispense()
    {
        return $this->dispense;
    }

    /**
     * Set medecinFamiliale
     *
     * @param string $medecinFamiliale
     *
     * @return Students
     */
    public function setMedecinFamiliale($medecinFamiliale)
    {
        $this->medecinFamiliale = $medecinFamiliale;

        return $this;
    }

    /**
     * Get medecinFamiliale
     *
     * @return string
     */
    public function getMedecinFamiliale()
    {
        return $this->medecinFamiliale;
    }

    /**
     * Set telMedecinFamiliale
     *
     * @param string $telMedecinFamiliale
     *
     * @return Students
     */
    public function setTelMedecinFamiliale($telMedecinFamiliale)
    {
        $this->telMedecinFamiliale = $telMedecinFamiliale;

        return $this;
    }

    /**
     * Get telMedecinFamiliale
     *
     * @return string
     */
    public function getTelMedecinFamiliale()
    {
        return $this->telMedecinFamiliale;
    }

    /**
     * Set assuranceFamille
     *
     * @param string $assuranceFamille
     *
     * @return Students
     */
    public function setAssuranceFamille($assuranceFamille)
    {
        $this->assuranceFamille = $assuranceFamille;

        return $this;
    }

    /**
     * Get assuranceFamille
     *
     * @return string
     */
    public function getAssuranceFamille()
    {
        return $this->assuranceFamille;
    }

    /**
     * Set hopitalAgree
     *
     * @param string $hopitalAgree
     *
     * @return Students
     */
    public function setHopitalAgree($hopitalAgree)
    {
        $this->hopitalAgree = $hopitalAgree;

        return $this;
    }

    /**
     * Get hopitalAgree
     *
     * @return string
     */
    public function getHopitalAgree()
    {
        return $this->hopitalAgree;
    }

    /**
     * Set rhesus
     *
     * @param string $rhesus
     *
     * @return Students
     */
    public function setRhesus($rhesus)
    {
        $this->rhesus = $rhesus;

        return $this;
    }

    /**
     * Get rhesus
     *
     * @return string
     */
    public function getRhesus()
    {
        return $this->rhesus;
    }

    /**
     * Set inaptitude
     *
     * @param string $inaptitude
     *
     * @return Students
     */
    public function setInaptitude($inaptitude)
    {
        $this->inaptitude = $inaptitude;

        return $this;
    }

    /**
     * Get inaptitude
     *
     * @return string
     */
    public function getInaptitude()
    {
        return $this->inaptitude;
    }

    /**
     * Set filename
     *
     * @param string $filename
     *
     * @return Students
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
     * Set responsable
     *
     * @param string $responsable
     *
     * @return Students
     */
    public function setResponsable($responsable)
    {
        $this->responsable = $responsable;

        return $this;
    }

    /**
     * Get responsable
     *
     * @return string
     */
    public function getResponsable()
    {
        return $this->responsable;
    }

    /**
     * Set telResponsable
     *
     * @param string $telResponsable
     *
     * @return Students
     */
    public function setTelResponsable($telResponsable)
    {
        $this->telResponsable = $telResponsable;

        return $this;
    }

    /**
     * Get telResponsable
     *
     * @return string
     */
    public function getTelResponsable()
    {
        return $this->telResponsable;
    }

    /**
     * Set emailResponsable
     *
     * @param string $emailResponsable
     *
     * @return Students
     */
    public function setEmailResponsable($emailResponsable)
    {
        $this->emailResponsable = $emailResponsable;

        return $this;
    }

    /**
     * Get emailResponsable
     *
     * @return string
     */
    public function getEmailResponsable()
    {
        return $this->emailResponsable;
    }

    /**
     * Set classes
     *
     * @param \App\Entity\Classes $classes
     *
     * @return Students
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
     * Add distinction
     *
     * @param \App\Entity\Distinction $distinction
     *
     * @return Students
     */
    public function addDistinction(\App\Entity\Distinction $distinction)
    {
        $this->distinctions[] = $distinction;

        return $this;
    }

    /**
     * Remove distinction
     *
     * @param \App\Entity\Distinction $distinction
     */
    public function removeDistinction(\App\Entity\Distinction $distinction)
    {
        $this->distinctions->removeElement($distinction);
    }

    /**
     * Get distinctions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDistinctions()
    {
        return $this->distinctions;
    }

    /**
     * Add lacune
     *
     * @param \App\Entity\Lacunes $lacune
     *
     * @return Students
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
     * 
     */
    
    public function updateVerify($name,$data) {
        if ($this->$data == $data){
            mailParent($name,$data);
        }
    }
    /**
     * 
     */
    
    public function mailParent($name, $data)
    {
        
        $twig = new Environment(new FilesystemLoader('./views'));
        $message = (new \Swift_Message('Notification rapmis'))
        ->setFrom('rapmis@habitechsolution.com')
        ->setTo($this->getEmailResponsable())
        ->setTo($this->getEmailPere())
        ->setTo($this->getEmailMere())
        ->setTo('pascalraiso@gmail.com')
        ->setBody(
            $twig->render(
                // app/Resources/view   s/Emails/registration.html.twig
                'Mail/parent.html.twig',[
                    'student' => $this,
                    'name' => $name,
                    'data' => $data                ]
            ),
            'text/html'
        );

        $mailer = new \Swift_Mailer(new \Swift_SmtpTransport('webmail.habitechsolution.com', 25));
    $mailer->send($message);
    $this->setUpdatedAt(new \DateTime());


    }
    
    
    /**
     * @ORM\PreUpdate
     */
    
        public function updateDate(){
        
        $table = array_map('strval',array($this->emailResponsable,$this->emailMere,$this->emailPere));
        $tab = array_filter($table);
        /*
        $twig = new Environment(new FilesystemLoader('./views'));
        $message = (new Swift_Message('Notification de Rapmis'))
        ->setFrom('rapmis@habitechsolution.com')
        ->setTo($tab)
        ->setBody(
            $twig->render(
                // app/Resources/views/Emails/registration.html.twig
                'Mail/mail.html.twig',[
                    'student' => $this
                ]
            ),
            'text/html'
        )
                */
;
$transport = new EsmtpTransport('habitechsolution.com',465);
$mailer = new \Symfony\Component\Mailer\Mailer($transport);
                
$email = (new TemplatedEmail())
            ->from('rapmis@habitechsolution.com')
            ->to(...$tab)
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Notification de mise Ã  jour de Votre enfant sur Rapmis!')

        ->htmlTemplate('mail/mail.html.twig')
          ->context([
        'student' => $this,
              
    ])
            ->text("Nous voulons vous informer que les informations de votre enfant $this->name de la classe de $this->classes ont Ã©tÃ© changÃ©,Veuillez vous connecter sur rapmis pour voir les changement.")
            ->html("<p>Nous voulons vous informer que les informations de votre enfant $this->name de la classe de $this->classes ont Ã©tÃ© changeÃ©,Veuillez vous connecter sur rapmis pour voir les changement.</p>");
                

        $mailer->send($email);
        // you can remove the following code if you don't define a text version for your emails
        
    ;
    /*
    $mailer = new \Swift_Mailer(new \Swift_SmtpTransport('webmail.habitechsolution.com', 25));
    $mailer->send($message);
    $this->setUpdatedAt(new \DateTime());
    */

    // or, you can also fetch the mailer service this way
    // $this->get('mailer')->send($message);

        
}
    
    
    
    
    
    /*
    public function updateDate(){
        
        $table = array_map('strval',array($this->emailResponsable,$this->emailMere,$this->emailPere,'pascalraiso@gmail.com'));
        $tab = array_filter($table);
        /*
        $twig = new Environment(new FilesystemLoader('./views'));
        $message = (new Swift_Message('Notification de Rapmis'))
        ->setFrom('rapmis@habitechsolution.com')
        ->setTo($tab)
        ->setBody(
            $twig->render(
                // app/Resources/views/Emails/registration.html.twig
                'Mail/mail.html.twig',[
                    'student' => $this
                ]
            ),
            'text/html'
        )
                */
/*
$transport = new EsmtpTransport('habitechsolution.com',465 );
$mailer = new \Symfony\Component\Mailer\Mailer($transport);
                
$email = (new TemplatedEmail())
            ->from('rapmis@habitechsolution.com')
            ->to(...$tab)
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Notification de mise à jour de Votre enfant sur Rapmis!')

        ->htmlTemplate('mail/mail.html.twig')
          ->context([
        'student' => $this,
              
    ])
            ->text("Nous voulons vous informer que les informations de votre enfant $this->name de la classe de $this->classes ont été changé,Veuillez vous connecter sur rapmis pour voir les changement.")
            ->html("<p>Nous voulons vous informer que les informations de votre enfant $this->name de la classe de $this->classes ont été changeé,Veuillez vous connecter sur rapmis pour voir les changement.</p>");
                

        $mailer->send($email);
        // you can remove the following code if you don't define a text version for your emails
        
    ;
    /*$mailer = new \Swift_Mailer(new \Swift_SmtpTransport('webmail.habitechsolution.com', 25));
    $mailer->send($message);
    $this->setUpdatedAt(new \DateTime());*/

    // or, you can also fetch the mailer service this way
    // $this->get('mailer')->send($message);

        
//}
    
    
    
    
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
     * Set inapte
     *
     * @param string $inapte
     *
     * @return Students
     */
    public function setInapte($inapte)
    {
        $this->inapte = $inapte;

        return $this;
    }

    /**
     * Get inapte
     *
     * @return string
     */
    public function getInapte()
    {
        return $this->inapte;
    }
}
