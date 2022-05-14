<?php

namespace App\Entity;

use App\Repository\AbsenceRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AbsenceRepository::class)
 */
class Absence
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
    private $dateAbsence;

    /**
     * @ORM\ManyToOne(targetEntity=Eleve::class, inversedBy="abscences")
     * @ORM\JoinColumn(nullable=false)
     */
    private $eleve;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateAbsence(): ?\DateTimeInterface
    {
        return $this->dateAbsence;
    }

    public function setDateAbsence(\DateTimeInterface $dateAbsence): self
    {
        $this->dateAbsence = $dateAbsence;

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
