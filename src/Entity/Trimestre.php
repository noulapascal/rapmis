<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trimestre
 *
 * @ORM\Table(name="trimestre")
 * @ORM\Entity(repositoryClass="App\Repository\TrimestreRepository")
 */
class Trimestre
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
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="notePremiereSequence", type="string", length=255)
     */
    private $notePremiereSequence;

    /**
     * @var string
     *
     * @ORM\Column(name="noteDeuxiemeSequence", type="string", length=255, nullable=true)
     */
    private $noteDeuxiemeSequence;

    /**
     * @var string
     *
     * @ORM\Column(name="MoyenneTrimestrielle", type="string", length=255, nullable=true)
     */
    private $moyenneTrimestrielle;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\DecisionConseilDeClasse", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $decision;
    
    
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
     * @return Trimestre
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
     * Set description
     *
     * @param string $description
     *
     * @return Trimestre
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

    /**
     * Set notePremiereSequence
     *
     * @param string $notePremiereSequence
     *
     * @return Trimestre
     */
    public function setNotePremiereSequence($notePremiereSequence)
    {
        $this->notePremiereSequence = $notePremiereSequence;

        return $this;
    }

    /**
     * Get notePremiereSequence
     *
     * @return string
     */
    public function getNotePremiereSequence()
    {
        return $this->notePremiereSequence;
    }

    /**
     * Set noteDeuxiemeSequence
     *
     * @param string $noteDeuxiemeSequence
     *
     * @return Trimestre
     */
    public function setNoteDeuxiemeSequence($noteDeuxiemeSequence)
    {
        $this->noteDeuxiemeSequence = $noteDeuxiemeSequence;

        return $this;
    }

    /**
     * Get noteDeuxiemeSequence
     *
     * @return string
     */
    public function getNoteDeuxiemeSequence()
    {
        return $this->noteDeuxiemeSequence;
    }

    /**
     * Set moyenneTrimestrielle
     *
     * @param string $moyenneTrimestrielle
     *
     * @return Trimestre
     */
    public function setMoyenneTrimestrielle($moyenneTrimestrielle)
    {
        $this->moyenneTrimestrielle = $moyenneTrimestrielle;

        return $this;
    }

    /**
     * Get moyenneTrimestrielle
     *
     * @return string
     */
    public function getMoyenneTrimestrielle()
    {
        return $this->moyenneTrimestrielle;
    }

    /**
     * Set decision
     *
     * @param \App\Entity\DecisionConseilDeClasse $decision
     *
     * @return Trimestre
     */
    public function setDecision(\App\Entity\DecisionConseilDeClasse $decision)
    {
        $this->decision = $decision;

        return $this;
    }

    /**
     * Get decision
     *
     * @return \App\Entity\DecisionConseilDeClasse
     */
    public function getDecision()
    {
        return $this->decision;
    }
}
