<?php

namespace App\Entity;

use App\Repository\PatientSurgeryRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PatientSurgeryRepository::class)
 */
class PatientSurgery
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\ManyToOne(targetEntity="Patient", inversedBy="patientSurgery")
     * @ORM\JoinColumn(name="id_patient", referencedColumnName="id", nullable=false)
     */

    private $patient;

    /**
     * @ORM\ManyToOne(targetEntity="Surgery", inversedBy="patientSurgery")
     * @ORM\JoinColumn(name="id_surgery", referencedColumnName="id", nullable=false)
     */

    private $surgery;


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

    public function getIdSurgery(): ?Surgery
    {
        return $this->surgery;
    }

    public function setIdSurgery(Surgery $id_surgery): self
    {
        $this->surgery = $id_surgery;

        return $this;
    }
}
