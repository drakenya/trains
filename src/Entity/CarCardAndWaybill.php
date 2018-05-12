<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CarCardAndWaybillRepository")
 */
class CarCardAndWaybill
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CarCard")
     * @ORM\JoinColumn(nullable=false)
     */
    private $carCard;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Waybill")
     * @ORM\JoinColumn(nullable=false)
     */
    private $waybill;

    public function getId()
    {
        return $this->id;
    }

    public function getCarCard(): ?CarCard
    {
        return $this->carCard;
    }

    public function setCarCard(?CarCard $carCard): self
    {
        $this->carCard = $carCard;

        return $this;
    }

    public function getWaybill(): ?Waybill
    {
        return $this->waybill;
    }

    public function setWaybill(?Waybill $waybill): self
    {
        $this->waybill = $waybill;

        return $this;
    }
}
