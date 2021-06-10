<?php

namespace App\Entity;

use App\Repository\PatientDiseaseRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PatientDiseaseRepository::class)
 */
class PatientDisease
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\ManyToOne(targetEntity="Patient", inversedBy="patientDisease")
     * @ORM\JoinColumn(name="id_patient", referencedColumnName="id", nullable=false)
     */

    private $patient;

    /**
     * @ORM\ManyToOne(targetEntity="ChronicDisease", inversedBy="patientDisease")
     * @ORM\JoinColumn(name="id_disease", referencedColumnName="id", nullable=false)
     */

    private $disease;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdPatient(): ?Patient
    {
        return $this->patient;
    }

    public function setIdPatient(Patient $id_patient): self
    {
        $this->patient = $id_patient;

        return $this;
    }

    public function getIdDisease(): ?ChronicDisease
    {
        return $this->disease;
    }

    public function setIdDisease(ChronicDisease $id_disease): self
    {
        $this->disease = $id_disease;

        return $this;
    }
}
