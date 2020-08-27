<?php

namespace Ivoz\Provider\Application\Service\DestinationRateGroup;

use Assert\Assertion;
use Ivoz\Core\Application\DataTransferObjectInterface;
use Ivoz\Core\Application\ForeignKeyTransformerInterface;
use Ivoz\Core\Application\Service\Assembler\CustomEntityAssemblerInterface;
use Ivoz\Core\Application\Service\StoragePathResolverCollection;
use Ivoz\Core\Application\Service\Traits\FileContainerEntityAssemblerTrait;
use Ivoz\Core\Domain\Model\EntityInterface;
use Ivoz\Provider\Domain\Model\DestinationRateGroup\DestinationRateGroupInterface;

class DestinationRateGroupAssembler implements CustomEntityAssemblerInterface
{
    use FileContainerEntityAssemblerTrait;

    public function __construct(
        StoragePathResolverCollection $storagePathResolver
    ) {
        $this->storagePathResolver = $storagePathResolver;
    }

    public function fromDto(
        DataTransferObjectInterface $destinationRateGroupDto,
        EntityInterface $destinationRateGroup,
        ForeignKeyTransformerInterface $fkTransformer
    ) {
        Assertion::isInstanceOf($destinationRateGroup, DestinationRateGroupInterface::class);
        $destinationRateGroup->updateFromDto($destinationRateGroupDto, $fkTransformer);
        $this->handleEntityFiles($destinationRateGroup, $destinationRateGroupDto, $fkTransformer);
    }
}
