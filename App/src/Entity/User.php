<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Cocur\Slugify\Slugify;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\Table(name="user_perhaps")
 * @UniqueEntity(fields="email", message="Cet email est déjà enregistré en base.")
 * @Vich\Uploadable
 */
class User implements UserInterface, \Serializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255 , nullable=true)
     * @var string|null
     */
    private $imageName;

    /**
     * @Vich\UploadableField(mapping="user_images", fileNameProperty="imageName")
     * @var File|null
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string|null
     */
    private $cvName;

    /**
     * @Vich\UploadableField(mapping="user_cv", fileNameProperty="cvName")
     * @var File|null
     */
    private $cvFile;

    /**
     * @ORM\Column(type="string", length=80, unique=true)
     * @Assert\Email()
     * @Assert\NotBlank()
     * @Assert\Length(max=80)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank()
     */
    private $nomUser;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank()
     */
    private $prenomUser;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank()
     */
    private $telephoneUser;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $adresseUser;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank()
     * @Assert\Regex("/^[0-9]{5}/")
     */
    private $codePostalUser;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank()
     */
    private $ville;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank()
     */
    private $pays;

    /**
     * @ORM\Column(type="boolean", options={"default" : true})
     */
    private $isActive;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $passwordRequestedAt;

    /**
     * @var string le token qui servira lors de l'oubli de mot de passe
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $resetToken;

    /**
     * @var string le token qui servira lors de la confirmation du mail
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $confirmationToken;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\Range(min=1, max=100)
     */
    private $tarifHoraireFreelancer;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     * @Assert\Length(min=5)
     */
    private $titreFreelancer;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $presentationFreelancer;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    private $nomSociete;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Projet", mappedBy="creePar", orphanRemoval=true)
     */
    private $projetGerer;


    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updated_at;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Competence", inversedBy="users")
     */
    private $listCompetence;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Equipe", inversedBy="listParticipants")
     */
    private $participe;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\NoteEtCommentaire", mappedBy="developpeur", orphanRemoval=true)
     */
    private $noteEtCommentaire;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Devis", mappedBy="etabliPar", orphanRemoval=true)
     */
    private $listDesDevis;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Equipe", mappedBy="chefDeProjet")
     */
    private $equipeGerer;

    /**
     * User constructor.
     */
    public function __construct()
    {
        $this->isActive = false;
        $this->projetGerer = new ArrayCollection();
        $this->listCompetence = new ArrayCollection();
        $this->participe = new ArrayCollection();
        $this->noteEtCommentaire = new ArrayCollection();
        $this->listDesDevis = new ArrayCollection();
        $this->equipeGerer = new ArrayCollection();
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

    //contrôler la validité du token
    public function getPasswordRequestedAt(): string
    {
        return $this->passwordRequestedAt;
    }

    public function setPasswordRequestedAt(?string $passwordRequestedAt): void
    {
        $this->passwordRequestedAt = $passwordRequestedAt;
    }

    /**
     * @return string
     */
    public function getResetToken(): string
    {
        return $this->resetToken;
    }

    public function setResetToken(?string $resetToken): void
    {
        $this->resetToken = $resetToken;
    }

    public function getConfirmationToken(): string
    {
        return $this->confirmationToken;
    }

    public function setConfirmationToken(?string $confirmationToken): void
    {
        $this->confirmationToken = $confirmationToken;

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


    public function getNomSociete(): ?string
    {
        return $this->nomSociete;
    }

    public function setNomSociete(string $nomSociete): self
    {
        $this->nomSociete = $nomSociete;
        return $this;
    }
    /**
     * @return Collection|Projet[]
     */
    public function getProjetGerer(): Collection
    {
        return $this->projetGerer;
    }

    public function addProjetGerer(Projet $projetGerer): self
    {
        if (!$this->projetGerer->contains($projetGerer)) {
            $this->projetGerer[] = $projetGerer;
            $projetGerer->setCreePar($this);
        }

        return $this;
    }

    public function removeProjetGerer(Projet $projetGerer): self
    {
        if ($this->projetGerer->contains($projetGerer)) {
            $this->projetGerer->removeElement($projetGerer);
            // set the owning side to null (unless already changed)
            if ($projetGerer->getCreePar() === $this) {
                $projetGerer->setCreePar(null);
            }
        }

        return $this;
    }

    /**
     * @return null|string
     */
    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    /**
     * @param null|string $imageName
     * @return User
     */
    public function setImageName(?string $imageName): User
    {
        $this->imageName = $imageName;
        return $this;
    }

    /**
     * @return null|File
     */
    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    /**
     * @param null|File $imageFile
     * @return User
     */
    public function setImageFile(?File $imageFile= null): User
    {
        $this->imageFile = $imageFile;
        if(null !== $imageFile && $this->imageFile instanceof UploadedFile){
            $this->updated_at = new \DateTime('now');
        }
        return $this;
    }

    /**
     * @return null|string
     */
    public function getCvName(): ?string
    {
        return $this->cvName;
    }

    /**
     * @param null|string $cvName
     * @return User
     */
    public function setCvName(?string $cvName): User
    {
        $this->cvName = $cvName;
        return $this;
    }

    /**
     * @return null|File
     */
    public function getCvFile(): ?File
    {
        return $this->cvFile;
    }

    /**
     * @param null|File $cvFile
     * @return User
     */
    public function setCvFile(?File $cvFile = null): User
    {
        $this->cvFile = $cvFile;
        if(null != $cvFile && $this->cvFile instanceof UploadedFile){
            $this->updated_at = new \DateTime('now');
        }
        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }
    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->imageName,
            $this->email,
            $this->password,


        ));
    }
    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->imageName,
            $this->email,
            $this->password,


            ) = unserialize($serialized);
    }

    /**
     * @return Collection|Competence[]
     */
    public function getListCompetence(): Collection
    {
        return $this->listCompetence;
    }

    public function addListCompetence(Competence $listCompetence): self
    {
        if (!$this->listCompetence->contains($listCompetence)) {
            $this->listCompetence[] = $listCompetence;
        }

        return $this;
    }

    public function removeListCompetence(Competence $listCompetence): self
    {
        if ($this->listCompetence->contains($listCompetence)) {
            $this->listCompetence->removeElement($listCompetence);
        }

        return $this;
    }

    /**
     * @return Collection|Equipe[]
     */
    public function getParticipe(): Collection
    {
        return $this->participe;
    }

    public function addParticipe(Equipe $participe): self
    {
        if (!$this->participe->contains($participe)) {
            $this->participe[] = $participe;
        }

        return $this;
    }

    public function removeParticipe(Equipe $participe): self
    {
        if ($this->participe->contains($participe)) {
            $this->participe->removeElement($participe);
        }

        return $this;
    }

    /**
     * @return Collection|NoteEtCommentaire[]
     */
    public function getNoteEtCommentaire(): Collection
    {
        return $this->noteEtCommentaire;
    }

    public function addNoteEtCommentaire(NoteEtCommentaire $noteEtCommentaire): self
    {
        if (!$this->noteEtCommentaire->contains($noteEtCommentaire)) {
            $this->noteEtCommentaire[] = $noteEtCommentaire;
            $noteEtCommentaire->setDeveloppeur($this);
        }

        return $this;
    }

    public function removeNoteEtCommentaire(NoteEtCommentaire $noteEtCommentaire): self
    {
        if ($this->noteEtCommentaire->contains($noteEtCommentaire)) {
            $this->noteEtCommentaire->removeElement($noteEtCommentaire);
            // set the owning side to null (unless already changed)
            if ($noteEtCommentaire->getDeveloppeur() === $this) {
                $noteEtCommentaire->setDeveloppeur(null);
            }
        }

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @return Collection|Devis[]
     */
    public function getListDesDevis(): Collection
    {
        return $this->listDesDevis;
    }

    public function addListDesDevi(Devis $listDesDevi): self
    {
        if (!$this->listDesDevis->contains($listDesDevi)) {
            $this->listDesDevis[] = $listDesDevi;
            $listDesDevi->setEtabliPar($this);
        }

        return $this;
    }

    public function removeListDesDevi(Devis $listDesDevi): self
    {
        if ($this->listDesDevis->contains($listDesDevi)) {
            $this->listDesDevis->removeElement($listDesDevi);
            // set the owning side to null (unless already changed)
            if ($listDesDevi->getEtabliPar() === $this) {
                $listDesDevi->setEtabliPar(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Equipe[]
     */
    public function getEquipeGerer(): Collection
    {
        return $this->equipeGerer;
    }

    public function addEquipeGerer(Equipe $equipeGerer): self
    {
        if (!$this->equipeGerer->contains($equipeGerer)) {
            $this->equipeGerer[] = $equipeGerer;
            $equipeGerer->setChefDeProjet($this);
        }

        return $this;
    }

    public function removeEquipeGerer(Equipe $equipeGerer): self
    {
        if ($this->equipeGerer->contains($equipeGerer)) {
            $this->equipeGerer->removeElement($equipeGerer);
            // set the owning side to null (unless already changed)
            if ($equipeGerer->getChefDeProjet() === $this) {
                $equipeGerer->setChefDeProjet(null);
            }
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTitreFreelancer(): ?string
    {
        return $this->titreFreelancer;
    }

    /**
     * @param mixed $titreFreelancer
     * @return User
     */
    public function setTitreFreelancer(string $titreFreelancer): self
    {
        $this->titreFreelancer = $titreFreelancer;
        return $this;
    }

}
