<?php

namespace App\Entity;

use App\Repository\FindingRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FindingRepository::class)]
class Finding
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $quantity = null;

    #[ORM\ManyToOne(targetEntity: Location::class, cascade: ["persist", "remove"])]
    private Location $location;

    #[ORM\ManyToOne(targetEntity: Mushroom::class)]
    private Mushroom $mushroom;

    #[ORM\Column]
    private ?\DateTimeImmutable $datetime = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(?int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getLocation(): Location
    {
        return $this->location;
    }

    public function setLocation(Location $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getMushroom(): Mushroom
    {
        return $this->mushroom;
    }

    public function setMushroom(Mushroom $mushroom): self
    {
        $this->mushroom = $mushroom;

        return $this;
    }

    public function getDatetime(): ?\DateTimeImmutable
    {
        return $this->datetime;
    }

    public function setDatetime(\DateTimeImmutable $datetime): static
    {
        $this->datetime = $datetime;

        return $this;
    }
}
