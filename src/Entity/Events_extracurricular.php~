<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Events_extracurricular
 *
 * @ORM\Table(name="events_extracurricular")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Events_extracurricularRepository")
 */
class Events_extracurricular
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
     * @var string|null
     *
     * @ORM\Column(name="role", type="string", length=255, nullable=true)
     */
    private $role;

    /**
     * @var string|null
     *
     * @ORM\Column(name="prime", type="string", length=255, nullable=true)
     */
    private $prime;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Students", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $students;

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
     * @return events_extracurricular
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
     * Set role.
     *
     * @param string|null $role
     *
     * @return events_extracurricular
     */
    public function setRole($role = null)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role.
     *
     * @return string|null
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @return null|string
     */
    public function getPrime()
    {
        return $this->prime;
    }

    /**
     * @param null|string $prime
     */
    public function setPrime($prime)
    {
        $this->prime = $prime;
    }


    /**
     * @return null|string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param null|string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

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


    public function __toString()
    {
        // TODO: Implement __toString() method.
        return $this->getName();
    }


}
