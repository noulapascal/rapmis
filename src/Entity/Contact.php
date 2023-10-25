<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Contact
 *
 * @ORM\Table(name="contact")
 * @ORM\Entity(repositoryClass="App\Repository\ContactRepository")
 */
class Contact
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
     * @ORM\Column(name="numeroDeTelephone", type="string", length=255, nullable=true)
     */
    private $numeroDeTelephone;

    /**
     * @var string
     *
     * @ORM\Column(name="adresseMail", type="string", length=255, nullable=true)
     */
    private $adresseMail;

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="text", nullable=true)
     */
    private $message;


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
     * Set name
     *
     * @param string $name
     *
     * @return Contact
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
     * Set numeroDeTelephone
     *
     * @param string $numeroDeTelephone
     *
     * @return Contact
     */
    public function setNumeroDeTelephone($numeroDeTelephone)
    {
        $this->numeroDeTelephone = $numeroDeTelephone;

        return $this;
    }

    /**
     * Get numeroDeTelephone
     *
     * @return string
     */
    public function getNumeroDeTelephone()
    {
        return $this->numeroDeTelephone;
    }

    /**
     * Set adresseMail
     *
     * @param string $adresseMail
     *
     * @return Contact
     */
    public function setAdresseMail($adresseMail)
    {
        $this->adresseMail = $adresseMail;

        return $this;
    }

    /**
     * Get adresseMail
     *
     * @return string
     */
    public function getAdresseMail()
    {
        return $this->adresseMail;
    }

    /**
     * Set message
     *
     * @param string $message
     *
     * @return Contact
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }
}
