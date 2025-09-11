<?php

namespace App\Entity\Characters;

use App\Entity\Item;
use App\Entity\User;
use App\Repository\Characters\CharactersRepository;
use App\Trait\EntityDateStampTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: CharactersRepository::class)]
#[ORM\Table(name: '`characters`')]
#[ORM\HasLifecycleCallbacks]
#[UniqueEntity(
    fields: ['name'],
    message: 'Персонаж с таким именем уже существует.'
)]
class Characters
{
    use EntityDateStampTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'characters')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column(length: 255, unique:true)]
    private ?string $name = null;

    #[ORM\Column()]
    private ?int $level = 1;

    /**
     * @var Collection<int, item>
     */
    #[ORM\OneToMany(targetEntity: Item::class, mappedBy: 'owner')]
    private Collection $items;

    #[ORM\ManyToOne(inversedBy: 'characters')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CharacterClass $class = null;

    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

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

    public function getLevel(): ?int
    {
        return $this->level;
    }

    public function setLevel(int $level): static
    {
        $this->level = $level;

        return $this;
    }

    /**
     * @return Collection<int, item>
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(item $item): static
    {
        if (!$this->items->contains($item)) {
            $this->items->add($item);
            $item->setOwner($this);
        }

        return $this;
    }

    public function removeItem(item $item): static
    {
        if ($this->items->removeElement($item)) {
            // set the owning side to null (unless already changed)
            if ($item->getOwner() === $this) {
                $item->setOwner(null);
            }
        }

        return $this;
    }

    public function getClass(): ?CharacterClass
    {
        return $this->class;
    }

    public function setClass(?CharacterClass $class): static
    {
        $this->class = $class;

        return $this;
    }
}
