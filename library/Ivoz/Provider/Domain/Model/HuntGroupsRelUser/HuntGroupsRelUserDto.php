<?php

namespace Ivoz\Provider\Domain\Model\HuntGroupsRelUser;

class HuntGroupsRelUserDto extends HuntGroupsRelUserDtoAbstract
{
    /**
     * @inheritdoc
     * @codeCoverageIgnore
     */
    public static function getPropertyMap(string $context = '', string $role = null)
    {
        if ($context === self::CONTEXT_COLLECTION) {
            return [
                'timeoutTime' => 'timeoutTime',
                'priority' => 'priority',
                'id' => 'id',
                'huntGroupId' => 'huntGroup',
                'routeType' => 'routeType'
            ];
        }

        return parent::getPropertyMap(...func_get_args());
    }
}
