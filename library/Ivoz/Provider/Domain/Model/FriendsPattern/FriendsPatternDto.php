<?php

namespace Ivoz\Provider\Domain\Model\FriendsPattern;

class FriendsPatternDto extends FriendsPatternDtoAbstract
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
                'name' => 'name',
                'regExp' => 'regExp'
            ];
        }

        return parent::getPropertyMap(...func_get_args());
    }
}
