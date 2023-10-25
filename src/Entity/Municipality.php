<?php

namespace App\Entity;

use App\Repository\MunicipalityRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MunicipalityRepository::class)
 */
class Municipality
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=Subdivision::class, inversedBy="municipality", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $subdivision;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSubdivision(): ?Subdivision
    {
        return $this->subdivision;
    }

    public function setSubdivision(Subdivision $subdivision): self
    {
        $this->subdivision = $subdivision;

        return $this;
    }
}
