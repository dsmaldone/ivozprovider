<?php

namespace Ivoz\Provider\Domain\Model\MatchListPattern;

class MatchListPatternDto extends MatchListPatternDtoAbstract
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
                'description' => 'description',
                'type' => 'type',
                'regexp' => 'regexp',
                'numbervalue' => 'numbervalue'
            ];
        }

        return parent::getPropertyMap(...func_get_args());
    }
}
