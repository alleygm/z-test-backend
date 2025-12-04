<?php

namespace App\Serializer;

use App\Entity\Tender;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class TenderSerializer implements NormalizerInterface, NormalizerAwareInterface
{
    use NormalizerAwareTrait;
    public function __construct(private TenderStatusSerializer $tss)
    {
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            Tender::class => true,
        ];
    }

    public function normalize(mixed $object, string $format = null, array $context = []): array
    {
        if (!$object instanceof Tender) {
            return [];
        }
        
        return [
            'id'           => $object->getId(),
            'externalCode' => $object->getExternalCode(),
            'number'       => $object->getNumber(),
            'name'         => $object->getName(),
            'status'       => $this->normalizer->normalize($object->getStatus()),
            'updatedAt'    => $object->getUpdatedAt()?->format('Y-m-d H:i:s'),
        ];
    }

    public function supportsNormalization(mixed $data, ?string $format = null, array $context = []): bool
    {
        return $data instanceof Tender;
    }
}
