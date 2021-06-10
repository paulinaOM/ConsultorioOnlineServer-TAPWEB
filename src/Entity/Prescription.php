<?php

namespace App\Entity;

use App\Repository\PrescriptionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PrescriptionRepository::class)
 */
class Prescription
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="MedicalConsultation", inversedBy="prescription")
     * @ORM\JoinColumn(name="id_consultation", referencedColumnName="id", nullable=false)
     */
    private $medicalConsultation;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $filename;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdConsultation(): ?MedicalConsultation
    {
        return $this->medicalConsultation;
    }

    public function setIdConsultation(?MedicalConsultation $id_consultation): self
    {
        $this->medicalConsultation = $id_consultation;

        return $this;
    }

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(string $filename): self
    {
        $this->filename = $filename;

        return $this;
    }
}
