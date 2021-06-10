<?php

namespace App\Entity;

use App\Repository\PatientAllergyRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PatientAllergyRepository::class)
 */
class PatientAllergy
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\ManyToOne(targetEntity="Patient", inversedBy="patientAllergy")
     * @ORM\JoinColumn(name="id_patient", referencedColumnName="id", nullable=false)
     */

    private $patient;

    /**
     * @ORM\ManyToOne(targetEntity="Allergy", inversedBy="patientAllergy")
     * @ORM\JoinColumn(name="id_allergy", referencedColumnName="id", nullable=false)
     */

    private $allergy;



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

    public function getIdAllergy(): ?Allergy
    {
        return $this->allergy;
    }

    public function setIdAllergy(Allergy $id_allergy): self
    {
        $this->allergy = $id_allergy;

        return $this;
    }
}
