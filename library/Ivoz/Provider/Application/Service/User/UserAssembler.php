<?php

namespace Ivoz\Provider\Application\Service\User;

use Assert\Assertion;
use Ivoz\Core\Application\DataTransferObjectInterface;
use Ivoz\Core\Application\ForeignKeyTransformerInterface;
use Ivoz\Core\Application\Service\Assembler\CustomEntityAssemblerInterface;
use Ivoz\Core\Domain\Model\EntityInterface;
use Ivoz\Provider\Domain\Model\User\UserDto;
use Ivoz\Provider\Domain\Model\User\UserInterface;

class UserAssembler implements CustomEntityAssemblerInterface
{
    /**
     * @param UserDto $userDto
     * @param UserInterface $user
     * @throws \Exception
     */
    public function fromDto(
        DataTransferObjectInterface $userDto,
        EntityInterface $user,
        ForeignKeyTransformerInterface $fkTransformer
    ) {
        Assertion::isInstanceOf($user, UserInterface::class);

        /** @var UserDto $userDto */
        $oldPass = $userDto->getOldPass();
        if ($oldPass && !password_verify($oldPass, $user->getPass())) {
            throw new \DomainException('Invalid password');
        }
        // There is not oldPass validation in klear, so, we can't do any further validation

        $user->updateFromDto($userDto, $fkTransformer);
    }
}
