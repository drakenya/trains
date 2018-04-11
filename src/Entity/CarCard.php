<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

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
    private $carInitial;

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

    public function getId()
    {
        return $this->id;
    }

    public function getCarInitial(): ?string
    {
        return $this->carInitial;
    }

    public function setCarInitial(string $carInitial): self
    {
        $this->carInitial = $carInitial;

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
}
