<?php

namespace App\Entity;

use App\Repository\WorkExperienceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\Date;
use \DateTimeImmutable;

/**
 * @ORM\Entity(repositoryClass=WorkExperienceRepository::class)
 */
class WorkExperience
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\ManyToOne(targetEntity=Person::class, inversedBy="workExperiences")
     * @ORM\JoinColumn(nullable=false)
     */
    private Person $person;

    /**
     * @ORM\Column(type="string", length=255)
     */
    public string $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    public string $employer;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    public string $unit;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    public DateTimeImmutable $startDate;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    public DateTimeImmutable $endDate;

    /**
     * @ORM\Column(type="boolean")
     */
    public bool $isCurrent = false;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    public string $summary;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    public string $duties;

    /**
     * @ORM\ManyToMany(targetEntity=Skill::class, inversedBy="workExperiences")
     */
    private ArrayCollection $skillsUsed;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    public string $interests;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private DateTimeImmutable $updatedAt;



    public function __construct()
    {
        $this->skillsUsed = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->title;
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection|Skill[]
     */
    public function getSkillsUsed(): Collection
    {
        return $this->skillsUsed;
    }

    public function addSkillsUsed(Skill $skillsUsed): self
    {
        if (!$this->skillsUsed->contains($skillsUsed)) {
            $this->skillsUsed[] = $skillsUsed;
        }

        return $this;
    }

    public function removeSkillsUsed(Skill $skillsUsed): self
    {
        $this->skillsUsed->removeElement($skillsUsed);

        return $this;
    }

    public function getUpdatedAt(): ?DateTimeImmutable
    {
        return $this->updatedAt;
    }
}
