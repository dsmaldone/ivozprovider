<?php

namespace Ivoz\Provider\Domain\Model\Administrator;

class AdministratorDto extends AdministratorDtoAbstract
{
    protected $sensitiveFields = [
        'pass',
    ];

    /**
     * @inheritdoc
     * @codeCoverageIgnore
     */
    public static function getPropertyMap(string $context = '', string $role = null)
    {
        if ($context === self::CONTEXT_COLLECTION) {
            $response = [
                'id' => 'id',
                'active' => 'active',
                'restricted' => 'restricted',
                'username' => 'username',
                'name' => 'name',
                'lastname' => 'lastname',
                'email' => 'email'
            ];
        } else {
            $response = parent::getPropertyMap(...func_get_args());
        }

        if ($role === 'ROLE_BRAND_ADMIN') {
            unset($response['brandId']);
        }

        return $response;
    }

    public function denormalize(array $data, string $context, string $role = '')
    {
        $contextProperties = self::getPropertyMap($context, $role);
        if ($role === 'ROLE_BRAND_ADMIN') {
            $contextProperties['brandId'] = 'brand';
        }

        $this->setByContext(
            $contextProperties,
            $data
        );
    }
}
