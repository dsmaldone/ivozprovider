<?php

namespace Ivoz\Kam\Domain\Model\TrunksHtable;

use Ivoz\Core\Application\DataTransferObjectInterface;
use Ivoz\Core\Application\Model\DtoNormalizer;

/**
 * @codeCoverageIgnore
 */
abstract class TrunksHtableDtoAbstract implements DataTransferObjectInterface
{
    /**
     * @var string
     */
    private $keyName = '';

    /**
     * @var integer
     */
    private $keyType = 0;

    /**
     * @var integer
     */
    private $valueType = 0;

    /**
     * @var string
     */
    private $keyValue = '';

    /**
     * @var integer
     */
    private $expires = 0;

    /**
     * @var integer
     */
    private $id;


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
            'keyName' => 'keyName',
            'keyType' => 'keyType',
            'valueType' => 'valueType',
            'keyValue' => 'keyValue',
            'expires' => 'expires',
            'id' => 'id'
        ];
    }

    /**
     * @return array
     */
    public function toArray($hideSensitiveData = false)
    {
        $response = [
            'keyName' => $this->getKeyName(),
            'keyType' => $this->getKeyType(),
            'valueType' => $this->getValueType(),
            'keyValue' => $this->getKeyValue(),
            'expires' => $this->getExpires(),
            'id' => $this->getId()
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
     * @param string $keyName
     *
     * @return static
     */
    public function setKeyName($keyName = null)
    {
        $this->keyName = $keyName;

        return $this;
    }

    /**
     * @return string | null
     */
    public function getKeyName()
    {
        return $this->keyName;
    }

    /**
     * @param integer $keyType
     *
     * @return static
     */
    public function setKeyType($keyType = null)
    {
        $this->keyType = $keyType;

        return $this;
    }

    /**
     * @return integer | null
     */
    public function getKeyType()
    {
        return $this->keyType;
    }

    /**
     * @param integer $valueType
     *
     * @return static
     */
    public function setValueType($valueType = null)
    {
        $this->valueType = $valueType;

        return $this;
    }

    /**
     * @return integer | null
     */
    public function getValueType()
    {
        return $this->valueType;
    }

    /**
     * @param string $keyValue
     *
     * @return static
     */
    public function setKeyValue($keyValue = null)
    {
        $this->keyValue = $keyValue;

        return $this;
    }

    /**
     * @return string | null
     */
    public function getKeyValue()
    {
        return $this->keyValue;
    }

    /**
     * @param integer $expires
     *
     * @return static
     */
    public function setExpires($expires = null)
    {
        $this->expires = $expires;

        return $this;
    }

    /**
     * @return integer | null
     */
    public function getExpires()
    {
        return $this->expires;
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
}
