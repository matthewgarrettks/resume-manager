<?php

namespace App\Entity;

use App\Repository\EducationRepository;
use Doctrine\ORM\Mapping as ORM;
use \DateTimeImmutable;

/**
 * @ORM\Entity(repositoryClass=EducationRepository::class)
 */
class Education
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\ManyToOne(targetEntity=Person::class, inversedBy="education")
     * @ORM\JoinColumn(nullable=false)
     */
    private Person $person;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    public string $degreeTitle;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    public string $school;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    public DateTimeImmutable $dateEarned;

    /**
     * @ORM\Column(type="string", length=512, nullable=true)
     */
    public string $extra;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private DateTimeImmutable $updatedAt;



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

    public function getUpdatedAt(): ?DateTimeImmutable
    {
        return $this->updatedAt;
    }
}
