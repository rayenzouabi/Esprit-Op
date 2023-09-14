<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Role;
use App\Repository\UtilisateurRepository;
use Scheb\TwoFactorBundle\Model\Email\TwoFactorInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints As Assert;
use Scheb\TwoFactorBundle\Model\Totp\TotpConfiguration;
use Scheb\TwoFactorBundle\Model\Totp\TotpConfigurationInterface;
#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
class Utilisateur implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\Column]
    #[ORM\GeneratedValue()]
    private ?int $id=null;

    #[Assert\Length(min:3,minMessage:'contient au minimum 3 caratéres')]
    #[ORM\Column(length:50)]
    #[Assert\NotBlank(message:"Ce champs est vide")]
    private ?string $nom=null;

    #[Assert\NotBlank(message:"Ce champs est vide")]
    #[Assert\Length(min:3,minMessage:'contient au minimum 3 caratéres')]
    #[ORM\Column(length:50)]

    private ?string $prenom=null;

    #[Assert\NotBlank(message:"Ce champs est vide")]
    #[Assert\Length(exactly:8,exactMessage: 'Doit etre composé de 8 chiffres')]
    #[Assert\Regex(pattern:"/^[0-9]+$/", message:"Contient seulement des chiffres.")]
    #[ORM\Column(length:50)]
    private ?string $cin=null;
    
    #[Assert\NotBlank(message:"Ce champs est vide")]
    #[Assert\LessThan('-18 years',message: 'vous devez avoir au minimum 18 ans ')]
    #[ORM\Column(length:255)]
    private ?\DateTime $date_naiss=null;

    #[ORM\Column(length:50)]
    private ?string $age=null; 


    #[Assert\NotBlank(message:"Ce champs est vide")]
    #[Assert\Length(exactly:8,exactMessage: 'Doit etre composé de 8 chiffres')]
    #[Assert\Regex(pattern:"/^[0-9]+$/", message:"Contient seulement des chiffres.")]
    #[ORM\Column(length:50)]
    private ?string $identifiant=null;

    #[ORM\Column(length:50)]
    private ?string $ville=null;

    #[Assert\NotBlank(message:"Ce champs est vide")]
    #[Assert\Length(exactly:8,exactMessage: 'Doit etre composé de 8 chiffres')]
    #[Assert\Regex(pattern:"/^[0-9]+$/", message:"Contient seulement des chiffres.")]
    #[ORM\Column(length:50)]
    private ?string $num_tel=null;

    #[Assert\NotBlank(message:"Ce champs est vide")]
    #[Assert\Email(message:"La format de l'email est non valide")]
    #[ORM\Column(length:255)]
    private ?string $login=null;

   #[Assert\NotBlank(message:"Ce champs est vide")]
   #[Assert\Length(min:6,max:20,minMessage:'contient au minimum 6 caratéres',maxMessage:'contient 20 caractéres au maximum')]
   #[ORM\Column(length:50)]
   private ?string $mdp=null;

    #[ORM\Column(length:50)]
    private ?string $photo_personel=null;
    #[ORM\Column(length:50)]
    public ?string $carte_etudiant=null;
    #[ORM\JoinColumn(name: 'idrole', referencedColumnName: 'id')]
    #[ORM\OneToOne(targetEntity: Role::class )]
    private ?Role $role = null;
    #[ORM\Column(length:50)]
    private ?string $etat=null;

public function setId(int $id){
    $this->id = $id;
    return $this;
}

public function getId(): ?int
{
    return $this->id;
}

public function getNom(): ?string
{
    return $this->nom;
}

public function setNom(string $nom): self
{
    $this->nom = $nom;

    return $this;
}

public function getPrenom(): ?string
{
    return $this->prenom;
}

public function setPrenom(string $prenom): self
{
    $this->prenom = $prenom;

    return $this;
}
public function getEtat(): ?string
{
    return $this->etat;
}

public function setEtat(string $etat): self
{
    $this->etat = $etat;

    return $this;
}

public function getCin(): ?string
{
    return $this->cin;
}

public function setCin(string $cin): self
{
    $this->cin = $cin;

    return $this;
}

public function getDateNaiss(): ?\DateTimeInterface
{
    return $this->date_naiss;
}

public function setDateNaiss(\DateTimeInterface $date_naiss): self
{
    $this->date_naiss = $date_naiss;

    return $this;
}

public function getAge(): ?string
{
    return $this->age;
}

public function setAge(string $age): self
{
    $this->age = $age;

    return $this;
}

public function getIdentifiant(): ?string
{
    return $this->identifiant;
}

public function setIdentifiant(string $identifiant): self
{
    $this->identifiant = $identifiant;

    return $this;
}

public function getVille(): ?string
{
    return $this->ville;
}

public function setVille(string $ville): self
{
    $this->ville = $ville;

    return $this;
}

public function getNumTel(): ?string
{
    return $this->num_tel;
}

public function setNumTel(string $num_tel): self
{
    $this->num_tel = $num_tel;

    return $this;
}

public function getLogin(): ?string
{
    return $this->login;
}

public function setLogin(string $login): self
{
    $this->login = $login;

    return $this;
}

public function getMdp(): ?string
{
    return $this->mdp;
}

public function setMdp(string $mdp): self
{
    $this->mdp = $mdp;

    return $this;
}
  /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->mdp;
    }

    public function setPassword(string $password): self
    {
        $this->mdp = $password;

        return $this;
    }

public function getPhotoPersonel(): ?string
{
    return $this->photo_personel;
}

public function setPhotoPersonel(string $photo_personel): self
{
    $this->photo_personel = $photo_personel;

    return $this;
}

public function getCarte_etudiant(): ?string
{
    return $this->carte_etudiant;
}

public function setCarte_etudiant(string $carte_etudiant): self
{
    $this->carte_etudiant = $carte_etudiant;

    return $this;
}

public function getRole(): ?Role
{
    return $this->role;
}

public function setRole(?Role $role): self
{
    $this->role = $role;

    return $this;
}

  

/**
     * The public representation of the user (e.g. a username, an email address, etc.)
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->login;
    }

    public function getUsername(): string
    {
        return $this->getUserIdentifier();
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        return [$this->role->getType()];
    }

    public function setRoles($role): self
    {
        $this->setRole($role);
        return $this;
    }

     /**
     * Returning a salt is only needed if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

}
