<?php

namespace Ivoz\Provider\Domain\Service\Domain;

use Ivoz\Core\Application\Service\EntityTools;
use Ivoz\Provider\Domain\Model\Brand\BrandDto;
use Ivoz\Provider\Domain\Model\Brand\BrandInterface;
use Ivoz\Provider\Domain\Model\Domain\Domain;
use Ivoz\Provider\Domain\Model\Domain\DomainDto;
use Ivoz\Provider\Domain\Model\Domain\DomainInterface;
use Ivoz\Provider\Domain\Service\Brand\BrandLifecycleEventHandlerInterface;

/**
 * Class UpdateByBrand
 * @package Ivoz\Provider\Domain\Service\Domain
 */
class UpdateByBrand implements BrandLifecycleEventHandlerInterface
{
    const POST_PERSIST_PRIORITY = 10;

    /**
     * @var EntityTools
     */
    protected $entityTools;

    public function __construct(
        EntityTools $entityTools
    ) {
        $this->entityTools = $entityTools;
    }

    public static function getSubscribedEvents()
    {
        // This service is triggered twice. ¿PRE_PERSIST?
        return [
            self::EVENT_POST_PERSIST => self::POST_PERSIST_PRIORITY
        ];
    }

    /**
     * @return void
     */
    public function execute(BrandInterface $brand)
    {
        if (!$brand->hasChanged('domain_users')) {
            return;
        }

        $domainUsers = $brand->getDomainUsers();

        $domain = $brand->getDomain();

        // Empty domain field, delete any related domain
        if (!$domainUsers && $domain) {
            $this->entityTools->remove($domain);

            return;
        }

        // If domain field is filled, look for brand domains or create a new one
        if (is_null($domain)) {
            $domainDto = Domain::createDto();
        } else {
            $domainDto = $this->entityTools->entityToDto($domain);
        }

        /**
         * @var DomainDto $domainDto
         */
        $domainDto
            ->setDomain($domainUsers)
            ->setDescription($brand->getName() . " proxyusers domain");

        $domain = $this
            ->entityTools
            ->persistDto($domainDto, $domain, true);

        /** @var BrandDto $brandDto */
        $brandDto = $this
            ->entityTools
            ->entityToDto(
                $brand
            );

        $brandDto
            ->setDomain($domainDto);

        $this
            ->entityTools
            ->persistDto(
                $brandDto,
                $brand
            );
    }
}
