<?php

namespace App\Entity;
use App\Entity\Utilisateur;
use App\Repository\RoleRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RoleRepository::class)]
class Role
{
    #[ORM\Id]
    #[ORM\Column]
    #[ORM\GeneratedValue()]
    private ?int $id=null;
    #[ORM\Column(length:50)]
    private ?string $type=null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }


}
