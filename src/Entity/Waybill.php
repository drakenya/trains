<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\WaybillRepository")
 */
class Waybill
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $number;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    private $fromAddress;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    private $toAddress;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    private $shipper;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    private $consignee;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    private $stopAt;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    private $StopAt2;

    /**
     * @ORM\Column(type="string", length=3, nullable=true)
     */
    private $aarClass;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    private $instructionsExceptions;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    private $routeVia;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $ladingQuantity;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    private $ladingDescription;

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

    public function getFromAddress(): ?string
    {
        return $this->fromAddress;
    }

    public function setFromAddress(?string $fromAddress): self
    {
        $this->fromAddress = $fromAddress;

        return $this;
    }

    public function getToAddress(): ?string
    {
        return $this->toAddress;
    }

    public function setToAddress(?string $toAddress): self
    {
        $this->toAddress = $toAddress;

        return $this;
    }

    public function getShipper(): ?string
    {
        return $this->shipper;
    }

    public function setShipper(?string $shipper): self
    {
        $this->shipper = $shipper;

        return $this;
    }

    public function getConsignee(): ?string
    {
        return $this->consignee;
    }

    public function setConsignee(?string $consignee): self
    {
        $this->consignee = $consignee;

        return $this;
    }

    public function getAarClass(): ?string
    {
        return $this->aarClass;
    }

    public function setAarClass(?string $aarClass): self
    {
        $this->aarClass = $aarClass;

        return $this;
    }

    public function getRouteVia(): ?string
    {
        return $this->routeVia;
    }

    public function setRouteVia(?string $routeVia): self
    {
        $this->routeVia = $routeVia;

        return $this;
    }

    public function getLadingQuantity(): ?string
    {
        return $this->ladingQuantity;
    }

    public function setLadingQuantity(?string $ladingQuantity): self
    {
        $this->ladingQuantity = $ladingQuantity;

        return $this;
    }

    public function getLadingDescription(): ?string
    {
        return $this->ladingDescription;
    }

    public function setLadingDescription(?string $ladingDescription): self
    {
        $this->ladingDescription = $ladingDescription;

        return $this;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(int $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getStopAt(): ?string
    {
        return $this->stopAt;
    }

    public function setStopAt(?string $stopAt): self
    {
        $this->stopAt = $stopAt;

        return $this;
    }

    public function getStopAt2(): ?string
    {
        return $this->StopAt2;
    }

    public function setStopAt2(?string $StopAt2): self
    {
        $this->StopAt2 = $StopAt2;

        return $this;
    }

    public function getInstructionsExceptions(): ?string
    {
        return $this->instructionsExceptions;
    }

    public function setInstructionsExceptions(?string $instructionsExceptions): self
    {
        $this->instructionsExceptions = $instructionsExceptions;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }
}
