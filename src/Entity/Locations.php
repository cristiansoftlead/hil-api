<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Repository\LocationsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: LocationsRepository::class)]
#[ApiResource(
    operations: [
        new Get(uriTemplate: '/locations/{id}', normalizationContext: ['groups' => 'locations:item']),
        new GetCollection(uriTemplate: '/locations', normalizationContext: ['groups' => 'locations:list']),
        new Post(uriTemplate: '/locations', normalizationContext: ['groups' => 'locations:item'], denormalizationContext: ['groups' => 'locations:create']),
        new Patch(uriTemplate: '/locations/{id}', normalizationContext: ['groups' => 'locations:item'], denormalizationContext: ['groups' => 'locations:update']),
        new Delete(uriTemplate: '/locations/{id}', status: 200)
    ],
    order: ['createdAt' => 'DESC'],
    paginationEnabled: true,
)]
class Locations
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['locations:list', 'locations:item'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['locations:list', 'locations:item', 'locations:create', 'locations:update', 'halls:item', 'halls:list', 'tickets:list', 'tickets:item'])]
    private ?string $name = null;

    #[ORM\Column]
    #[Groups(['locations:list', 'locations:item'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    #[Groups(['locations:list', 'locations:item'])]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\OneToMany(mappedBy: 'location', targetEntity: Halls::class)]
    #[Groups(['locations:list', 'locations:item'])]
    private Collection $halls;

    public function __construct()
    {
        $this->halls = new ArrayCollection();
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
     * @return Collection<int, Halls>
     */
    public function getHalls(): Collection
    {
        return $this->halls;
    }

    public function addHall(Halls $hall): static
    {
        if (!$this->halls->contains($hall)) {
            $this->halls->add($hall);
            $hall->setLocation($this);
        }

        return $this;
    }

    public function removeHall(Halls $hall): static
    {
        if ($this->halls->removeElement($hall)) {
            // set the owning side to null (unless already changed)
            if ($hall->getLocation() === $this) {
                $hall->setLocation(null);
            }
        }

        return $this;
    }
}
