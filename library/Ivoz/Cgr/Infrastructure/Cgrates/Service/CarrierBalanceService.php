<?php

namespace Ivoz\Cgr\Infrastructure\Cgrates\Service;

use Ivoz\Core\Domain\Assert\Assertion;
use Ivoz\Core\Domain\Model\EntityInterface;
use Ivoz\Core\Infrastructure\Domain\Service\Cgrates\AbstractBalanceService;
use Ivoz\Provider\Domain\Model\Carrier\CarrierInterface;
use Ivoz\Provider\Domain\Service\Carrier\CarrierBalanceServiceInterface;

class CarrierBalanceService extends AbstractBalanceService implements CarrierBalanceServiceInterface
{
    const ACCOUNT_PREFIX = 'cr';

    /**
     * @see \Ivoz\Provider\Domain\Service\Carrier\CarrierBalanceServiceInterface::incrementBalance
     * @inheritdoc
     */
    public function incrementBalance(CarrierInterface $company, float $amount)
    {
        return parent::addBalance($company, $amount);
    }

    /**
     * @see \Ivoz\Provider\Domain\Service\Carrier\CarrierBalanceServiceInterface::decrementBalance
     * @inheritdoc
     */
    public function decrementBalance(CarrierInterface $company, float $amount)
    {
        return parent::debitBalance($company, $amount);
    }

    /**
     * @see \Ivoz\Provider\Domain\Service\Carrier\CarrierBalanceServiceClientInterface::getBalances
     * @inheritdoc
     */
    public function getBalances($brandId, array $carrierIds)
    {
        $payload = parent::getAccountsBalances($brandId, $carrierIds, self::ACCOUNT_PREFIX);
        $balances = [];
        foreach ($payload->result as $balance) {
            $balances += $this->balanceReducer($balance);
        }
        $payload->result = $balances;

        return $payload;
    }

    /**
     * @see \Ivoz\Provider\Domain\Service\Carrier\CarrierBalanceServiceClientInterface::getBalance
     * @inheritdoc
     */
    public function getBalance($brandId, $carrierId)
    {
        $carrierIds = [$carrierId];
        $payload = $this->getBalances($brandId, $carrierIds);

        if (!array_key_exists($carrierId, $payload->result)) {
            throw new \Exception('Balance not found');
        }

        return $payload->result[$carrierId];
    }

    /**
     * @param CarrierInterface $entity
     * @return string
     * @throws \InvalidArgumentException
     * @see AbstractBalanceService::getTenant
     */
    protected function getTenant(EntityInterface $entity)
    {
        Assertion::isInstanceOf(
            $entity,
            CarrierInterface::class
        );

        $brand = $entity->getBrand();

        return $brand->getCgrTenant();
    }

    /**
     * @see AbstractBalanceService::getAccount
     * @inheritdoc
     */
    protected function getAccount(EntityInterface $entity)
    {
        Assertion::isInstanceOf(
            $entity,
            CarrierInterface::class
        );

        /** @var CarrierInterface $entity */
        return $entity->getCgrSubject();
    }
}
