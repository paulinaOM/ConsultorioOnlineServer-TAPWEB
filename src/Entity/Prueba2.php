<?php

namespace App\Entity;

use App\Repository\Prueba2Repository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=Prueba2Repository::class)
 */
class Prueba2
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=109)
     */
    private $campo1;

    /**
     * @ORM\ManyToOne(targetEntity=Prueba1::class, inversedBy="foraneo")
     */
    private $foraneo;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCampo1(): ?string
    {
        return $this->campo1;
    }

    public function setCampo1(string $campo1): self
    {
        $this->campo1 = $campo1;

        return $this;
    }

    public function getForaneo(): ?Prueba1
    {
        return $this->foraneo;
    }

    public function setForaneo(?Prueba1 $foraneo): self
    {
        $this->foraneo = $foraneo;

        return $this;
    }
}
