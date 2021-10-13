<?php

namespace App\Entity;

use App\Repository\SkillRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use DateTimeImmutable;

/**
 * @ORM\Entity(repositoryClass=SkillRepository::class)
 */
class Skill
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\ManyToOne(targetEntity=Person::class, inversedBy="skills")
     * @ORM\JoinColumn(nullable=false)
     */
    private Person $person;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    public string $name;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    public int $rankOneToTen;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    public string $category;

    /**
     * @ORM\ManyToMany(targetEntity=WorkExperience::class, mappedBy="skillsUsed")
     */
    private ArrayCollection $workExperiences;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    public DateTimeImmutable $updatedAt;

    public function __construct()
    {
        $this->workExperiences = new ArrayCollection();
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
            $workExperience->addSkillsUsed($this);
        }

        return $this;
    }

    public function removeWorkExperience(WorkExperience $workExperience): self
    {
        if ($this->workExperiences->removeElement($workExperience)) {
            $workExperience->removeSkillsUsed($this);
        }

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }
}
