<?php

namespace App\Entity;

use App\Repository\RetardRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RetardRepository::class)
 */
class Retard
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $dateRetard;

    /**
     * @ORM\ManyToOne(targetEntity=Eleve::class, inversedBy="retards")
     * @ORM\JoinColumn(nullable=false)
     */
    private $eleve;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateRetard(): ?\DateTimeInterface
    {
        return $this->dateRetard;
    }

    public function setDateRetard(\DateTimeInterface $dateRetard): self
    {
        $this->dateRetard = $dateRetard;

        return $this;
    }

    public function getEleve(): ?Eleve
    {
        return $this->eleve;
    }

    public function setEleve(?Eleve $eleve): self
    {
        $this->eleve = $eleve;

        return $this;
    }
}
