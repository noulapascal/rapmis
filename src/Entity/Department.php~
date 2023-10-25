<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Department
 *
 * @ORM\Table(name="department")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DepartmentRepository")
 */
class Department
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Regions", inversedBy="departments")
     *
     */
    private $regions;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\City", mappedBy="departments")
     */
    private $city;

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
     * @return Department
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
     * @return Department
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

    /**
     * @return mixed
     */
    public function getRegions()
    {
        return $this->regions;
    }

    /**
     * @param mixed $regions
     */
    public function setRegions($regions)
    {
        $this->regions = $regions;
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
        $this->city = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add city.
     *
     * @param \AppBundle\Entity\City $city
     *
     * @return Department
     */
    public function addCity(\AppBundle\Entity\City $city)
    {
        $this->city[] = $city;

        return $this;
    }

    /**
     * Remove city.
     *
     * @param \AppBundle\Entity\City $city
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeCity(\AppBundle\Entity\City $city)
    {
        return $this->city->removeElement($city);
    }

    /**
     * Get city.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCity()
    {
        return $this->city;
    }
}
