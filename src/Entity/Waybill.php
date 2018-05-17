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
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    private $stopAt;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    private $StopAt2;

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

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\AarCode", inversedBy="waybills")
     * @ORM\JoinColumn(nullable=false)
     */
    private $aarCode;

    /**
     * @var Customer
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Customer", inversedBy="shippers")
     */
    private $shipper;

    /**
     * @var Customer
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Customer", inversedBy="shippers")
     */
    private $consignee;

    public function getId()
    {
        return $this->id;
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

    public function getShipper(): ?Customer
    {
        return $this->shipper;
    }

    public function setShipper(?Customer $shipper): self
    {
        $this->shipper = $shipper;

        return $this;
    }

    public function getConsignee(): ?Customer
    {
        return $this->consignee;
    }

    public function setConsignee(?Customer $consignee): self
    {
        $this->consignee = $consignee;

        return $this;
    }
}
