<?php

namespace Ivoz\Provider\Domain\Model\InvoiceTemplate;

use Ivoz\Api\Core\Annotation\AttributeDefinition;

class InvoiceTemplateDto extends InvoiceTemplateDtoAbstract
{
    /**
     * @var string
     * @AttributeDefinition(
     *     type="bool",
     *     writable=false,
     *     description="Global Special Number"
     * )
     */
    protected $global;

    /**
     * @inheritdoc
     * @codeCoverageIgnore
     */
    public static function getPropertyMap(string $context = '', string $role = null)
    {
        if ($context === self::CONTEXT_COLLECTION) {
            $response = [
                'id' => 'id',
                'name' => 'name'
            ];
        } else {
            $response = parent::getPropertyMap(...func_get_args());
        }

        if ($role === 'ROLE_BRAND_ADMIN') {
            unset($response['brandId']);
            $response['global'] = 'global';
        }

        return $response;
    }

    public function normalize(string $context, string $role = '')
    {
        $response = parent::normalize(...func_get_args());

        $isBrandAdmin = $role === 'ROLE_BRAND_ADMIN';

        if ($isBrandAdmin) {
            $response['global'] = $this->getBrandId()
                ? false
                : true;
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
