<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use DateTimeImmutable;
use \DateTime;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\Table(name="user",
 *      uniqueConstraints={@ORM\UniqueConstraint(name="user_unique",columns={"username"})})
 * @ORM\HasLifecycleCallbacks()
 */
class User implements UserInterface
{
    const ROLE_ADMIN = 'ROLE_ADMIN';
    const ROLE_USER = 'ROLE_USER';
    const ROLE_VISITOR = 'ROLE_VISITOR';

    const CONFIRMATION_EXPIRES_IN_HOURS = '6';

    public static function allRoles(): array
    {
        return [
            self::ROLE_ADMIN => self::ROLE_ADMIN,
            self::ROLE_USER => self::ROLE_USER,
            self::ROLE_VISITOR => self::ROLE_VISITOR
        ];
    }

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="simple_array", nullable=true)
     */
    private array $roles = [];

    /**
     * @ORM\Column(type="string", length=64, unique=true)
     */
    public string $username;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    public string $firstName;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    public string $lastName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    public string $email;

    /**
     * @var string The hashed password for local logins
     * @ORM\Column(type="string")
     */
    private string $password;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private string $confirmationKey;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    public ?DateTime $lastLoginAt = null;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    public ?DateTime $agreedToTermsOn;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    public ?DateTime $confirmationKeyExpiration;

    /**
     * @ORM\Column(type="datetime")
     */
    private DateTime $updatedAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private DateTime $createdAt;

    /**
     * @ORM\Column(type="string", length=260, nullable=true)
     */
    private string $guid;

    /**
     * @ORM\OneToOne(targetEntity=Person::class, inversedBy="user", cascade={"persist", "remove"})
     */
    private Person $person;


    public function __construct()
    {
    }

    public function __toString()
    {
        return trim($this->firstName . ' ' . $this->lastName);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getRoles(): array
    {
        return $this->roles ?? [];
    }

    public function addRole($new): self
    {
        $this->roles[] = $new;
        $this->roles = array_unique($this->roles);
        return $this;
    }

    public function removeRole($remove): self
    {
        $this->roles = array_filter($this->roles, function ($role) use ($remove) {
            return $role !== $remove;
        });

        return $this;
    }


    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string)$this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    public function getSalt(): ?string
    {
        return null;
    }

    public function eraseCredentials(): ?bool
    {
        return null;
    }

    /**
     * @ORM\PrePersist
     */
    public function prePersist(): void
    {
        $this->guid = $this->getNewGuid();
        if (!isset($this->password) || !$this->password) {
            $this->setPassword(md5($this->guid));
        }
        $this->updatedAt = new \DateTime();
        $this->createdAt = new \DateTime();
    }

    /**
     * @ORM\PreUpdate
     */
    public function preUpdate(): void
    {
        $this->updatedAt = new \DateTime();
    }

    public function getGuid(): ?string
    {
        return $this->guid;
    }

    public function setGuid(?string $guid): self
    {
        $this->guid = $guid;

        return $this;
    }

    public function getNewGuid(): string
    {
        mt_srand((float)microtime() * 10000); //optional for php 4.2.0 and up.
        $charid = strtoupper(md5(uniqid(rand(), true)));
        $hyphen = chr(45); // "-"

        return substr($charid, 0, 8) . $hyphen
            . substr($charid, 8, 4) . $hyphen
            . substr($charid, 12, 4) . $hyphen
            . substr($charid, 16, 4) . $hyphen
            . substr($charid, 20, 12); // "}"
    }

    public function resetConfirmationKey(): void
    {
        mt_srand((double)microtime() * 10000);//optional for php 4.2.0 and up.
        $charid = strtoupper(md5(uniqid(rand(), true)));
        $hyphen = chr(45);// "-"
        $uuid = substr($charid, 0, 8)
            . substr($charid, 8, 4)
            . substr($charid, 12, 4)
            . substr($charid, 16, 4)
            . substr($charid, 20, 12);// "}"
        $this->confirmationKey = substr($uuid, 0, 13);
        $now = new \DateTime();
        $this->confirmationKeyExpiration = $now->add(new \DateInterval("PT" . User::CONFIRMATION_EXPIRES_IN_HOURS . "H"));
    }

    /**
     * @return mixed
     */
    public function getConfirmationKey(): ?string
    {
        return $this->confirmationKey;
    }

    public function getConfirmationKeyExpiration(): ?\DateTimeInterface
    {
        return $this->confirmationKeyExpiration;
    }

    public function hasRole($roleName): bool
    {
        return in_array($roleName, $this->roles);
    }

    public function isAdmin(): bool
    {
        return $this->hasRole(self::ROLE_ADMIN);
    }

    public function getShortCode(): string
    {
        return substr($this->guid, 0, strpos($this->guid, '-'));
    }

    public function getPerson(): ?Person
    {
        return $this->person;
    }

    public function setPerson(?Person $person): self
    {
        $this->person = $person;
        return $this;
    }

    public function getLastLoginAt(): DateTime
    {
        return $this->lastLoginAt;
    }

}
