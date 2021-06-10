<?php

namespace App\Entity;

use App\Repository\SurgeryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SurgeryRepository::class)
 */
class Surgery
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\OneToMany(targetEntity="PatientSurgery", mappedBy="surgery")
     */
    private $patientSurgery;


    /**
     * @ORM\Column(type="string", length=100)
     */
    private $description;
    /**
     * Surgery constructor.
     */
    public function __construct()
    {
        $this->patientSurgery = new ArrayCollection();
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
