<?php

declare(strict_types=1);

use Symfony\Component\PropertyInfo\Extractor\PhpDocExtractor;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\PropertyInfo\PropertyInfoExtractor;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AttributeLoader;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\PropertyNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

use function DI\get;

return [
    NormalizerInterface::class => get(SerializerInterface::class),
    DenormalizerInterface::class => get(SerializerInterface::class),

    SerializerInterface::class => static function (): SerializerInterface {
        return new Serializer([
            new ObjectNormalizer(new ClassMetadataFactory(new AttributeLoader())),
            new DateTimeNormalizer(),
            new PropertyNormalizer(
                propertyTypeExtractor: new PropertyInfoExtractor(typeExtractors: [
                    new ReflectionExtractor(),
                    new PhpDocExtractor(),
                ])
            ),
            new ArrayDenormalizer(),
        ], [
            new JsonEncoder(),
        ]);
    },
];
