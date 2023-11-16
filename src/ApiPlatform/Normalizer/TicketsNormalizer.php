<?php

namespace App\ApiPlatform\Normalizer;

use App\Entity\Tickets;

use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\DependencyInjection\Attribute\AsDecorator;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerAwareInterface;
use Symfony\Component\Serializer\SerializerInterface;

#[AsDecorator('api_platform.jsonld.normalizer.item')]
class TicketsNormalizer implements NormalizerInterface, SerializerAwareInterface {

    private Security $security;
    private NormalizerInterface $normalizer;

    public function __construct(
        NormalizerInterface $normalizer,
        Security            $security,
    ) {
        $this->security = $security;
        $this->normalizer = $normalizer;
    }

    public function normalize($object, $format = null, array $context = []) {
        $result = $this->normalizer->normalize($object, $format, $context);

        return $result;
    }

    public function supportsNormalization($data, string $format = null, array $context = []): bool {
        return $this->normalizer->supportsNormalization($data, $format);
    }

    public function setSerializer(SerializerInterface $serializer) {
        if ($this->normalizer instanceof SerializerAwareInterface) {
            $this->normalizer->setSerializer($serializer);
        }
    }

}