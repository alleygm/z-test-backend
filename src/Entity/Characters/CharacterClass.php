<?php

namespace App\Entity\Characters;

use App\Repository\Characters\CharacterClassRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CharacterClassRepository::class)]
#[ORM\Table(name: 'character_class')]
class CharacterClass
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 4, unique: true)]
    private ?int $code = null;

    /**
     * @var Collection<int, Characters>
     */
    #[ORM\OneToMany(targetEntity: Characters::class, mappedBy: 'class')]
    private Collection $characters;

    public function __construct()
    {
        $this->characters = new ArrayCollection();
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

    public function getCode(): ?int
    {
        return $this->code;
    }

    public function setCode(int $code): static
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return Collection<int, Characters>
     */
    public function getCharacters(): Collection
    {
        return $this->characters;
    }

    public function addCharacter(Characters $character): static
    {
        if (!$this->characters->contains($character)) {
            $this->characters->add($character);
            $character->setClass($this);
        }

        return $this;
    }

    public function removeCharacter(Characters $character): static
    {
        if ($this->characters->removeElement($character)) {
            // set the owning side to null (unless already changed)
            if ($character->getClass() === $this) {
                $character->setClass(null);
            }
        }

        return $this;
    }
}
