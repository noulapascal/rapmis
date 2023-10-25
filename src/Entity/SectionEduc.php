<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * SectionEduc
 *
 * @ORM\Table(name="section_educ")
 * @ORM\Entity(repositoryClass="App\Repository\SectionEducRepository")
 */
class SectionEduc
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
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\SysEduc", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $syseduc;

    /**
     * @return mixed
     */
    public function getSyseduc()
    {
        return $this->syseduc;
    }

    /**
     * @param mixed $syseduc
     */
    public function setSyseduc($syseduc)
    {
        $this->syseduc = $syseduc;
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
     * Set name.
     *
     * @param string $name
     *
     * @return SectionEduc
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
     * Set description.
     *
     * @param string $description
     *
     * @return SectionEduc
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
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
        $this->syseduc = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add syseduc.
     *
     * @param \App\Entity\SysEduc $syseduc
     *
     * @return SectionEduc
     */
    public function addSyseduc(\App\Entity\SysEduc $syseduc)
    {
        $this->syseduc[] = $syseduc;

        return $this;
    }

    /**
     * Remove syseduc.
     *
     * @param \App\Entity\SysEduc $syseduc
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeSyseduc(\App\Entity\SysEduc $syseduc)
    {
        return $this->syseduc->removeElement($syseduc);
    }
}
