<?php

namespace Ivoz\Provider\Domain\Model\TerminalManufacturer;

class TerminalManufacturerDto extends TerminalManufacturerDtoAbstract
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
                'iden' => 'iden',
                'name' => 'name'
            ];
        }

        return parent::getPropertyMap(...func_get_args());
    }
}
