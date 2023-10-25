<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Facteurs_disciplinaires
 *
 * @ORM\Table(name="facteurs_disciplinaires")
 * @ORM\Entity(repositoryClass="App\Repository\Facteurs_disciplinairesRepository")
 */
class Facteurs_disciplinaires
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
     * @ORM\Column(name="motif", type="string", length=255)
     */
    private $motif;

    /**
     * @var int|null
     *
     * @ORM\Column(name="compteur", type="integer", nullable=true)
     */
    private $compteur;

    /**
     * @var string
     *
     * @ORM\Column(name="autre", type="string", length=255, nullable=true)
     */
    private $autre;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_motif", type="datetime", nullable=true)
     */
    private $dateMotif;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Students", cascade={"persist"})
     * @ORM\JoinColumn( nullable=false, onDelete="CASCADE")
     */
    private $students;

    /**
     * lieu où s'est déroulé l'infraction
     * @ORM\ManyToOne(targetEntity="App\Entity\Matieres", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $lieu;


    /**
     * @return mixed
     */
    public function getStudents()
    {
        return $this->students;
    }

    /**
     * @param mixed $students
     */
    public function setStudents($students)
    {
        $this->students = $students;
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
     * Set motif.
     *
     * @param string $motif
     *
     * @return Facteurs_disciplinaires
     */
    public function setMotif($motif)
    {
        $this->motif = $motif;

        return $this;
    }

    /**
     * Get motif.
     *
     * @return string
     */
    public function getMotif()
    {
        return $this->motif;
    }

    /**
     * Set compteur.
     *
     * @param int|null $compteur
     *
     * @return Facteurs_disciplinaires
     */
    public function setCompteur($compteur = null)
    {
        $this->compteur = $compteur;

        return $this;
    }

    /**
     * Get compteur.
     *
     * @return int|null
     */
    public function getCompteur()
    {
        return $this->compteur;
    }

    /**
     * Set description.
     *
     * @param string|null $description
     *
     * @return Facteurs_disciplinaires
     */
    public function setDescription($description = null)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string|null
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set dateMotif.
     *
     * @param \DateTime|null $dateMotif
     *
     * @return Facteurs_disciplinaires
     */
    public function setDateMotif($dateMotif = null)
    {
        $this->dateMotif = $dateMotif;

        return $this;
    }

    /**
     * Get dateMotif.
     *
     * @return \DateTime|null
     */
    public function getDateMotif()
    {
        return $this->dateMotif;
    }

    /**
     * @return string
     */
    public function getAutre()
    {
        return $this->autre;
    }

    /**
     * @param string $autre
     */
    public function setAutre(string $autre)
    {
        $this->autre = $autre;
    }

    /**
     * @return mixed
     */
    public function getLieu()
    {
        return $this->lieu;
    }

    /**
     * @param mixed $lieu
     */
    public function setLieu($lieu)
    {
        $this->lieu = $lieu;
    }


}
