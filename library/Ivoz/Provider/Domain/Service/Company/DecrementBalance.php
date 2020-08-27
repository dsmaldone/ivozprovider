<?php

namespace Ivoz\Provider\Domain\Service\Company;

class DecrementBalance extends AbstractBalanceOperation
{
    /**
     * @param int $companyId
     * @param float $amount
     * @return boolean
     */
    public function execute($companyId, float $amount)
    {
        $this->logger->info('Company#%s\'s balance will be decreased by ' . $amount);
        $company = $this->companyRepository->find($companyId);
        $response = $this->client->decrementBalance($company, $amount);

        return $this->handleResponse(
            ($amount * -1),
            $response,
            $company
        );
    }
}
