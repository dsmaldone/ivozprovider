<?php

namespace Ivoz\Provider\Application\Service\Brand;

use Assert\Assertion;
use Ivoz\Core\Application\DataTransferObjectInterface;
use Ivoz\Core\Application\Service\Assembler\CustomDtoAssemblerInterface;
use Ivoz\Core\Application\Service\StoragePathResolverCollection;
use Ivoz\Core\Domain\Model\EntityInterface;
use Ivoz\Provider\Domain\Model\Brand\BrandDto;
use Ivoz\Provider\Domain\Model\Brand\BrandInterface;
use Ivoz\Provider\Domain\Model\FeaturesRelBrand\FeaturesRelBrand;

class BrandDtoAssembler implements CustomDtoAssemblerInterface
{
    protected $storagePathResolver;

    public function __construct(
        StoragePathResolverCollection $storagePathResolver
    ) {
        $this->storagePathResolver = $storagePathResolver;
    }

    /**
     * @param BrandInterface $entity
     * @throws \Exception
     */
    public function toDto(EntityInterface $entity, int $depth = 0, string $context = null): DataTransferObjectInterface
    {
        Assertion::isInstanceOf($entity, BrandInterface::class);

        /** @var BrandDto $dto */
        $dto = $entity->toDto($depth);
        $id = $entity->getId();

        if (!$id) {
            return $dto;
        }

        if ($entity->getLogo()->getFileSize()) {
            $pathResolver = $this
                ->storagePathResolver
                ->getPathResolver('Logo');

            $dto->setLogoPath(
                $pathResolver->getFilePath($entity)
            );
        }

        if (in_array($context, BrandDto::CONTEXTS_WITH_FEATURES, true)) {
            $featureIds = array_map(
                function (FeaturesRelBrand $relFeature) {
                    return $relFeature
                        ->getFeature()
                        ->getId();
                },
                $entity->getRelFeatures()
            );

            $dto->setFeatures(
                $featureIds
            );
        }

        return $dto;
    }
}
