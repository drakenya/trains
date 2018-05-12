<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CarCardRepository")
 */
class CarCard
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=6)
     */
    private $reportingMark;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $carNumber;

    /**
     * @ORM\Column(type="string", length=6)
     */
    private $aarType;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $lengthCapacity;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     *
     * @Gedmo\Timestampable(on="create")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     *
     * @Gedmo\Timestampable(on="update")
     */
    private $updatedAt;

    public function getId()
    {
        return $this->id;
    }

    public function getReportingMark(): ?string
    {
        return $this->reportingMark;
    }

    public function setReportingMark(string $reportingMark): self
    {
        $this->reportingMark = $reportingMark;

        return $this;
    }

    public function getCarNumber(): ?string
    {
        return $this->carNumber;
    }

    public function setCarNumber(string $carNumber): self
    {
        $this->carNumber = $carNumber;

        return $this;
    }

    public function getAarType(): ?string
    {
        return $this->aarType;
    }

    public function setAarType(string $aarType): self
    {
        $this->aarType = $aarType;

        return $this;
    }

    public function getLengthCapacity(): ?string
    {
        return $this->lengthCapacity;
    }

    public function setLengthCapacity(?string $lengthCapacity): self
    {
        $this->lengthCapacity = $lengthCapacity;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function __toString(): string
    {
        return sprintf('%s %s (%s)', $this->reportingMark, $this->carNumber, $this->aarType);
    }
}
