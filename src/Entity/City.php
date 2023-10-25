<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * City
 *
 * @ORM\Table(name="city")
 * @ORM\Entity(repositoryClass="App\Repository\CityRepository")
 */
class City
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
     * @var float|null
     *
     * @ORM\Column(name="longitude", type="float", nullable=true)
     */
    private $longitude;

    /**
     * @var float|null
     *
     * @ORM\Column(name="latitude", type="float", nullable=true)
     */
    private $latitude;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Department", inversedBy="city")
     * @ORM\JoinColumn( nullable=true, onDelete="CASCADE")
     */
    private $departments;
    
    
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Subdivision", mappedBy="city")
     */
    private $subdivisions;



    /**
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
     * @return City
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
     * Set longitude.
     *
     * @param float|null $longitude
     *
     * @return City
     */
    public function setLongitude($longitude = null)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude.
     *
     * @return float|null
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set latitude.
     *
     * @param float|null $latitude
     *
     * @return City
     */
    public function setLatitude($latitude = null)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude.
     *
     * @return float|null
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @return mixed
     */
    public function getDepartments()
    {
        return $this->departments;
    }

    public function __toString()
    {
        // TODO: Implement __toString() method.
        return $this->getName();
    }

    /**
     * Set departments.
     *
     * @param \App\Entity\Department|null $departments
     *
     * @return City
     */
    public function setDepartments(\App\Entity\Department $departments = null)
    {
        $this->departments = $departments;

        return $this;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->subdivisions = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add subdivision
     *
     * @param \App\Entity\Subdivision $subdivision
     *
     * @return City
     */
    public function addSubdivision(\App\Entity\Subdivision $subdivision)
    {
        $this->subdivisions[] = $subdivision;

        return $this;
    }

    /**
     * Remove subdivision
     *
     * @param \App\Entity\Subdivision $subdivision
     */
    public function removeSubdivision(\App\Entity\Subdivision $subdivision)
    {
        $this->subdivisions->removeElement($subdivision);
    }

    /**
     * Get subdivisions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSubdivisions()
    {
        return $this->subdivisions;
    }
}
