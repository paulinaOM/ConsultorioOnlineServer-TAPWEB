<?php

namespace App\Entity;

use App\Repository\TicketRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TicketRepository::class)
 */
class Ticket
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Patient::class, inversedBy="tickets")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idPatient;

    /**
     * @ORM\Column(type="date")
     */
    private $dateSale;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $filename;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdPatient(): ?Patient
    {
        return $this->idPatient;
    }

    public function setIdPatient(?Patient $idPatient): self
    {
        $this->idPatient = $idPatient;

        return $this;
    }

    public function getDateSale(): ?\DateTimeInterface
    {
        return $this->dateSale;
    }

    public function setDateSale(\DateTimeInterface $dataSale): self
    {
        $this->dateSale = $dataSale;

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
