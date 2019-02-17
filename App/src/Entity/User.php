<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Cocur\Slugify\Slugify;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\Table(name="user_perhaps")
 * @UniqueEntity(fields="email", message="Cet email est déjà enregistré en base.")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=80, unique=true)
     * @Assert\Email()
<<<<<<< HEAD
     * @Assert\NotBlank
=======
     * @Assert\NotBlank(groups={"registration"})
>>>>>>> feature/searchProjectFreelancer
     * @Assert\Length(max=80)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $role;

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Assert\NotBlank(groups={"registration"})
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank(groups={"registration"})
     */
    private $nomUser;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank(groups={"registration"})
     */
    private $prenomUser;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank(groups={"registration"})
     */
    private $telephoneUser;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(groups={"registration"})
     */
    private $adresseUser;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank(groups={"registration"})
     */
    private $codePostalUser;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank(groups={"registration"})
     */
    private $ville;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank(groups={"registration"})
     */
    private $pays;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive;

    /**
     * @var string le token qui servira lors de l'oubli de mot de passe
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $resetToken;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    private $statut;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $tarifHoraireFreelancer;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $presentationFreelancer;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    private $nomSocieteFreelancer;

    /**
     * User constructor.
     */
    public function __construct()
    {
        $this->isActive = true;
        $this->roles = [];
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    public function getRole(): string
    {
        return (string) $this->role;
    }

    public function setRole(string $role)
    {
        $this->role = $role;
        return $this;
    }
    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
       return array($this->role);
        /*
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);*/
    }

    /*public function setRoles(array $roles): self
    {
        $this->roles = $roles;
        return $this;

    }*/

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getNomUser(): ?string
    {
        return $this->nomUser;
    }

    public function setNomUser(string $nomUser): self
    {
        $this->nomUser = $nomUser;

        return $this;
    }

    //Fonction Slug - Convertir un string en slug
    public function getSlug(): string
    {
        return (new Slugify())->slugify($this->nomUser);
    }

    public function getPrenomUser(): ?string
    {
        return $this->prenomUser;
    }

    public function setPrenomUser(string $prenomUser): self
    {
        $this->prenomUser = $prenomUser;

        return $this;
    }

    public function getTelephoneUser(): ?string
    {
        return $this->telephoneUser;
    }

    public function setTelephoneUser(string $telephoneUser): self
    {
        $this->telephoneUser = $telephoneUser;

        return $this;
    }

    public function getAdresseUser(): ?string
    {
        return $this->adresseUser;
    }

    public function setAdresseUser(string $adresseUser): self
    {
        $this->adresseUser = $adresseUser;

        return $this;
    }

    public function getCodePostalUser(): ?string
    {
        return $this->codePostalUser;
    }

    public function setCodePostalUser(string $codePostalUser): self
    {
        $this->codePostalUser = $codePostalUser;

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

    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function setPays(string $pays): self
    {
        $this->pays = $pays;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }


    /**
     * @return string
     */
    public function getResetToken(): string
    {
        return $this->resetToken;
    }

    /**
     * @param string $resetToken
     */
    public function setResetToken(?string $resetToken): void
    {
        $this->resetToken = $resetToken;
    }

    /**
     * @return mixed
     */
    public function getStatut(): ?string
    {
        return $this->statut;
    }

    /**
     * @param mixed $statut
     */
    public function setStatut(?string $statut): void
    {
        $this->statut = $statut;
    }

    public function getTarifHoraireFreelancer(): ?int
    {
        return $this->tarifHoraireFreelancer;
    }

    public function setTarifHoraireFreelancer(int $tarifHoraireFreelancer): self
    {
        $this->tarifHoraireFreelancer = $tarifHoraireFreelancer;

        return $this;
    }

    public function getPresentationFreelancer(): ?string
    {
        return $this->presentationFreelancer;
    }

    public function setPresentationFreelancer(string $presentationFreelancer): self
    {
        $this->presentationFreelancer = $presentationFreelancer;

        return $this;
    }

    public function getNomSocieteFreelancer(): ?string
    {
        return $this->nomSocieteFreelancer;
    }

    public function setNomSocieteFreelancer(string $nomSocieteFreelancer): self
    {
        $this->nomSocieteFreelancer = $nomSocieteFreelancer;

        return $this;
    }


}
