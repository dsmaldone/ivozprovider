<?php

namespace Ivoz\Provider\Application\Service\PickUpGroup;

use Assert\Assertion;
use Ivoz\Core\Application\DataTransferObjectInterface;
use Ivoz\Core\Application\Service\Assembler\CustomDtoAssemblerInterface;
use Ivoz\Core\Domain\Model\EntityInterface;
use Ivoz\Provider\Domain\Model\PickUpGroup\PickUpGroupDto;
use Ivoz\Provider\Domain\Model\PickUpGroup\PickUpGroupInterface;
use Ivoz\Provider\Domain\Model\PickUpRelUser\PickUpRelUser;

class PickUpGroupDtoAssembler implements CustomDtoAssemblerInterface
{
    /**
     * @param PickUpGroupInterface $entity
     * @throws \Exception
     */
    public function toDto(EntityInterface $entity, int $depth = 0, string $context = null): DataTransferObjectInterface
    {
        Assertion::isInstanceOf($entity, PickUpGroupInterface::class);

        /** @var PickUpGroupDto $dto */
        $dto = $entity->toDto($depth);

        if (in_array($context, PickUpGroupDto::CONTEXTS_WITH_USERS, true)) {
            $userIds = array_map(
                function (PickUpRelUser $relUser) {
                    return $relUser
                        ->getUser()
                        ->getId();
                },
                $entity->getRelUsers()
            );

            $dto->setUserIds(
                $userIds
            );
        }

        return $dto;
    }
}
