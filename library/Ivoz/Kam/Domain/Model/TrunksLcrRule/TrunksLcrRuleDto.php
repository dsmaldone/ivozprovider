<?php

namespace Ivoz\Kam\Domain\Model\TrunksLcrRule;

class TrunksLcrRuleDto extends TrunksLcrRuleDtoAbstract
{

    /**
     * @inheritdoc
     * @codeCoverageIgnore
     */
    public static function getPropertyMap(string $context = '', string $role = null)
    {
        if ($context === self::CONTEXT_COLLECTION) {
            return [
                'id' => 'id',
                'prefix' => 'prefix',
                'fromUri' => 'fromUri',
            ];
        }

        return parent::getPropertyMap(...func_get_args());
    }
}
