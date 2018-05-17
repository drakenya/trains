<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RailroadRepository")
 */
class Railroad
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=5)
     */
    private $reportingMark;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CarCard", mappedBy="railroad")
     */
    private $carCards;

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
    }

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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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
            $carCard->setRailroad($this);
        }

        return $this;
    }

    public function removeCarCard(CarCard $carCard): self
    {
        if ($this->carCards->contains($carCard)) {
            $this->carCards->removeElement($carCard);
            // set the owning side to null (unless already changed)
            if ($carCard->getRailroad() === $this) {
                $carCard->setRailroad(null);
            }
        }

        return $this;
    }
}
