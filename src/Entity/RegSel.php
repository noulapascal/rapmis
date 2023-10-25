<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * RegSel
 *
 * @ORM\Table(name="reg_sel")
 * @ORM\Entity(repositoryClass="App\Repository\RegSelRepository")
 */
class RegSel
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
     * @ORM\ManyToOne(targetEntity="App\Entity\city", inversedBy="city")
     * @Assert\NotBlank
     */
    private $city;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Regions", inversedBy="city")
     * @Assert\NotBlank
     */
    private $regions;
  
    


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
     * Set regions
     *
     * @param \App\Entity\Regions $regions
     *
     * @return RegSel
     */
    public function setRegions(\App\Entity\Regions $regions = null)
    {
        $this->regions = $regions;

        return $this;
    }

    /**
     * Get regions
     *
     * @return \App\Entity\Regions
     */
    public function getRegions()
    {
        return $this->regions;
    }

    /**
     * Set city
     *
     * @param \App\Entity\city $city
     *
     * @return RegSel
     */
    public function setCity(\App\Entity\city $city = null)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return \App\Entity\city
     */
    public function getCity()
    {
        return $this->city;
    }
}
