<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AarCodeRepository")
 */
class AarCode
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=4)
     */
    private $code;

    /**
     * @ORM\Column(type="string", length=1)
     */
    private $class;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $commonName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CarCard", mappedBy="aarCode")
     */
    private $carCards;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Waybill", mappedBy="aarCode")
     */
    private $waybills;

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

    public function __construct()
    {
        $this->carCards = new ArrayCollection();
        $this->waybills = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getClass(): ?string
    {
        return $this->class;
    }

    public function setClass(string $class): self
    {
        $this->class = $class;

        return $this;
    }

    public function getCommonName(): ?string
    {
        return $this->commonName;
    }

    public function setCommonName(?string $commonName): self
    {
        $this->commonName = $commonName;

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

    /**
     * @return Collection|CarCard[]
     */
    public function getCarCards(): Collection
    {
        return $this->carCards;
    }

    public function addCarCard(CarCard $carCard): self
    {
        if (!$this->carCards->contains($carCard)) {
            $this->carCards[] = $carCard;
            $carCard->setAarCode($this);
        }

        return $this;
    }

    public function removeCarCard(CarCard $carCard): self
    {
        if ($this->carCards->contains($carCard)) {
            $this->carCards->removeElement($carCard);
            // set the owning side to null (unless already changed)
            if ($carCard->getAarCode() === $this) {
                $carCard->setAarCode(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Waybill[]
     */
    public function getWaybills(): Collection
    {
        return $this->waybills;
    }

    public function addWaybill(Waybill $waybill): self
    {
        if (!$this->waybills->contains($waybill)) {
            $this->waybills[] = $waybill;
            $waybill->setAarCode($this);
        }

        return $this;
    }

    public function removeWaybill(Waybill $waybill): self
    {
        if ($this->waybills->contains($waybill)) {
            $this->waybills->removeElement($waybill);
            // set the owning side to null (unless already changed)
            if ($waybill->getAarCode() === $this) {
                $waybill->setAarCode(null);
            }
        }

        return $this;
    }
}
