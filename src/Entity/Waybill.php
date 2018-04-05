<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\Column(type="string", length=3, nullable=true)
     */
    private $aarClass;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $lengthCapacity;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    private $routeVia;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    private $spotLocation;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $ladingQuantity;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    private $ladingDescription;

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

    public function getLengthCapacity(): ?string
    {
        return $this->lengthCapacity;
    }

    public function setLengthCapacity(?string $lengthCapacity): self
    {
        $this->lengthCapacity = $lengthCapacity;

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

    public function getSpotLocation(): ?string
    {
        return $this->spotLocation;
    }

    public function setSpotLocation(?string $spotLocation): self
    {
        $this->spotLocation = $spotLocation;

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
}
