<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Students;

/**
 * Distinction
 *
 * @ORM\Table(name="distinction")
 * @ORM\Entity(repositoryClass="App\Repository\DistinctionRepository")
 */
class Distinction
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Students",cascade={"persist"})
     * @ORM\JoinColumn( nullable=true, onDelete="CASCADE")
     */
    private $student ;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updateAt;

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
     * @return Distinction
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
     * @return Distinction
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
     * Add student
     *
     * @param \App\Entity\Students $student
     *
     * @return Distinction
     */
    public function addStudent(\App\Entity\Students $student)
    {
        $this->student[] = $student;

        return $this;
    }

    /**
     * Remove student
     *
     * @param \App\Entity\Students $student
     */
    public function removeStudent(\App\Entity\Students $student)
    {
        $this->student->removeElement($student);
    }

    /**
     * Get student
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getStudent()
    {
        return $this->student;
    }

    /**
     * Set student
     *
     * @param \App\Entity\Students $student
     *
     * @return Distinction
     */
    public function setStudent(\App\Entity\Students $student = null)
    {
        $this->student = $student;

        return $this;
    }

    public function getUpdateAt(): ?\DateTimeInterface
    {
        return $this->updateAt;
    }

    public function setUpdateAt(?\DateTimeInterface $updateAt): self
    {
        $this->updateAt = $updateAt;

        return $this;
    }
}
