<?php

namespace App\Entity;

use App\Repository\CandidatureRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CandidatureRepository::class)]
class Candidature
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nomC = null;

    #[ORM\Column(length: 255)]
    private ?string $prenomC = null;

    #[ORM\Column(length: 255)]
    private ?string $emailC = null;

    #[ORM\Column(type: Types::BINARY)]
    public $CV_c = null;

    #[ORM\Column(type: Types::BINARY)]
    public $motivation_letter = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomC(): ?string
    {
        return $this->nomC;
    }

    public function setNomC(string $nomC): static
    {
        $this->nomC = $nomC;

        return $this;
    }

    public function getPrenomC(): ?string
    {
        return $this->prenomC;
    }

    public function setPrenomC(string $prenomC): static
    {
        $this->prenomC = $prenomC;

        return $this;
    }

    public function getEmailC(): ?string
    {
        return $this->emailC;
    }

    public function setEmailC(string $emailC): static
    {
        $this->emailC = $emailC;

        return $this;
    }

    public function getCVC()
    {
        return $this->CV_c;
    }

    public function setCVC($CV_c): static
    {
        $this->CV_c = $CV_c;

        return $this;
    }

    public function getMotivationLetter()
    {
        return $this->motivation_letter;
    }

    public function setMotivationLetter($motivation_letter): static
    {
        $this->motivation_letter = $motivation_letter;

        return $this;
    }
}
