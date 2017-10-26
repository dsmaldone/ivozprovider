<?php

namespace Ivoz\Provider\Infrastructure\Persistence\Doctrine;

use Doctrine\ORM\EntityRepository;
use Ivoz\Provider\Domain\Model\Invoice\InvoiceRepository;

/**
 * InvoiceDoctrineRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class InvoiceDoctrineRepository extends EntityRepository implements InvoiceRepository
{
    const ENTITY_ALIAS = 'invoice';


    /**
     * @inheritDoc
     */
    public function fetchInvoiceNumberInRange(
        int $companyId,
        int $brandId,
        string $utcInDate,
        string $utcOutDate,
        int $invoiceIdToBeExcluded = null
    ) {
        $querySegments = [
            self::ENTITY_ALIAS . '.company = :companyId',
            self::ENTITY_ALIAS . '.brand = :brandId',
            self::ENTITY_ALIAS . '.inDate >= :startTimeUtc',
            self::ENTITY_ALIAS . '.outDate <= :utcOutDate'
        ];
        $queryArguments = [
            'companyId' => $companyId,
            'brandId' => $brandId,
            'startTimeUtc' => $utcInDate,
            'utcOutDate' => $utcOutDate
        ];

        if ($invoiceIdToBeExcluded) {
            $querySegments += [
                self::ENTITY_ALIAS . '.id != :invoiceIdToBeExcluded'
            ];
            $queryArguments += [
                'invoiceIdToBeExcluded' => $invoiceIdToBeExcluded
            ];
        }

        $query = implode(' AND ', $querySegments);
        $qb = $this->createQueryBuilder(self::ENTITY_ALIAS);
        $qb->select('count(' . self::ENTITY_ALIAS  . ')')
            ->where($query)
            ->setParameters($queryArguments);

        return $qb
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * @inheritDoc
     */
    public function getInvoices(
        int $companyId,
        int $brandId,
        string $utcOutDate,
        int $invoiceIdToBeExcluded = null
    ) {
        $querySegments = [
            self::ENTITY_ALIAS . '.company = :companyId',
            self::ENTITY_ALIAS . '.brand = :brandId',
            self::ENTITY_ALIAS . '.outDate > :utcOutDate'
        ];
        $queryArguments = [
            'companyId' => $companyId,
            'brandId' => $brandId,
            'utcOutDate' => $utcOutDate
        ];

        if ($invoiceIdToBeExcluded) {
            $querySegments += [
                self::ENTITY_ALIAS . '.id != :invoiceIdToBeExcluded'
            ];
            $queryArguments += [
                'invoiceIdToBeExcluded' => $invoiceIdToBeExcluded
            ];
        }

        $query = implode(' AND ', $querySegments);
        $qb = $this->createQueryBuilder(self::ENTITY_ALIAS);
        $qb->select(self::ENTITY_ALIAS)
            ->where($query)
            ->addOrderBy(self::ENTITY_ALIAS . '.inDate',  'ASC')
            ->setParameters($queryArguments);

        return $qb
            ->getQuery()
            ->getResult();
    }
}