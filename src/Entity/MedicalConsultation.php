<?php

namespace App\Entity;

use App\Repository\MedicalConsultationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MedicalConsultationRepository::class)
 */
class MedicalConsultation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\OneToMany(targetEntity="Media", mappedBy="consultation")
     */
    private $media;

    /**
     * @ORM\ManyToOne(targetEntity="Doctor", inversedBy="medicalConsultation")
     * @ORM\JoinColumn(name="id_doctor", referencedColumnName="id", nullable=false)
     */
    private $doctor;

    /**
     * @ORM\ManyToOne(targetEntity="Patient", inversedBy="medicalConsultation")
     * @ORM\JoinColumn(name="id_patient", referencedColumnName="id", nullable=false)
     */
    private $patient;

    /**
     * @ORM\OneToMany(targetEntity="Prescription", mappedBy="medicalConsultation")
     */
    private $prescription;


    /**
     * @ORM\OneToMany(targetEntity="ConsultationService", mappedBy="medicalConsultation")
     */
    private $consultationService;

    /**
     * @ORM\OneToOne(targetEntity="Bill", mappedBy="medicalConsultation")
     */
    private $bill;

    /**
     * @ORM\Column(type="string", length=200)
     */
    private $symptom;

    /**
     * @ORM\Column(type="integer")
     */
    private $atention_status;

    /**
     * @ORM\Column(type="date")
     */
    private $consultation_date;


    public function __construct()
    {
        $this->prescription = new ArrayCollection();
        $this->consultationService = new ArrayCollection();
        $this->media = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdPatient(): ?Patient
    {
        return $this->patient;
    }

    public function setIdPatient(?Patient $id_patient): self
    {
        $this->patient = $id_patient;

        return $this;
    }

    public function getSymptom(): ?string
    {
        return $this->symptom;
    }

    public function setSymptom(string $symptom): self
    {
        $this->symptom = $symptom;

        return $this;
    }

    public function getAtentionStatus(): ?int
    {
        return $this->atention_status;
    }

    public function setAtentionStatus(int $atention_status): self
    {
        $this->atention_status = $atention_status;

        return $this;
    }

    public function getConsultationDate(): ?\DateTimeInterface
    {
        return $this->consultation_date;
    }

    public function setConsultationDate(\DateTimeInterface $consultation_date): self
    {
        $this->consultation_date = $consultation_date;

        return $this;
    }

    public function getIdDoctor(): ?Doctor
    {
        return $this->doctor;
    }

    public function setIdDoctor(?Doctor $id_doctor): self
    {
        $this->doctor = $id_doctor;
        return $this;


    }
}