<?php

namespace App\Entity;

use App\Repository\MediaRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MediaRepository::class)
 */
class Media
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="MedicalConsultation", inversedBy="media")
     * @ORM\JoinColumn(name="id_consultation", referencedColumnName="id", nullable=false)
     */

    private $consultation;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $filename;


    public function getId(): ?int
    {
        return $this->id;
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

    public function getIdConsultation(): ?MedicalConsultation
    {
        return $this->consultation;
    }

    public function setIdConsultation(MedicalConsultation $id_consultation): self
    {
        $this->consultation = $id_consultation;

        return $this;
    }
}
