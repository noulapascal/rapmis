<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Subdivision
 *
 * @ORM\Table(name="subdivision")
 * @ORM\Entity(repositoryClass="App\Repository\SubdivisionRepository")
 */
class Subdivision
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
     * @var guid
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\City", inversedBy="subdivisions")
     * @ORM\JoinColumn( nullable=true, onDelete="CASCADE")
     */
    private $city;

    /**
     * @ORM\OneToOne(targetEntity=Municipality::class, mappedBy="subdivision", cascade={"persist", "remove"})
     */
    private $municipality;
    
    
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Department", inversedBy="city")
     *
     */



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
     * @return Subdivision
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
     * Set city
     *
     * @param \App\Entity\C $city
     *
     * @return Subdivision
     */
    public function setCity(\App\Entity\City $city = null)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return \App\Entity\City
     */
    public function getCity()
    {
        return $this->city;
    }
    
    public function __toString() {
        return $this->getName();
        
    }

    public function getMunicipality(): ?Municipality
    {
        return $this->municipality;
    }

    public function setMunicipality(Municipality $municipality): self
    {
        $this->municipality = $municipality;

        // set the owning side of the relation if necessary
        if ($municipality->getSubdivision() !== $this) {
            $municipality->setSubdivision($this);
        }

        return $this;
    }
}
