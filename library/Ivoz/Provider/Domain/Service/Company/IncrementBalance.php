<?php

namespace Ivoz\Provider\Domain\Service\Company;

class IncrementBalance extends AbstractBalanceOperation
{
    /**
     * @param int $companyId
     * @param float $amount
     * @return boolean
     */
    public function execute($companyId, float $amount)
    {
        $this->logger->info('Company#%s\'s balance will be incremented by ' . $amount);
        $company = $this->companyRepository->find($companyId);
        $response = $this->client->incrementBalance($company, $amount);

        return $this->handleResponse(
            $amount,
            $response,
            $company
        );
    }
}
