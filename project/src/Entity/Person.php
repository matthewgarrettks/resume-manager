<?php

namespace App\Entity;

use App\Repository\PersonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use \DateTimeImmutable;

/**
 * @ORM\Entity(repositoryClass=PersonRepository::class)
 */
class Person
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    public string $firstName;

    /**
     * @ORM\Column(type="string", length=100)
     */
    public string $lastName;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    public string $email;

    /**
     * @ORM\Column(type="string", length=15, nullable=true)
     */
    public string $phone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    public string $linkedInUrl;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    public string $githubUrl;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    public string $facebookUrl;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    public string $twitterUrl;

    /**
     * @ORM\OneToMany(targetEntity=Education::class, mappedBy="person", orphanRemoval=true)
     */
    private ArrayCollection $educations;

    /**
     * @ORM\OneToMany(targetEntity=Skill::class, mappedBy="person", orphanRemoval=true)
     */
    private ArrayCollection $skills;

    /**
     * @ORM\OneToMany(targetEntity=WorkExperience::class, mappedBy="person", orphanRemoval=true)
     */
    private ArrayCollection $workExperiences;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private DateTimeImmutable $updatedAt;

    /**
     * @ORM\OneToOne(targetEntity=User::class, mappedBy="person", cascade={"persist", "remove"})
     */
    private $user;

    public function __construct()
    {
        $this->educations = new ArrayCollection();
        $this->skills = new ArrayCollection();
        $this->workExperiences = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Education[]
     */
    public function getEducation(): Collection
    {
        return $this->education;
    }

    public function addEducation(Education $education): self
    {
        if (!$this->education->contains($education)) {
            $this->education[] = $education;
            $education->setPerson($this);
        }

        return $this;
    }

    public function removeEducation(Education $education): self
    {
        if ($this->education->removeElement($education)) {
            // set the owning side to null (unless already changed)
            if ($education->getPerson() === $this) {
                $education->setPerson(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Skills[]
     */
    public function getSkills(): Collection
    {
        return $this->skills;
    }

    public function addSkill(Skills $skill): self
    {
        if (!$this->skills->contains($skill)) {
            $this->skills[] = $skill;
            $skill->setPerson($this);
        }

        return $this;
    }

    public function removeSkill(Skills $skill): self
    {
        if ($this->skills->removeElement($skill)) {
            // set the owning side to null (unless already changed)
            if ($skill->getPerson() === $this) {
                $skill->setPerson(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|WorkExperience[]
     */
    public function getWorkExperiences(): Collection
    {
        return $this->workExperiences;
    }

    public function addWorkExperience(WorkExperience $workExperience): self
    {
        if (!$this->workExperiences->contains($workExperience)) {
            $this->workExperiences[] = $workExperience;
            $workExperience->setPerson($this);
        }

        return $this;
    }

    public function removeWorkExperience(WorkExperience $workExperience): self
    {
        if ($this->workExperiences->removeElement($workExperience)) {
            // set the owning side to null (unless already changed)
            if ($workExperience->getPerson() === $this) {
                $workExperience->setPerson(null);
            }
        }

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        // unset the owning side of the relation if necessary
        if ($user === null && $this->user !== null) {
            $this->user->setPerson(null);
        }

        // set the owning side of the relation if necessary
        if ($user !== null && $user->getPerson() !== $this) {
            $user->setPerson($this);
        }

        $this->user = $user;

        return $this;
    }
}
