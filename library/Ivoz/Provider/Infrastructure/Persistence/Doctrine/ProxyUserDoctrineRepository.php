<?php

namespace Ivoz\Provider\Infrastructure\Persistence\Doctrine;

use Doctrine\ORM\EntityRepository;
use Ivoz\Provider\Domain\Model\ProxyUser\ProxyUserRepository;

/**
 * ProxyUserDoctrineRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProxyUserDoctrineRepository extends EntityRepository implements ProxyUserRepository
{
}