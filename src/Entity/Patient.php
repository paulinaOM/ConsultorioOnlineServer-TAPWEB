<?php

namespace App\Entity;

use App\Repository\PatientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PatientRepository::class)
 */
class Patient
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\ManyToOne(targetEntity="Userdata", inversedBy="patients")
     * @ORM\JoinColumn(name="id_user", referencedColumnName="id", nullable=false)
     */

    private $user;
    /**
     * @ORM\OneToMany(targetEntity="PatientAllergy", mappedBy="patient")
     */
    private $patientAllergy;
    /**
     * @ORM\OneToMany(targetEntity="PatientDisease", mappedBy="disease")
     */
    private $patientDisease;
    /**
     * @ORM\OneToMany(targetEntity="PatientSurgery", mappedBy="surgery")
     */
    private $patientSurgery;
    /**
     * @ORM\OneToMany(targetEntity="TaxData", mappedBy="patient")
     */
    private $taxData;

    /**
     * @ORM\OneToMany(targetEntity="MedicalConsultation", mappedBy="patient")
     */
    private $medicalConsultation;


    /**
     * @ORM\Column(type="string", length=50)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $state;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $country;

    /**
     * @ORM\Column(type="date")
     */
    private $birthdate;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $email;


    /**
     * @ORM\Column(type="string", length=10)
     */
    private $status_covid;

    /**
     * @ORM\Column(type="float")
     */
    private $latitud;

    /**
     * @ORM\Column(type="float")
     */
    private $longitud;

    /**
     * @ORM\OneToMany(targetEntity=Ticket::class, mappedBy="idPatient")
     */
    private $tickets;


    /**
     * Patient constructor.
     */
    public function __construct()
    {
        $this->patientAllergy = new ArrayCollection();
        $this->patientDisease = new ArrayCollection();
        $this->patientSurgery = new ArrayCollection();
        $this->taxData = new ArrayCollection();
        $this->medicalConsultation = new ArrayCollection();
        $this->tickets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(string $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getBirthdate(): ?\DateTimeInterface
    {
        return $this->birthdate;
    }

    public function setBirthdate(\DateTimeInterface $birthdate): self
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getIdUser(): ?Userdata
    {
        return $this->user;
    }

    public function setIdUser(?Userdata $id_user): self
    {
        $this->user = $id_user;

        return $this;
    }

    public function getStatusCovid(): ?string
    {
        return $this->status_covid;
    }

    public function setStatusCovid(string $status_covid): self
    {
        $this->status_covid = $status_covid;

        return $this;
    }

    public function getLatitud(): ?float
    {
        return $this->latitud;
    }

    public function setLatitud(float $latitud): self
    {
        $this->latitud = $latitud;

        return $this;
    }

    public function getLongitud(): ?float
    {
        return $this->longitud;
    }

    public function setLongitud(float $longitud): self
    {
        $this->longitud = $longitud;

        return $this;
    }

    /**
     * @return Collection|Ticket[]
     */
    public function getTickets(): Collection
    {
        return $this->tickets;
    }

    public function addTicket(Ticket $ticket): self
    {
        if (!$this->tickets->contains($ticket)) {
            $this->tickets[] = $ticket;
            $ticket->setIdPatient($this);
        }

        return $this;
    }

    public function removeTicket(Ticket $ticket): self
    {
        if ($this->tickets->removeElement($ticket)) {
            // set the owning side to null (unless already changed)
            if ($ticket->getIdPatient() === $this) {
                $ticket->setIdPatient(null);
            }
        }

        return $this;
    }
}
