<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Repository\HallsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: HallsRepository::class)]
#[ApiResource(
    operations: [
        new Get(uriTemplate: '/halls/{id}', normalizationContext: ['groups' => 'halls:item']),
        new GetCollection(uriTemplate: '/halls', normalizationContext: ['groups' => 'halls:list']),
        new Post(uriTemplate: '/halls', normalizationContext: ['groups' => 'halls:item'], denormalizationContext: ['groups' => 'halls:create']),
        new Patch(uriTemplate: '/halls/{id}', normalizationContext: ['groups' => 'halls:item'], denormalizationContext: ['groups' => 'halls:update']),
        new Delete(uriTemplate: '/halls/{id}', status: 200)
    ],
    order: ['createdAt' => 'DESC'],
    paginationEnabled: true,
)]
class Halls
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['halls:list', 'halls:item'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['halls:list', 'halls:item', 'halls:create', 'halls:update', 'movies:item', 'movies:list', 'locations:list', 'locations:item', 'tickets:list', 'tickets:item'])]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'halls')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['halls:list', 'halls:item', 'halls:create', 'halls:update'])]
    private ?Locations $location = null;

    #[ORM\Column]
    #[Groups(['halls:list', 'halls:item', 'halls:create', 'halls:update'])]
    private ?int $capacity = null;

    #[ORM\Column]
    #[Groups(['halls:list', 'halls:item'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    #[Groups(['halls:list', 'halls:item'])]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\OneToMany(mappedBy: 'hall', targetEntity: Movies::class)]
    #[Groups(['halls:list', 'halls:item'])]
    private Collection $movies;

    public function __construct()
    {
        $this->movies = new ArrayCollection();
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

    public function getLocation(): ?Locations
    {
        return $this->location;
    }

    public function setLocation(?Locations $location): static
    {
        $this->location = $location;

        return $this;
    }

    public function getCapacity(): ?int
    {
        return $this->capacity;
    }

    public function setCapacity(int $capacity): static
    {
        $this->capacity = $capacity;

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
     * @return Collection<int, Movies>
     */
    public function getMovies(): Collection
    {
        return $this->movies;
    }

    public function addMovie(Movies $movie): static
    {
        if (!$this->movies->contains($movie)) {
            $this->movies->add($movie);
            $movie->setHall($this);
        }

        return $this;
    }

    public function removeMovie(Movies $movie): static
    {
        if ($this->movies->removeElement($movie)) {
            // set the owning side to null (unless already changed)
            if ($movie->getHall() === $this) {
                $movie->setHall(null);
            }
        }

        return $this;
    }
}
