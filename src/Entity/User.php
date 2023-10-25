<?php

namespace App\Entity;

use App\Entity\Etablissements;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use App\Grafikat\UploadBundle\Annotation\Uploadable;
use App\Grafikat\UploadBundle\Annotation\UploadableField;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"username"}, message="There is already an account with this username")
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $username;


    /**
     * @ORM\Column(type="string", length=180, unique=true, nullable=true)
     * @Assert\Email
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;
    
    
     /**
     * @ORM\Column(type="string", length=25)
     *
     * @Assert\Length(
     *     min=9,
     *     max=25,
     *     minMessage="The number is too short.",
     *     maxMessage="The number is too long.",
     * )
      @Assert\Positive
     */
    
    private $phoneNumber;

    
    /**
     * Plain password. Used for model validation. Must not be persisted.
     *
     * @var string
     */
    private $plainPassword;

    /**
     * 
     * 
     */
    
    private $typeDeCompte;
    /**
    * @ORM\Column(type="string", length=255,nullable=true)
    */
    
   protected $zone;
   
   
    /**
    * @ORM\Column(type="string", length=255,nullable=true)
    */
    
   protected $enabled;
   
   
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Etablissements", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $etablissements;
   
   

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Teacher", cascade={"persist", "remove"})
     * @ORM\JoinColumn( nullable=true, onDelete="CASCADE")
     */
    protected $teacher;
   

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Staff", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    protected $staff;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Type_etablissements", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    protected $typeEtablissement;

    
        /**
     * @var string|null
     *
     * @ORM\Column(name="photo_de_profil", type="string", length=255, nullable = true)
     */
    private $filename;
       /**
     * @UploadableField(filename = "filename", path="uploads/user", nullable = true)
     */
    private $photoDeProfil;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $locale;
    
    
    /**
    * @ORM\Column(type="string", length=255,nullable=true)
    */
    
   protected $obedience;
   

  

    

    
    

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }
    
    
    public function getPhotoDeProfil() {
        return $this->photoDeProfil;   
    }
    
    
    public function setPhotoDeProfil($photoDeProfil)
    {
        $this->photoDeProfil=$photoDeProfil;
    }
    
    
    public function getPlainPassword(): string
    {
        return (string) $this->plainPassword;
    }

    public function setPlainPassword(string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getZone(): ?string
    {
        return $this->zone;
    }

    public function setZone(?string $zone): self
    {
        $this->zone = $zone;

        return $this;
    }

    public function getTeacher(): ?Teacher
    {
        return $this->teacher;
    }

    public function setTeacher(?Teacher $teacher): self
    {
        $this->teacher = $teacher;

        return $this;
    }

    public function getTypeEtablissement(): ?Type_etablissements
    {
        return $this->typeEtablissement;
    }

    public function setTypeEtablissement(?Type_etablissements $typeEtablissement): self
    {
        $this->typeEtablissement = $typeEtablissement;

        return $this;
    }

    public function getEtablissements(): ?Etablissements
    {
        return $this->etablissements;
    }

    public function setEtablissements(?Etablissements $etablissements): self
    {
        $this->etablissements = $etablissements;

        return $this;
    }
     public function getTypeDeCompte() {
        return $this->typeDeCompte;   
    }
    public function setTypeDeCompte($typeDeCompte)
    {
        $this->typeDeCompte=$typeDeCompte;
    }

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(?string $filename): self
    {
        $this->filename = $filename;

        return $this;
    }

    public function getStaff(): ?Staff
    {
        return $this->staff;
    }

    public function setStaff(?Staff $staff): self
    {
        $this->staff = $staff;

        return $this;
    }

    public function getEnabled(): ?string
    {
        return $this->enabled;
    }

    public function setEnabled(?string $enabled): self
    {
        $this->enabled = $enabled;

        return $this;
    }

    public function getLocale(): ?string
    {
        return $this->locale;
    }

    public function setLocale(?string $locale): self
    {
        $this->locale = $locale;

        return $this;
    }

    public function getObedience(): ?string
    {
        return $this->obedience;
    }


    public function setObedience(?string $obedience): self
    {
        $this->obedience = $obedience;

        return $this;
    }
    
        public function __toString()
    {
        return $this->getUsername();
    }
    
}
