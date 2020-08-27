<?php

namespace Ivoz\Provider\Domain\Service\TransformationRule;

use Ivoz\Core\Application\Service\EntityTools;
use Ivoz\Provider\Domain\Model\TransformationRule\TransformationRuleInterface;
use Ivoz\Provider\Domain\Model\TransformationRuleSet\TransformationRuleSetInterface;
use Ivoz\Provider\Domain\Service\TransformationRuleSet\DisableGenerateRules;
use Ivoz\Provider\Domain\Service\TransformationRuleSet\TransformationRuleSetLifecycleEventHandlerInterface;

/**
 * Class GenerateRules
 * @package Ivoz\Provider\Domain\Service\TransformationRule
 */
class GenerateRules implements TransformationRuleSetLifecycleEventHandlerInterface
{
    protected $entityTools;
    protected $generateInRules;
    protected $generateOutRules;
    protected $disableGenerateRules;

    public function __construct(
        EntityTools $entityTools,
        GenerateInRules $generateInRules,
        GenerateOutRules $generateOutRules,
        DisableGenerateRules $disableGenerateRules
    ) {
        $this->entityTools = $entityTools;
        $this->generateInRules = $generateInRules;
        $this->generateOutRules = $generateOutRules;
        $this->disableGenerateRules = $disableGenerateRules;
    }

    public static function getSubscribedEvents()
    {
        return [
            self::EVENT_POST_PERSIST => 10
        ];
    }

    /**
     * @return void
     */
    public function execute(TransformationRuleSetInterface $transformationRuleSet)
    {
        // Only if requested to autogenerate rules
        if (!$transformationRuleSet->getGenerateRules()) {
            return;
        }

        // Delete existing Rules for given ruleset
        /** @var TransformationRuleInterface[] $rules */
        $rules = $transformationRuleSet->getRules();
        foreach ($rules as $rule) {
            $transformationRuleSet
                ->removeRule($rule);

            $this->entityTools
                ->remove($rule);
        }

        // Generate rules
        $this->generateInRules->execute($transformationRuleSet, 'callerin');
        $this->generateInRules->execute($transformationRuleSet, 'calleein');
        $this->generateOutRules->execute($transformationRuleSet, 'callerout');
        $this->generateOutRules->execute($transformationRuleSet, 'calleeout');

        $this->disableGenerateRules->execute(
            $transformationRuleSet
        );

        $this->entityTools->dispatchQueuedOperations();
    }
}
