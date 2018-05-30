<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
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
     * @ORM\Column(type="string", length=10)
     */
    private $carNumber;

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

    /**
     * @var AarCode
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\AarCode", inversedBy="carCards")
     * @ORM\JoinColumn(nullable=false)
     */
    private $aarCode;

    /**
     * @var Railroad
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Railroad", inversedBy="carCards")
     * @ORM\JoinColumn(nullable=false)
     */
    private $railroad;

    /**
     * @var FullWaybill[]
     *
     * @ORM\OneToMany(targetEntity="App\Entity\FullWaybill", mappedBy="carCard")
     */
    private $fullWaybills;

    /**
     * @var FullEmptyCarBill[]
     *
     * @ORM\OneToMany(targetEntity="App\Entity\FullEmptyCarBill", mappedBy="carCard")
     */
    private $fullEmptyCarBills;

    public function __construct()
    {
        $this->fullWaybills = new ArrayCollection();
        $this->fullEmptyCarBills = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
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

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    public function getAarCode(): ?AarCode
    {
        return $this->aarCode;
    }

    public function setAarCode(?AarCode $aarCode): self
    {
        $this->aarCode = $aarCode;

        return $this;
    }

    public function getRailroad(): ?Railroad
    {
        return $this->railroad;
    }

    public function setRailroad(?Railroad $railroad): self
    {
        $this->railroad = $railroad;

        return $this;
    }
}
