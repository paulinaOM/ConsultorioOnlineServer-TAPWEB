<?php

namespace App\Entity;

use App\Repository\TaxDataRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TaxDataRepository::class)
 */
class TaxData
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Patient", inversedBy="taxData")
     * @ORM\JoinColumn(name="id_patient", referencedColumnName="id", nullable=false)
     */
    private $patient;

    /**
     * @ORM\ManyToOne(targetEntity="Payment", inversedBy="taxData")
     * @ORM\JoinColumn(name="id_payment", referencedColumnName="id", nullable=false)
     */
    private $payment;


    /**
     * @ORM\Column(type="string", length=100)
     */
    private $billing_address;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $shipping_date;


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

    public function getBillingAddress(): ?string
    {
        return $this->billing_address;
    }

    public function setBillingAddress(string $billing_address): self
    {
        $this->billing_address = $billing_address;

        return $this;
    }

    public function getShippingDate(): ?string
    {
        return $this->shipping_date;
    }

    public function setShippingDate(string $shipping_date): self
    {
        $this->shipping_date = $shipping_date;

        return $this;
    }

    public function getIdPayment(): ?Payment
    {
        return $this->payment;
    }

    public function setIdPayment(?Payment $id_payment): self
    {
        $this->payment = $id_payment;

        return $this;
    }
}
