<?php

namespace Ivoz\Provider\Domain\Service\Company;

use Ivoz\Core\Application\Service\EntityTools;
use Ivoz\Provider\Domain\Model\Company\CompanyInterface;
use Ivoz\Provider\Domain\Model\Company\CompanyRepository;
use Ivoz\Provider\Domain\Service\BalanceMovement\CreateByCompany;
use Symfony\Bridge\Monolog\Logger;

abstract class AbstractBalanceOperation
{

    protected $entityTools;
    protected $logger;
    protected $client;
    protected $companyRepository;
    protected $syncBalanceService;
    protected $lastError;
    protected $createBalanceMovementByCompany;

    public function __construct(
        EntityTools $entityTools,
        Logger $logger,
        CompanyBalanceServiceInterface $client,
        CompanyRepository $companyRepository,
        SyncBalances $syncBalanceService,
        CreateByCompany $createByCompany
    ) {
        $this->entityTools = $entityTools;
        $this->logger = $logger;
        $this->client = $client;
        $this->companyRepository = $companyRepository;
        $this->syncBalanceService = $syncBalanceService;
        $this->createBalanceMovementByCompany = $createByCompany;
    }

    /**
     * @param int $companyId
     * @param float $amount
     * @return boolean
     */
    abstract public function execute($companyId, float $amount);

    /**
     * @param string $amount
     * @param array $response
     * @param CompanyInterface $company
     * @return bool|mixed
     */
    protected function handleResponse($amount, array $response, CompanyInterface $company)
    {
        $success = false;
        if (isset($response['error']) && $response['error']) {
            $this->lastError = $response['error'];
            $this->logger->error('Could not modify balance: ' . $response['error']);
        }

        if (isset($response['success']) && $response['success']) {
            $success = $response['success'];

            $brandId = $company->getBrand()->getId();
            $companyIds = [$company->getId()];

            $this->syncBalanceService->updateCompanies($brandId, $companyIds);

            // Get current balance status
            $balance = $this->client->getBalance($brandId, $company->getId());

            $this->createBalanceMovementByCompany->execute(
                $company,
                $amount,
                $balance
            );
        }

        return $success;
    }

    /**
     * @return string
     */
    public function getLastError()
    {
        return $this->lastError;
    }
}
