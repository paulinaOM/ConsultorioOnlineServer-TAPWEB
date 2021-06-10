<?php

namespace App\Entity;

use App\Repository\ConsultationServiceRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ConsultationServiceRepository::class)
 */
class ConsultationService
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\ManyToOne(targetEntity="MedicalConsultation", inversedBy="consultationService")
     * @ORM\JoinColumn(name="id_consultation", referencedColumnName="id", nullable=false)
     */
    private $medicalConsultation;
    /**
     * @ORM\ManyToOne(targetEntity="DoctorService", inversedBy="consultationService")
     * @ORM\JoinColumn(name="id_service", referencedColumnName="id", nullable=false)
     */
    private $doctorService;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdConsultation(): ?MedicalConsultation
    {
        return $this->medicalConsultation;
    }

    public function setIdConsultation(MedicalConsultation $id_consultation): self
    {
        $this->medicalConsultation = $id_consultation;

        return $this;
    }

    public function getIdService(): ?DoctorService
    {
        return $this->doctorService;
    }

    public function setIdService(DoctorService $id_service): self
    {
        $this->doctorService = $id_service;

        return $this;
    }


}
