<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Repository\TicketsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: TicketsRepository::class)]
#[ApiResource(
    operations: [
        new Get(uriTemplate: '/tickets/{id}', normalizationContext: ['groups' => 'tickets:item']),
        new GetCollection(uriTemplate: '/tickets', normalizationContext: ['groups' => 'tickets:list']),
        new Post(uriTemplate: '/tickets', normalizationContext: ['groups' => 'tickets:item'], denormalizationContext: ['groups' => 'tickets:create']),
        new Patch(uriTemplate: '/tickets/{id}', normalizationContext: ['groups' => 'tickets:item'], denormalizationContext: ['groups' => 'tickets:update']),
        new Delete(uriTemplate: '/tickets/{id}', status: 200)
    ],
    order: ['createdAt' => 'DESC'],
    paginationEnabled: true,
)]
class Tickets
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[ApiProperty(identifier: false)]
    private ?int $id = null;

    #[ORM\Column(type: Types::GUID)]
    #[ApiProperty(identifier: true)]
    #[Groups(['tickets:list', 'tickets:item', 'movies:list', 'movies:item'])]
    private ?string $guid = null;

    #[ORM\ManyToOne(inversedBy: 'tickets')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['tickets:list', 'tickets:item', 'tickets:create'])]
    private ?Movies $movie = null;

    #[ORM\Column(length: 255)]
    #[Groups(['tickets:list', 'tickets:item', 'tickets:create', 'tickets:update'])]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    #[Groups(['tickets:list', 'tickets:item', 'tickets:create', 'tickets:update'])]
    private ?string $name = null;

    #[ORM\Column]
    #[Groups(['tickets:list', 'tickets:item', 'tickets:create', 'tickets:update'])]
    private ?int $chairNumber = null;

    #[ORM\Column]
    #[Groups(['tickets:list', 'tickets:item'])]
    private ?float $price = null;

    #[ORM\Column]
    #[Groups(['tickets:list', 'tickets:item'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    #[Groups(['tickets:list', 'tickets:item'])]
    private ?\DateTimeImmutable $updatedAt = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGuid(): ?string
    {
        return $this->guid;
    }

    public function setGuid(string $guid): static
    {
        $this->guid = $guid;

        return $this;
    }

    #[Groups(['tickets:list', 'tickets:item'])]
    public function getLocation(): ?Locations {
        return $this->getMovie()->getHall()->getLocation();
    }

    #[Groups(['tickets:list', 'tickets:item'])]
    public function getHall(): ?Halls {
        return $this->getMovie()->getHall();
    }

    public function getMovie(): ?Movies
    {
        return $this->movie;
    }

    public function setMovie(?Movies $movie): static
    {
        $this->movie = $movie;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getChairNumber(): ?int
    {
        return $this->chairNumber;
    }

    public function setChairNumber(int $chairNumber): static
    {
        $this->chairNumber = $chairNumber;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
