<?php

namespace App\Serializer;

use App\Entity\TenderStatus;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class TenderStatusSerializer implements NormalizerInterface, DenormalizerInterface
{
    public function __construct(
        private EntityManagerInterface $em
    ){}

    public function getSupportedTypes(?string $format): array
    {
        return [          
            TenderStatus::class => true,
        ];
    }

    public function normalize(mixed $object, string $format = null, array $context = []): array
    {
        if (!$object instanceof TenderStatus) {
            return [];
        }

        return [
            'id'   => $object->getId(),
            'name' => $object->getName(),
        ];
    }

    public function supportsNormalization(mixed $data, ?string $format = null, array $context = []): bool
    {
        return $data instanceof TenderStatus;
    }


    public function denormalize(mixed $data, string $type, string $format = null, array $context = []): TenderStatus
    {
        // Если приходит ID — пытаемся найти статус в БД
        if (is_int($data)) {
            $status = $this->em->getRepository(TenderStatus::class)->find($data);
        }

        if (is_string($data)) {
            $status = $this->em->getRepository(TenderStatus::class)->findOneBy(['name' => $data]);
        }

        if(!$status instanceof TenderStatus){
            throw new \InvalidArgumentException("Указанный статус не найден");
        }

        return $status;
    }
    public function supportsDenormalization(mixed $data, string $type, ?string $format = null, array $context = []): bool
    {
        return $type === TenderStatus::class;
    }
}
