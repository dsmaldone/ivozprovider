<?php

namespace Ivoz\Provider\Domain\Model\InvoiceScheduler;

use Ivoz\Core\Application\DataTransferObjectInterface;
use Ivoz\Core\Application\Model\DtoNormalizer;

/**
 * @codeCoverageIgnore
 */
abstract class InvoiceSchedulerDtoAbstract implements DataTransferObjectInterface
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $unit = 'month';

    /**
     * @var integer
     */
    private $frequency;

    /**
     * @var string
     */
    private $email;

    /**
     * @var \DateTime | string
     */
    private $lastExecution;

    /**
     * @var string
     */
    private $lastExecutionError;

    /**
     * @var \DateTime | string
     */
    private $nextExecution;

    /**
     * @var float
     */
    private $taxRate;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Ivoz\Provider\Domain\Model\InvoiceTemplate\InvoiceTemplateDto | null
     */
    private $invoiceTemplate;

    /**
     * @var \Ivoz\Provider\Domain\Model\Brand\BrandDto | null
     */
    private $brand;

    /**
     * @var \Ivoz\Provider\Domain\Model\Company\CompanyDto | null
     */
    private $company;

    /**
     * @var \Ivoz\Provider\Domain\Model\InvoiceNumberSequence\InvoiceNumberSequenceDto | null
     */
    private $numberSequence;

    /**
     * @var \Ivoz\Provider\Domain\Model\FixedCostsRelInvoiceScheduler\FixedCostsRelInvoiceSchedulerDto[] | null
     */
    private $relFixedCosts = null;


    use DtoNormalizer;

    public function __construct($id = null)
    {
        $this->setId($id);
    }

    /**
     * @inheritdoc
     */
    public static function getPropertyMap(string $context = '', string $role = null)
    {
        if ($context === self::CONTEXT_COLLECTION) {
            return ['id' => 'id'];
        }

        return [
            'name' => 'name',
            'unit' => 'unit',
            'frequency' => 'frequency',
            'email' => 'email',
            'lastExecution' => 'lastExecution',
            'lastExecutionError' => 'lastExecutionError',
            'nextExecution' => 'nextExecution',
            'taxRate' => 'taxRate',
            'id' => 'id',
            'invoiceTemplateId' => 'invoiceTemplate',
            'brandId' => 'brand',
            'companyId' => 'company',
            'numberSequenceId' => 'numberSequence'
        ];
    }

    /**
     * @return array
     */
    public function toArray($hideSensitiveData = false)
    {
        $response = [
            'name' => $this->getName(),
            'unit' => $this->getUnit(),
            'frequency' => $this->getFrequency(),
            'email' => $this->getEmail(),
            'lastExecution' => $this->getLastExecution(),
            'lastExecutionError' => $this->getLastExecutionError(),
            'nextExecution' => $this->getNextExecution(),
            'taxRate' => $this->getTaxRate(),
            'id' => $this->getId(),
            'invoiceTemplate' => $this->getInvoiceTemplate(),
            'brand' => $this->getBrand(),
            'company' => $this->getCompany(),
            'numberSequence' => $this->getNumberSequence(),
            'relFixedCosts' => $this->getRelFixedCosts()
        ];

        if (!$hideSensitiveData) {
            return $response;
        }

        foreach ($this->sensitiveFields as $sensitiveField) {
            if (!array_key_exists($sensitiveField, $response)) {
                throw new \Exception($sensitiveField . ' field was not found');
            }
            $response[$sensitiveField] = '*****';
        }

        return $response;
    }

    /**
     * @param string $name
     *
     * @return static
     */
    public function setName($name = null)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string | null
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $unit
     *
     * @return static
     */
    public function setUnit($unit = null)
    {
        $this->unit = $unit;

        return $this;
    }

    /**
     * @return string | null
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * @param integer $frequency
     *
     * @return static
     */
    public function setFrequency($frequency = null)
    {
        $this->frequency = $frequency;

        return $this;
    }

    /**
     * @return integer | null
     */
    public function getFrequency()
    {
        return $this->frequency;
    }

    /**
     * @param string $email
     *
     * @return static
     */
    public function setEmail($email = null)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string | null
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param \DateTime $lastExecution
     *
     * @return static
     */
    public function setLastExecution($lastExecution = null)
    {
        $this->lastExecution = $lastExecution;

        return $this;
    }

    /**
     * @return \DateTime | null
     */
    public function getLastExecution()
    {
        return $this->lastExecution;
    }

    /**
     * @param string $lastExecutionError
     *
     * @return static
     */
    public function setLastExecutionError($lastExecutionError = null)
    {
        $this->lastExecutionError = $lastExecutionError;

        return $this;
    }

    /**
     * @return string | null
     */
    public function getLastExecutionError()
    {
        return $this->lastExecutionError;
    }

    /**
     * @param \DateTime $nextExecution
     *
     * @return static
     */
    public function setNextExecution($nextExecution = null)
    {
        $this->nextExecution = $nextExecution;

        return $this;
    }

    /**
     * @return \DateTime | null
     */
    public function getNextExecution()
    {
        return $this->nextExecution;
    }

    /**
     * @param float $taxRate
     *
     * @return static
     */
    public function setTaxRate($taxRate = null)
    {
        $this->taxRate = $taxRate;

        return $this;
    }

    /**
     * @return float | null
     */
    public function getTaxRate()
    {
        return $this->taxRate;
    }

    /**
     * @param integer $id
     *
     * @return static
     */
    public function setId($id = null)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return integer | null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param \Ivoz\Provider\Domain\Model\InvoiceTemplate\InvoiceTemplateDto $invoiceTemplate
     *
     * @return static
     */
    public function setInvoiceTemplate(\Ivoz\Provider\Domain\Model\InvoiceTemplate\InvoiceTemplateDto $invoiceTemplate = null)
    {
        $this->invoiceTemplate = $invoiceTemplate;

        return $this;
    }

    /**
     * @return \Ivoz\Provider\Domain\Model\InvoiceTemplate\InvoiceTemplateDto | null
     */
    public function getInvoiceTemplate()
    {
        return $this->invoiceTemplate;
    }

    /**
     * @param mixed | null $id
     *
     * @return static
     */
    public function setInvoiceTemplateId($id)
    {
        $value = !is_null($id)
            ? new \Ivoz\Provider\Domain\Model\InvoiceTemplate\InvoiceTemplateDto($id)
            : null;

        return $this->setInvoiceTemplate($value);
    }

    /**
     * @return mixed | null
     */
    public function getInvoiceTemplateId()
    {
        if ($dto = $this->getInvoiceTemplate()) {
            return $dto->getId();
        }

        return null;
    }

    /**
     * @param \Ivoz\Provider\Domain\Model\Brand\BrandDto $brand
     *
     * @return static
     */
    public function setBrand(\Ivoz\Provider\Domain\Model\Brand\BrandDto $brand = null)
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * @return \Ivoz\Provider\Domain\Model\Brand\BrandDto | null
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * @param mixed | null $id
     *
     * @return static
     */
    public function setBrandId($id)
    {
        $value = !is_null($id)
            ? new \Ivoz\Provider\Domain\Model\Brand\BrandDto($id)
            : null;

        return $this->setBrand($value);
    }

    /**
     * @return mixed | null
     */
    public function getBrandId()
    {
        if ($dto = $this->getBrand()) {
            return $dto->getId();
        }

        return null;
    }

    /**
     * @param \Ivoz\Provider\Domain\Model\Company\CompanyDto $company
     *
     * @return static
     */
    public function setCompany(\Ivoz\Provider\Domain\Model\Company\CompanyDto $company = null)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * @return \Ivoz\Provider\Domain\Model\Company\CompanyDto | null
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * @param mixed | null $id
     *
     * @return static
     */
    public function setCompanyId($id)
    {
        $value = !is_null($id)
            ? new \Ivoz\Provider\Domain\Model\Company\CompanyDto($id)
            : null;

        return $this->setCompany($value);
    }

    /**
     * @return mixed | null
     */
    public function getCompanyId()
    {
        if ($dto = $this->getCompany()) {
            return $dto->getId();
        }

        return null;
    }

    /**
     * @param \Ivoz\Provider\Domain\Model\InvoiceNumberSequence\InvoiceNumberSequenceDto $numberSequence
     *
     * @return static
     */
    public function setNumberSequence(\Ivoz\Provider\Domain\Model\InvoiceNumberSequence\InvoiceNumberSequenceDto $numberSequence = null)
    {
        $this->numberSequence = $numberSequence;

        return $this;
    }

    /**
     * @return \Ivoz\Provider\Domain\Model\InvoiceNumberSequence\InvoiceNumberSequenceDto | null
     */
    public function getNumberSequence()
    {
        return $this->numberSequence;
    }

    /**
     * @param mixed | null $id
     *
     * @return static
     */
    public function setNumberSequenceId($id)
    {
        $value = !is_null($id)
            ? new \Ivoz\Provider\Domain\Model\InvoiceNumberSequence\InvoiceNumberSequenceDto($id)
            : null;

        return $this->setNumberSequence($value);
    }

    /**
     * @return mixed | null
     */
    public function getNumberSequenceId()
    {
        if ($dto = $this->getNumberSequence()) {
            return $dto->getId();
        }

        return null;
    }

    /**
     * @param array $relFixedCosts
     *
     * @return static
     */
    public function setRelFixedCosts($relFixedCosts = null)
    {
        $this->relFixedCosts = $relFixedCosts;

        return $this;
    }

    /**
     * @return array | null
     */
    public function getRelFixedCosts()
    {
        return $this->relFixedCosts;
    }
}
