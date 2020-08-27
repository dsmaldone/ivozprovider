<?php

namespace Ivoz\Cgr\Domain\Service\TpAccountAction;

use Ivoz\Cgr\Domain\Model\TpAccountAction\TpAccountAction;
use Ivoz\Cgr\Domain\Model\TpAccountAction\TpAccountActionRepository;
use Ivoz\Core\Application\Service\EntityTools;
use Ivoz\Core\Domain\Service\EntityPersisterInterface;
use Ivoz\Provider\Domain\Model\Company\CompanyInterface;
use Ivoz\Provider\Domain\Service\Company\CompanyLifecycleEventHandlerInterface;

class CreateByCompany implements CompanyLifecycleEventHandlerInterface
{

    protected $entityPersister;
    protected $tpAccountActionRepository;
    protected $entityTools;

    /**
     * UpdateByDestinationTpAccountAction constructor.
     * @param EntityPersisterInterface $entityPersister
     */
    public function __construct(
        EntityPersisterInterface $entityPersister,
        TpAccountActionRepository $tpAccountActionRepository,
        EntityTools $entityTools
    ) {
        $this->entityPersister = $entityPersister;
        $this->tpAccountActionRepository = $tpAccountActionRepository;
        $this->entityTools = $entityTools;
    }

    public static function getSubscribedEvents()
    {
        return [
            self::EVENT_POST_PERSIST => 20
        ];
    }

    /**
     * @return void
     */
    public function execute(CompanyInterface $company)
    {
        $isNew = $company->isNew();

        if ($isNew) {
            $brand = $company->getBrand();
            $accountActionDto = TpAccountAction::createDTO();

            // Fill all rating plan fields
            $accountActionDto
                ->setTpid($brand->getCgrTenant())
                ->setCompanyId($company->getId())
                ->setTenant($brand->getCgrTenant())
                ->setActionTriggersTag($company->getCgrSubject())
                ->setAccount($company->getCgrSubject());
        } else {
            $accountAction = $this->tpAccountActionRepository
                ->findByCompany(
                    $company->getId()
                );

            $accountActionDto = $this->entityTools->entityToDto(
                $accountAction
            );
        }

        $allowNegative = $company->getBillingMethod() === CompanyInterface::BILLINGMETHOD_POSTPAID
            ? 1
            : 0;

        $accountActionDto->setAllowNegative($allowNegative);

        $this->entityPersister->persistDto(
            $accountActionDto,
            null
        );
    }
}
