<?php

namespace App\Entity;

use App\Repository\ItemTypeRepository;
use App\Trait\EntityDateStampTrait;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ItemTypeRepository::class)]
#[ORM\HasLifecycleCallbacks]
class ItemType
{
    use EntityDateStampTrait;
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

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
}
