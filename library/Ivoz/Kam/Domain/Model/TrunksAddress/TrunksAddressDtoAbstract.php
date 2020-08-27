<?php

namespace Ivoz\Kam\Domain\Model\TrunksAddress;

use Ivoz\Core\Application\DataTransferObjectInterface;
use Ivoz\Core\Application\Model\DtoNormalizer;

/**
 * @codeCoverageIgnore
 */
abstract class TrunksAddressDtoAbstract implements DataTransferObjectInterface
{
    /**
     * @var integer
     */
    private $grp = 1;

    /**
     * @var string
     */
    private $ipAddr;

    /**
     * @var integer
     */
    private $mask = 32;

    /**
     * @var integer
     */
    private $port = 0;

    /**
     * @var string
     */
    private $tag;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Ivoz\Provider\Domain\Model\DdiProviderAddress\DdiProviderAddressDto | null
     */
    private $ddiProviderAddress;


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
            'grp' => 'grp',
            'ipAddr' => 'ipAddr',
            'mask' => 'mask',
            'port' => 'port',
            'tag' => 'tag',
            'id' => 'id',
            'ddiProviderAddressId' => 'ddiProviderAddress'
        ];
    }

    /**
     * @return array
     */
    public function toArray($hideSensitiveData = false)
    {
        $response = [
            'grp' => $this->getGrp(),
            'ipAddr' => $this->getIpAddr(),
            'mask' => $this->getMask(),
            'port' => $this->getPort(),
            'tag' => $this->getTag(),
            'id' => $this->getId(),
            'ddiProviderAddress' => $this->getDdiProviderAddress()
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
     * @param integer $grp
     *
     * @return static
     */
    public function setGrp($grp = null)
    {
        $this->grp = $grp;

        return $this;
    }

    /**
     * @return integer | null
     */
    public function getGrp()
    {
        return $this->grp;
    }

    /**
     * @param string $ipAddr
     *
     * @return static
     */
    public function setIpAddr($ipAddr = null)
    {
        $this->ipAddr = $ipAddr;

        return $this;
    }

    /**
     * @return string | null
     */
    public function getIpAddr()
    {
        return $this->ipAddr;
    }

    /**
     * @param integer $mask
     *
     * @return static
     */
    public function setMask($mask = null)
    {
        $this->mask = $mask;

        return $this;
    }

    /**
     * @return integer | null
     */
    public function getMask()
    {
        return $this->mask;
    }

    /**
     * @param integer $port
     *
     * @return static
     */
    public function setPort($port = null)
    {
        $this->port = $port;

        return $this;
    }

    /**
     * @return integer | null
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * @param string $tag
     *
     * @return static
     */
    public function setTag($tag = null)
    {
        $this->tag = $tag;

        return $this;
    }

    /**
     * @return string | null
     */
    public function getTag()
    {
        return $this->tag;
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
     * @param \Ivoz\Provider\Domain\Model\DdiProviderAddress\DdiProviderAddressDto $ddiProviderAddress
     *
     * @return static
     */
    public function setDdiProviderAddress(\Ivoz\Provider\Domain\Model\DdiProviderAddress\DdiProviderAddressDto $ddiProviderAddress = null)
    {
        $this->ddiProviderAddress = $ddiProviderAddress;

        return $this;
    }

    /**
     * @return \Ivoz\Provider\Domain\Model\DdiProviderAddress\DdiProviderAddressDto | null
     */
    public function getDdiProviderAddress()
    {
        return $this->ddiProviderAddress;
    }

    /**
     * @param mixed | null $id
     *
     * @return static
     */
    public function setDdiProviderAddressId($id)
    {
        $value = !is_null($id)
            ? new \Ivoz\Provider\Domain\Model\DdiProviderAddress\DdiProviderAddressDto($id)
            : null;

        return $this->setDdiProviderAddress($value);
    }

    /**
     * @return mixed | null
     */
    public function getDdiProviderAddressId()
    {
        if ($dto = $this->getDdiProviderAddress()) {
            return $dto->getId();
        }

        return null;
    }
}
