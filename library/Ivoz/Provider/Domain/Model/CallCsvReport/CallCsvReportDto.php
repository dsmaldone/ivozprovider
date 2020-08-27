<?php

namespace Ivoz\Provider\Domain\Model\CallCsvReport;

class CallCsvReportDto extends CallCsvReportDtoAbstract
{
    private $csvPath;

    /**
     * @inheritdoc
     */
    public static function getPropertyMap(string $context = '', string $role = null)
    {
        if ($context === self::CONTEXT_COLLECTION) {
            $response = [
                'id' => 'id',
                'inDate' => 'inDate',
                'outDate' => 'outDate',
            ];
        } else {
            $response = parent::getPropertyMap(...func_get_args());
        }

        if ($role === 'ROLE_BRAND_ADMIN') {
            $response = self::filterFieldsForBrandAdmin($response);
        }

        if ($role === 'ROLE_COMPANY_ADMIN') {
            unset($response['companyId']);
        }

        return $response;
    }

    public function denormalize(array $data, string $context, string $role = '')
    {
        $contextProperties = self::getPropertyMap($context, $role);
        if ($role === 'ROLE_COMPANY_ADMIN') {
            $contextProperties['companyId'] = 'company';
        }

        $this->setByContext(
            $contextProperties,
            $data
        );
    }

    /**
     * @param array $response
     * @return array
     */
    private static function filterFieldsForBrandAdmin(array $response): array
    {
        $allowedFields = [
            'sentTo',
            'inDate',
            'outDate',
            'createdOn',
            'id',
            'csv',
            'brandId',
            'callCsvSchedulerId'
        ];

        return array_filter(
            $response,
            function ($key) use ($allowedFields) {
                return in_array($key, $allowedFields, true);
            },
            ARRAY_FILTER_USE_KEY
        );
    }

    public function getFileObjects()
    {
        return [
            'csv'
        ];
    }

    /**
     * @return self
     */
    public function setCsvPath(string $path = null)
    {
        $this->csvPath = $path;

        return $this;
    }

    /**
     * @return string
     */
    public function getCsvPath()
    {
        return $this->csvPath;
    }
}
