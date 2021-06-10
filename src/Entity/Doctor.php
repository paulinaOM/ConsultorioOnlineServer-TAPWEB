<?php

namespace App\Entity;

use App\Repository\DoctorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DoctorRepository::class)
 */
class Doctor
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Speciality", inversedBy="doctors")
     * @ORM\JoinColumn(name="id_speciality", referencedColumnName="id", nullable=false)
     */
    private $speciality;
    /**
     * @ORM\ManyToOne(targetEntity="Userdata", inversedBy="doctors")
     * @ORM\JoinColumn(name="id_user", referencedColumnName="id", nullable=false)
     */

    private $user;

    /**
     * @ORM\OneToMany(targetEntity="DoctorService", mappedBy="doctor")
     */
    private $doctorService;

    /**
     * @ORM\OneToMany(targetEntity="MedicalConsultation", mappedBy="doctor")
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
     * @ORM\Column(type="string", length=10)
     */
    private $mobile_phone;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $email;

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
     * @ORM\Column(type="string", length=8)
     */
    private $license;



    public function __construct()
    {
        $this->doctorService = new ArrayCollection();
        $this->medicalConsultation = new ArrayCollection();
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

    public function getMobilePhone(): ?string
    {
        return $this->mobile_phone;
    }

    public function setMobilePhone(string $mobile_phone): self
    {
        $this->mobile_phone = $mobile_phone;

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

    public function getLicense(): ?string
    {
        return $this->license;
    }

    public function setLicense(string $license): self
    {
        $this->license = $license;

        return $this;
    }

    public function getIdSpeciality(): ?Speciality
    {
        return $this->speciality;
    }

    public function setIdSpeciality(Speciality $id_speciality): self
    {
        $this->speciality = $id_speciality;

        return $this;
    }

    public function getIdUser(): ?Userdata
    {
        return $this->user;
    }

    public function setIdUser(Userdata $id_user): self
    {
        $this->user = $id_user;

        return $this;
    }
}
