<?php

namespace Ivoz\Provider\Infrastructure\Persistence\Doctrine;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Ivoz\Provider\Domain\Model\FixedCostsRelInvoice\FixedCostsRelInvoice;
use Ivoz\Provider\Domain\Model\FixedCostsRelInvoice\FixedCostsRelInvoiceRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * FixedCostsRelInvoiceDoctrineRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class FixedCostsRelInvoiceDoctrineRepository extends ServiceEntityRepository implements FixedCostsRelInvoiceRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, FixedCostsRelInvoice::class);
    }
}
