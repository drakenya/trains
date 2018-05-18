<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FullEmptyCarBillRepository")
 */
class FullEmptyCarBill
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
     * @ORM\ManyToOne(targetEntity="App\Entity\EmptyCarBill")
     * @ORM\JoinColumn(nullable=false)
     */
    private $emptyCarBill;

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

    public function getEmptyCarBill(): ?EmptyCarBill
    {
        return $this->emptyCarBill;
    }

    public function setEmptyCarBill(?EmptyCarBill $emptyCarBill): self
    {
        $this->emptyCarBill = $emptyCarBill;

        return $this;
    }
}
