<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EmptyCarBillRepository")
 */
class EmptyCarBill
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Location")
     */
    private $homeBilledFrom;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    private $homeToOrVia;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Location")
     */
    private $loadingBilledFrom;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Location")
     */
    private $loadingTo;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Customer")
     */
    private $loadingShipper;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $loadingSpot;

    public function getId()
    {
        return $this->id;
    }

    public function getHomeBilledFrom(): ?Location
    {
        return $this->homeBilledFrom;
    }

    public function setHomeBilledFrom(?Location $homeBilledFrom): self
    {
        $this->homeBilledFrom = $homeBilledFrom;

        return $this;
    }

    public function getHomeToOrVia(): ?string
    {
        return $this->homeToOrVia;
    }

    public function setHomeToOrVia(?string $homeToOrVia): self
    {
        $this->homeToOrVia = $homeToOrVia;

        return $this;
    }

    public function getLoadingBilledFrom(): ?Location
    {
        return $this->loadingBilledFrom;
    }

    public function setLoadingBilledFrom(?Location $loadingBilledFrom): self
    {
        $this->loadingBilledFrom = $loadingBilledFrom;

        return $this;
    }

    public function getLoadingTo(): ?Location
    {
        return $this->loadingTo;
    }

    public function setLoadingTo(?Location $loadingTo): self
    {
        $this->loadingTo = $loadingTo;

        return $this;
    }

    public function getLoadingShipper(): ?Customer
    {
        return $this->loadingShipper;
    }

    public function setLoadingShipper(?Customer $loadingShipper): self
    {
        $this->loadingShipper = $loadingShipper;

        return $this;
    }

    public function getLoadingSpot(): ?string
    {
        return $this->loadingSpot;
    }

    public function setLoadingSpot(?string $loadingSpot): self
    {
        $this->loadingSpot = $loadingSpot;

        return $this;
    }
}
