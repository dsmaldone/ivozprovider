<?php

namespace Ivoz\Provider\Application\Service\RoutingPatternGroup;

use Assert\Assertion;
use Ivoz\Core\Application\DataTransferObjectInterface;
use Ivoz\Core\Application\Service\Assembler\CustomDtoAssemblerInterface;
use Ivoz\Core\Domain\Model\EntityInterface;
use Ivoz\Provider\Domain\Model\RoutingPatternGroup\RoutingPatternGroupDto;
use Ivoz\Provider\Domain\Model\RoutingPatternGroup\RoutingPatternGroupInterface;
use Ivoz\Provider\Domain\Model\RoutingPatternGroupsRelPattern\RoutingPatternGroupsRelPattern;

class RoutingPatternGroupDtoAssembler implements CustomDtoAssemblerInterface
{
    /**
     * @param RoutingPatternGroupInterface $entity
     * @throws \Exception
     */
    public function toDto(EntityInterface $entity, int $depth = 0, string $context = null): DataTransferObjectInterface
    {
        Assertion::isInstanceOf($entity, RoutingPatternGroupInterface::class);

        /** @var RoutingPatternGroupDto $dto */
        $dto = $entity->toDto($depth);

        if (in_array($context, RoutingPatternGroupDto::CONTEXTS_WITH_PATTERNS, true)) {
            $patternIds = array_map(
                function (RoutingPatternGroupsRelPattern $relFeature) {
                    return $relFeature
                        ->getRoutingPattern()
                        ->getId();
                },
                $entity->getRelPatterns()
            );

            $dto->setPatternIds(
                $patternIds
            );
        }

        return $dto;
    }
}
