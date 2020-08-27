<?php

namespace Ivoz\Provider\Domain\Model\QueueMember;

class QueueMemberDto extends QueueMemberDtoAbstract
{
    /**
     * @inheritdoc
     * @codeCoverageIgnore
     */
    public static function getPropertyMap(string $context = '', string $role = null)
    {
        if ($context === self::CONTEXT_COLLECTION) {
            return [
                'penalty' => 'penalty',
                'id' => 'id',
                'queueId' => 'queue',
                'userId' => 'user'
            ];
        }

        return parent::getPropertyMap(...func_get_args());
    }
}
