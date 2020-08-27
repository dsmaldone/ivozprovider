<?php

namespace Ivoz\Provider\Application\Service\Friend;

use Assert\Assertion;
use Ivoz\Core\Application\DataTransferObjectInterface;
use Ivoz\Core\Application\Service\Assembler\CustomDtoAssemblerInterface;
use Ivoz\Core\Domain\Model\EntityInterface;
use Ivoz\Core\Infrastructure\Symfony\HttpFoundation\RequestDateTimeResolver;
use Ivoz\Kam\Domain\Model\UsersLocation\RegistrationStatus;
use Ivoz\Kam\Domain\Model\UsersLocation\UsersLocationRepository;
use Ivoz\Provider\Domain\Model\Friend\FriendDto;
use Ivoz\Provider\Domain\Model\Friend\FriendInterface;

class FriendDtoAssembler implements CustomDtoAssemblerInterface
{
    protected $usersLocationRepository;
    protected $requestDateTimeResolver;

    public function __construct(
        UsersLocationRepository $usersLocationRepository,
        RequestDateTimeResolver $requestDateTimeResolver
    ) {
        $this->usersLocationRepository = $usersLocationRepository;
        $this->requestDateTimeResolver = $requestDateTimeResolver;
    }

    /**
     * @param FriendInterface $friend
     * @throws \Exception
     */
    public function toDto(EntityInterface $friend, int $depth = 0, string $context = null): DataTransferObjectInterface
    {
        Assertion::isInstanceOf($friend, FriendInterface::class);

        /** @var FriendDto $dto */
        $dto = $friend->toDto($depth);

        if (FriendDto::CONTEXT_STATUS !== $context) {
            return $dto;
        }

        $domain = $friend->getDomain();
        if (!$domain) {
            return $dto;
        }

        $dto->setDomainName(
            $domain->getDomain()
        );

        $userLocations = $this
            ->usersLocationRepository
            ->findByUsernameAndDomain(
                $friend->getName(),
                $domain->getDomain()
            );

        foreach ($userLocations as $userLocation) {
            $dto->addStatus(
                new RegistrationStatus(
                    $userLocation,
                    $this->requestDateTimeResolver->getTimezone()
                )
            );
        }

        return $dto;
    }
}
