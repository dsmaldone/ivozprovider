<?php

namespace Ivoz\Provider\Domain\Service\ProxyTrunk;

use Ivoz\Provider\Domain\Model\ProxyTrunk\ProxyTrunk;
use Ivoz\Provider\Domain\Model\ProxyTrunk\ProxyTrunkInterface;
use Ivoz\Provider\Domain\Model\Carrier\CarrierRepository;
use Ivoz\Provider\Domain\Model\DdiProvider\DdiProviderRepository;

/**
 * Class DeleteProtection
 */
class DeleteProtection implements ProxyTrunkLifecycleEventHandlerInterface
{
    const PRE_REMOVE_PRIORITY = self::PRIORITY_NORMAL;

    protected $carrierRepository;
    protected $ddiProviderRepository;

    public function __construct(
        CarrierRepository $carrierRepository,
        DdiProviderRepository $ddiProviderRepository
    ) {
        $this->carrierRepository = $carrierRepository;
        $this->ddiProviderRepository = $ddiProviderRepository;
    }

    public static function getSubscribedEvents()
    {
        return [
            self::EVENT_PRE_REMOVE => self::PRE_REMOVE_PRIORITY
        ];
    }

    /**
     * @param ProxyTrunkInterface $proxyTrunk
     *
     * @return void
     */
    public function execute(ProxyTrunkInterface $proxyTrunk)
    {
        $isMainAddress = $proxyTrunk->getId() == ProxyTrunk::MAIN_ADDRESS_ID;
        if ($isMainAddress) {
            throw new \DomainException("Main ProxyTrunk can not be removed.");
        }

        $carriers = $this->carrierRepository->findByProxyTrunks($proxyTrunk);
        $ddiProviders = $this->ddiProviderRepository->findByProxyTrunks($proxyTrunk);

        $carriersFound = !empty($carriers);
        $ddiProvidersFound = !empty($ddiProviders);
        if ($carriersFound || $ddiProvidersFound) {
            throw new \DomainException("Cannot unassign proxyTrunks IP as it is in use in at least one carrier or ddiProvider");
        }
    }
}
