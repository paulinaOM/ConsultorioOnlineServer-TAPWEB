<?php

namespace App\Entity;

use App\Repository\Prueba1Repository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=Prueba1Repository::class)
 */
class Prueba1
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $campo1;

    /**
     * @ORM\OneToMany(targetEntity=Prueba2::class, mappedBy="foraneo")
     */
    private $foraneo;

    public function __construct()
    {
        $this->foraneo = new ArrayCollection();
    }

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

    /**
     * @return Collection|Prueba2[]
     */
    public function getForaneo(): Collection
    {
        return $this->foraneo;
    }

    public function addForaneo(Prueba2 $foraneo): self
    {
        if (!$this->foraneo->contains($foraneo)) {
            $this->foraneo[] = $foraneo;
            $foraneo->setForaneo($this);
        }

        return $this;
    }

    public function removeForaneo(Prueba2 $foraneo): self
    {
        if ($this->foraneo->removeElement($foraneo)) {
            // set the owning side to null (unless already changed)
            if ($foraneo->getForaneo() === $this) {
                $foraneo->setForaneo(null);
            }
        }

        return $this;
    }
}
