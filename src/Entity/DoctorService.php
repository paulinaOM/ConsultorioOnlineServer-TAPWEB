<?php

namespace App\Entity;

use App\Repository\DoctorServiceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DoctorServiceRepository::class)
 */
class DoctorService
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\ManyToOne(targetEntity="Doctor", inversedBy="doctorService")
     * @ORM\JoinColumn(name="id_doctor", referencedColumnName="id", nullable=false)
     */
    private $doctor;
    /**
     * @ORM\ManyToOne(targetEntity="Service", inversedBy="doctorService")
     * @ORM\JoinColumn(name="id_service", referencedColumnName="id", nullable=false)
     */
    private $service;
    /**
     * @ORM\OneToMany(targetEntity="ConsultationService", mappedBy="medicalConsultation")
     */
    private $consultationService;
    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $cost;
    /**
     * DoctorService constructor.
     */
    public function __construct()
    {
        $this->consultationService = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdDoctor(): ?Doctor
    {
        return $this->doctor;
    }

    public function setIdDoctor(Doctor $id_doctor): self
    {
        $this->doctor = $id_doctor;

        return $this;
    }

    public function getIdService(): ?Service
    {
        return $this->service;
    }

    public function setIdService(Service $id_service): self
    {
        $this->service = $id_service;

        return $this;
    }

    public function getCost(): ?string
    {
        return $this->cost;
    }

    public function setCost(string $cost): self
    {
        $this->cost = $cost;

        return $this;
    }
}
