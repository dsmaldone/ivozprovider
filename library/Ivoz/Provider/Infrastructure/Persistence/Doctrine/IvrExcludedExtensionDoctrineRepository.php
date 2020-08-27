<?php

namespace Ivoz\Provider\Infrastructure\Persistence\Doctrine;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Ivoz\Provider\Domain\Model\IvrExcludedExtension\IvrExcludedExtension;
use Ivoz\Provider\Domain\Model\IvrExcludedExtension\IvrExcludedExtensionRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * IvrEntryDoctrineRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class IvrExcludedExtensionDoctrineRepository extends ServiceEntityRepository implements IvrExcludedExtensionRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, IvrExcludedExtension::class);
    }
}
