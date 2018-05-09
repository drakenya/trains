<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LegacyIndustryRepository")
 */
class LegacyIndustry
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $era;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $state;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $reportingMarks;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $shipReceive;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $commodity;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $stcc;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $reciprocal;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $source;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $externalSource;

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

    public function getEra(): ?string
    {
        return $this->era;
    }

    public function setEra(?string $era): self
    {
        $this->era = $era;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(?string $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getReportingMarks(): ?string
    {
        return $this->reportingMarks;
    }

    public function setReportingMarks(?string $reportingMarks): self
    {
        $this->reportingMarks = $reportingMarks;

        return $this;
    }

    public function getShipReceive(): ?string
    {
        return $this->shipReceive;
    }

    public function setShipReceive(?string $shipReceive): self
    {
        $this->shipReceive = $shipReceive;

        return $this;
    }

    public function getCommodity(): ?string
    {
        return $this->commodity;
    }

    public function setCommodity(?string $commodity): self
    {
        $this->commodity = $commodity;

        return $this;
    }

    public function getStcc(): ?string
    {
        return $this->stcc;
    }

    public function setStcc(?string $stcc): self
    {
        $this->stcc = $stcc;

        return $this;
    }

    public function getReciprocal(): ?string
    {
        return $this->reciprocal;
    }

    public function setReciprocal(?string $reciprocal): self
    {
        $this->reciprocal = $reciprocal;

        return $this;
    }

    public function getSource(): ?string
    {
        return $this->source;
    }

    public function setSource(?string $source): self
    {
        $this->source = $source;

        return $this;
    }

    public function getExternalSource(): ?string
    {
        return $this->externalSource;
    }

    public function setExternalSource(string $externalSource): self
    {
        $this->externalSource = $externalSource;

        return $this;
    }
}
