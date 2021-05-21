<?php

namespace App\Entity;

use App\Repository\ReferencesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReferencesRepository::class)
 * @ORM\Table(name="`references`")
 */
class References
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $numeroFacture;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumeroFacture(): ?int
    {
        return $this->numeroFacture;
    }

    public function setNumeroFacture(int $numeroFacture): self
    {
        $this->numeroFacture = $numeroFacture;

        return $this;
    }
}
