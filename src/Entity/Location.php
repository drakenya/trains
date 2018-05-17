<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LocationRepository")
 */
class Location
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=6, nullable=true)
     */
    private $stationNumber;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $stationName;

    /**
     * @ORM\Column(type="string", length=3)
     */
    private $state;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Customer", mappedBy="location")
     */
    private $customers;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Waybill", mappedBy="shipper")
     */
    private $shippers;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Waybill", mappedBy="consignee")
     */
    private $consignees;

    /**
     * @ORM\Column(type="boolean")
     */
    private $onLayout;

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
        $this->customers = new ArrayCollection();
        $this->shippers = new ArrayCollection();
        $this->consignees = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getStationNumber(): ?string
    {
        return $this->stationNumber;
    }

    public function setStationNumber(?string $stationNumber): self
    {
        $this->stationNumber = $stationNumber;

        return $this;
    }

    public function getStationName(): ?string
    {
        return $this->stationName;
    }

    public function setStationName(string $stationName): self
    {
        $this->stationName = $stationName;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(string $state): self
    {
        $this->state = $state;

        return $this;
    }

    /**
     * @return Collection|Customer[]
     */
    public function getCustomers(): Collection
    {
        return $this->customers;
    }

    public function addCustomer(Customer $customer): self
    {
        if (!$this->customers->contains($customer)) {
            $this->customers[] = $customer;
            $customer->setLocation($this);
        }

        return $this;
    }

    public function removeCustomer(Customer $customer): self
    {
        if ($this->customers->contains($customer)) {
            $this->customers->removeElement($customer);
            // set the owning side to null (unless already changed)
            if ($customer->getLocation() === $this) {
                $customer->setLocation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Waybill[]
     */
    public function getShippers(): Collection
    {
        return $this->shippers;
    }

    public function addShipper(Waybill $waybill): self
    {
        if (!$this->shippers->contains($waybill)) {
            $this->shippers[] = $waybill;
            $waybill->setShipper($this);
        }

        return $this;
    }

    public function removeShipper(Waybill $waybill): self
    {
        if ($this->shippers->contains($waybill)) {
            $this->shippers->removeElement($waybill);
            // set the owning side to null (unless already changed)
            if ($waybill->getShipper() === $this) {
                $waybill->setShipper(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Waybill[]
     */
    public function getConsignees(): Collection
    {
        return $this->consignees;
    }

    public function addConsignee(Waybill $waybill): self
    {
        if (!$this->consignees->contains($waybill)) {
            $this->consignees[] = $waybill;
            $waybill->setShipper($this);
        }

        return $this;
    }

    public function removeConsignee(Waybill $waybill): self
    {
        if ($this->consignees->contains($waybill)) {
            $this->consignees->removeElement($waybill);
            // set the owning side to null (unless already changed)
            if ($waybill->getShipper() === $this) {
                $waybill->setShipper(null);
            }
        }

        return $this;
    }

    public function getOnLayout(): ?bool
    {
        return $this->onLayout;
    }

    public function setOnLayout(bool $onLayout): self
    {
        $this->onLayout = $onLayout;

        return $this;
    }
}
