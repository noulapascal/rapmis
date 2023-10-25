<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Regions
 *
 * @ORM\Table(name="regions")
 * @ORM\Entity(repositoryClass="App\Repository\RegionsRepository")
 */
class Regions
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
     * @ORM\Column(name="chef_lieu", type="string", length=255)
     */
    private $chefLieu;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Country", inversedBy="regions")
     *
     */
    private $country;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Department", mappedBy ="regions")
     *
     */
    private $departments;


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
     * @return Regions
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
     * Set chefLieu.
     *
     * @param string $chefLieu
     *
     * @return Regions
     */
    public function setChefLieu($chefLieu)
    {
        $this->chefLieu = $chefLieu;

        return $this;
    }

    /**
     * Get chefLieu.
     *
     * @return string
     */
    public function getChefLieu()
    {
        return $this->chefLieu;
    }

    public function __toString()
    {
        // TODO: Implement __toString() method.
        return $this->getName();
    }


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->departments = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add department.
     *
     * @param \App\Entity\Department $department
     *
     * @return Regions
     */
    public function addDepartment(\App\Entity\Department $department)
    {
        $this->departments[] = $department;

        return $this;
    }

    /**
     * Remove department.
     *
     * @param \App\Entity\Department $department
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeDepartment(\App\Entity\Department $department)
    {
        return $this->departments->removeElement($department);
    }

    /**
     * Get departments.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDepartments()
    {
        return $this->departments;
    }



    /**
     * Set country.
     *
     * @param \App\Entity\Country|null $country
     *
     * @return Regions
     */
    public function setCountry(\App\Entity\Country $country = null)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCountry()
    {
        return $this->country;
    }
}
