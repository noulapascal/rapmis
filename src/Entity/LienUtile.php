<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LienUtile
 *
 * @ORM\Table(name="lien_utile")
 * @ORM\Entity(repositoryClass="App\Repository\LienUtileRepository")
 */
class LienUtile
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
     * @ORM\Column(name="linkToWebsite", type="string", length=255)
     */
    private $linkToWebsite;


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
     * @return LienUtile
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
     * Set linkToWebsite
     *
     * @param string $linkToWebsite
     *
     * @return LienUtile
     */
    public function setLinkToWebsite($linkToWebsite)
    {
        $this->linkToWebsite = $linkToWebsite;

        return $this;
    }

    /**
     * Get linkToWebsite
     *
     * @return string
     */
    public function getLinkToWebsite()
    {
        return $this->linkToWebsite;
    }
}
