<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FullWaybillRepository")
 */
class FullWaybill
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
