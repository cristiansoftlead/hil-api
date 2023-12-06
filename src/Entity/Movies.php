<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Repository\MoviesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: MoviesRepository::class)]
#[ApiResource(
        operations: [
            new Get(uriTemplate: '/movies/{id}', normalizationContext: ['groups' => 'movies:item']),
            new GetCollection(uriTemplate: '/movies', normalizationContext: ['groups' => 'movies:list']),
            new Post(uriTemplate: '/movies', normalizationContext: ['groups' => 'movies:item'], denormalizationContext: ['groups' => 'movies:create']),
            new Patch(uriTemplate: '/movies/{id}',normalizationContext: ['groups' => 'movies:item'], denormalizationContext: ['groups' => 'movies:update']),
            new Delete(uriTemplate: '/movies/{id}',status: 200)
        ],
    order: ['startAt' => 'DESC'],
    paginationEnabled: true,
)]
class Movies
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['movies:list', 'movies:item'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['movies:list', 'movies:item', 'movies:create', 'movies:update', 'halls:item', 'halls:list', 'tickets:list', 'tickets:item'])]
    private ?string $name = null;

    #[ORM\Column]
    #[Groups(['movies:list', 'movies:item', 'movies:create', 'movies:update'])]
    private ?\DateTimeImmutable $startAt = null;

    #[ORM\Column]
    #[Groups(['movies:list', 'movies:item', 'movies:create', 'movies:update'])]
    private ?\DateTimeImmutable $endAt = null;

    #[ORM\Column]
    #[Groups(['movies:list', 'movies:item', 'movies:create', 'movies:update'])]
    private ?float $price = null;

    #[ORM\Column]
    #[Groups(['movies:list', 'movies:item'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    #[Groups(['movies:list', 'movies:item'])]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\OneToMany(mappedBy: 'movie', targetEntity: Tickets::class)]
    #[Groups(['movies:list', 'movies:item'])]
    private Collection $tickets;

    #[ORM\ManyToOne(inversedBy: 'movies')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['movies:list', 'movies:item', 'movies:create'])]
    private ?Halls $hall = null;

    public function __construct()
    {
        $this->tickets = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getStartAt(): ?\DateTimeImmutable
    {
        return $this->startAt;
    }

    public function setStartAt(\DateTimeImmutable $startAt): static
    {
        $this->startAt = $startAt;

        return $this;
    }

    public function getEndAt(): ?\DateTimeImmutable
    {
        return $this->endAt;
    }

    public function setEndAt(\DateTimeImmutable $endAt): static
    {
        $this->endAt = $endAt;

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

    /**
     * @return Collection<int, Tickets>
     */
    public function getTickets(): Collection
    {
        return $this->tickets;
    }

    public function addTicket(Tickets $ticket): static
    {
        if (!$this->tickets->contains($ticket)) {
            $this->tickets->add($ticket);
            $ticket->setMovie($this);
        }

        return $this;
    }

    public function removeTicket(Tickets $ticket): static
    {
        if ($this->tickets->removeElement($ticket)) {
            // set the owning side to null (unless already changed)
            if ($ticket->getMovie() === $this) {
                $ticket->setMovie(null);
            }
        }

        return $this;
    }

    public function getHall(): ?Halls
    {
        return $this->hall;
    }

    public function setHall(?Halls $hall): static
    {
        $this->hall = $hall;

        return $this;
    }
}
