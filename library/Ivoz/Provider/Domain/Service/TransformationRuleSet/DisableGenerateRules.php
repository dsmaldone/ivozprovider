<?php

namespace Ivoz\Provider\Domain\Service\TransformationRuleSet;

use Ivoz\Core\Application\Service\EntityTools;
use Ivoz\Provider\Domain\Model\TransformationRuleSet\TransformationRuleSetDto;
use Ivoz\Provider\Domain\Model\TransformationRuleSet\TransformationRuleSetInterface;

class DisableGenerateRules
{
    protected $entityTools;

    public function __construct(
        EntityTools $entityTools
    ) {
        $this->entityTools = $entityTools;
    }

    /**
     * @return void
     */
    public function execute(
        TransformationRuleSetInterface $transformationRuleSet,
        $dispatchImmediately = false
    ) {
        // Mark rules as generated
        /** @var TransformationRuleSetDto $transformationRuleSetDto */
        $transformationRuleSetDto = $this->entityTools->entityToDto($transformationRuleSet);

        $transformationRuleSetDto->setGenerateRules(false);
        $this->entityTools->persistDto(
            $transformationRuleSetDto,
            $transformationRuleSet,
            $dispatchImmediately
        );
    }
}
