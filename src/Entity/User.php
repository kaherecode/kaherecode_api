<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"user:read"}},
 *     denormalizationContext={"groups"={"user:write"}}
 * )
 *
 * @UniqueEntity(fields={"email"})
 * @UniqueEntity(fields={"username"})
 *
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     *
     * @Groups("user:read")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     *
     * @Groups({"user:read", "user:write"})
     *
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     *
     * @Groups("user:read")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     *
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Groups({"user:read", "user:write", "tutorial:read"})
     *
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     *
     * @Groups({"user:read", "user:write", "tutorial:read"})
     *
     * @Assert\NotBlank()
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @Groups({"user:read", "user:write"})
     */
    private $avatar;

    /**
     * @ORM\Column(type="text", nullable=true)
     *
     * @Groups({"user:read", "user:write"})
     */
    private $bio;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @Groups({"user:read", "user:write"})
     */
    private $github;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @Groups({"user:read", "user:write"})
     */
    private $twitter;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @Groups({"user:read", "user:write"})
     */
    private $linkedin;

    /**
     * @ORM\Column(type="boolean")
     *
     * @Groups("user:read")
     */
    private $enabled;

    /**
     * @ORM\Column(type="boolean")
     *
     * @Groups("user:read")
     */
    private $archived;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @Groups("user:read")
     */
    private $confirmationToken;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @Groups("user:read")
     */
    private $passwordRequestedAt;

    /**
     * @ORM\Column(type="datetime")
     *
     * @Groups("user:read")
     */
    private $registeredAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @Groups("user:read")
     */
    private $lastLogin;

    /**
     * @Groups("user:write")
     *
     * @SerializedName("password")
     */
    private $plainPassword;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Tutorial", mappedBy="author")
     *
     * @ApiSubresource
     *
     * @Groups("user:read")
     */
    private $tutorials;

    public function __construct()
    {
        $this->enabled = false;
        $this->archived = false;
        $this->registeredAt = new \DateTime();
        $this->tutorials = new ArrayCollection();
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
        $this->plainPassword = null;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(?string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getBio(): ?string
    {
        return $this->bio;
    }

    public function setBio(?string $bio): self
    {
        $this->bio = $bio;

        return $this;
    }

    public function getGithub(): ?string
    {
        return $this->github;
    }

    public function setGithub(?string $github): self
    {
        $this->github = $github;

        return $this;
    }

    public function getTwitter(): ?string
    {
        return $this->twitter;
    }

    public function setTwitter(?string $twitter): self
    {
        $this->twitter = $twitter;

        return $this;
    }

    public function getLinkedin(): ?string
    {
        return $this->linkedin;
    }

    public function setLinkedin(?string $linkedin): self
    {
        $this->linkedin = $linkedin;

        return $this;
    }

    public function getEnabled(): ?bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): self
    {
        $this->enabled = $enabled;

        return $this;
    }

    public function getArchived(): ?bool
    {
        return $this->archived;
    }

    public function setArchived(bool $archived): self
    {
        $this->archived = $archived;

        return $this;
    }

    public function getConfirmationToken(): ?string
    {
        return $this->confirmationToken;
    }

    public function setConfirmationToken(?string $confirmationToken): self
    {
        $this->confirmationToken = $confirmationToken;

        return $this;
    }

    public function getPasswordRequestedAt(): ?\DateTimeInterface
    {
        return $this->passwordRequestedAt;
    }

    public function setPasswordRequestedAt(
        ?\DateTimeInterface $passwordRequestedAt
    ): self {
        $this->passwordRequestedAt = $passwordRequestedAt;

        return $this;
    }

    public function getRegisteredAt(): ?\DateTimeInterface
    {
        return $this->registeredAt;
    }

    public function setRegisteredAt(\DateTimeInterface $registeredAt): self
    {
        $this->registeredAt = $registeredAt;

        return $this;
    }

    public function getLastLogin(): ?\DateTimeInterface
    {
        return $this->lastLogin;
    }

    public function setLastLogin(?\DateTimeInterface $lastLogin): self
    {
        $this->lastLogin = $lastLogin;

        return $this;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    /**
     * @return Collection|Tutorial[]
     */
    public function getTutorials(): Collection
    {
        return $this->tutorials;
    }

    public function addTutorial(Tutorial $tutorial): self
    {
        if (!$this->tutorials->contains($tutorial)) {
            $this->tutorials[] = $tutorial;
            $tutorial->setAuthor($this);
        }

        return $this;
    }

    public function removeTutorial(Tutorial $tutorial): self
    {
        if ($this->tutorials->contains($tutorial)) {
            $this->tutorials->removeElement($tutorial);
            // set the owning side to null (unless already changed)
            if ($tutorial->getAuthor() === $this) {
                $tutorial->setAuthor(null);
            }
        }

        return $this;
    }
}
