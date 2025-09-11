<?php

namespace App\Entity;

use App\Entity\Characters\Characters;
use App\Repository\ItemRepository;
use App\Trait\EntityDateStampTrait;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ItemRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Item
{
    use EntityDateStampTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\ManyToOne(inversedBy: 'items')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Characters $owner = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getOwner(): ?Characters
    {
        return $this->owner;
    }

    public function setOwner(?Characters $owner): static
    {
        $this->owner = $owner;

        return $this;
    }
}
