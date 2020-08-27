<?php

namespace Ivoz\Provider\Domain\Model\Invoice;

class InvoiceDto extends InvoiceDtoAbstract
{
    private $pdfPath;


    public static function getPropertyMap(string $context = '', string $role = null)
    {
        if ($context === self::CONTEXT_COLLECTION) {
            $response = [
                'id' => 'id',
                'number' => 'number',
                'inDate' => 'inDate',
                'outDate' => 'outDate',
                'total' => 'total',
                'totalWithTax' => 'totalWithTax',
                'status' => 'status',
                'pdf' => ['fileSize','mimeType','baseName'],
                'invoiceTemplateId' => 'invoiceTemplate',
                'companyId' => 'company'
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

    public function getFileObjects()
    {
        return [
            'pdf'
        ];
    }

    /**
     * @return self
     */
    public function setPdfPath(string $path = null)
    {
        $this->pdfPath = $path;

        return $this;
    }

    /**
     * @return string
     */
    public function getPdfPath()
    {
        return $this->pdfPath;
    }
}
