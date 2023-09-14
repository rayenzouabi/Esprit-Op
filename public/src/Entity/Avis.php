<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;


#[ORM\Entity()]
class Avis
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private $id;

    #[ORM\Column(type: "string", length: 255)]
    private $commentaire;

    #[ORM\Column(type: "integer")]
    private $etoile;

    #[ORM\Column(type: "integer")]
    private $id_voiture;

    #[ORM\Column(type: "integer")]
    private $id_client;

    #[ORM\OneToMany(targetEntity: "App\Entity\Comment", mappedBy: "avis")]
    private $commentaires;

    #[ORM\Column(type: "string")]
    private $userName;

    public function __construct()
    {
        $this->id_voiture = 11212;
        $this->id_client = 11212;
        $this->commentaires = new ArrayCollection();

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(string $commentaire): self
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    public function getEtoile(): ?int
    {
        return $this->etoile;
    }

    public function setEtoile($etoile): self
    {
            $this->etoile = (int) $etoile;
        return $this;
    }
    

    public function getIdVoiture(): ?int
    {
        return $this->id_voiture;
    }

    public function setIdVoiture(int $id_voiture): self
    {
        $this->id_voiture = $id_voiture;

        return $this;
    }

    public function getIdClient(): ?int
    {
        return $this->id_client;
    }

    public function setIdClient(int $id_client): self
    {
        $this->id_client = $id_client;

        return $this;
    }

    public function getCommentaires()
    {
        return $this->commentaires;
    }
 
    public function addComment(Comment $comment): self
    {
        if (!$this->commentaires->contains($comment)) {
            $this->commentaires[] = $comment;
            $comment->setAvis($this);
        }
    
        return $this;
    }

    public function getUserName(): ?string
    {
        return $this->userName;
    }

    public function setUserName(string $userName): self
    {
        $this->userName = $userName;

        return $this;
    }
}
