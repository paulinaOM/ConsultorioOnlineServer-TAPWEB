<?php

namespace App\Entity;

use App\Repository\ChronicDiseaseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ChronicDiseaseRepository::class)
 */
class ChronicDisease
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\OneToMany(targetEntity="PatientDisease", mappedBy="disease")
     */
    private $patientDisease;


    /**
     * @ORM\Column(type="string", length=100)
     */
    private $description;
    /**
     * Disease constructor.
     */
    public function __construct()
    {
        $this->patientDisease = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
