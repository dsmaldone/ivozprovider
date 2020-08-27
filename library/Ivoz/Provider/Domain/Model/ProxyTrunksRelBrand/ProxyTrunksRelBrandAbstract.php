<?php

namespace Ivoz\Provider\Domain\Model\ProxyTrunksRelBrand;

use Assert\Assertion;
use Ivoz\Core\Application\DataTransferObjectInterface;
use Ivoz\Core\Domain\Model\ChangelogTrait;
use Ivoz\Core\Domain\Model\EntityInterface;

/**
 * ProxyTrunksRelBrandAbstract
 * @codeCoverageIgnore
 */
abstract class ProxyTrunksRelBrandAbstract
{
    /**
     * @var \Ivoz\Provider\Domain\Model\Brand\BrandInterface | null
     */
    protected $brand;

    /**
     * @var \Ivoz\Provider\Domain\Model\ProxyTrunk\ProxyTrunkInterface
     */
    protected $proxyTrunk;


    use ChangelogTrait;

    /**
     * Constructor
     */
    protected function __construct()
    {
    }

    abstract public function getId();

    public function __toString()
    {
        return sprintf(
            "%s#%s",
            "ProxyTrunksRelBrand",
            $this->getId()
        );
    }

    /**
     * @return void
     * @throws \Exception
     */
    protected function sanitizeValues()
    {
    }

    /**
     * @param null $id
     * @return ProxyTrunksRelBrandDto
     */
    public static function createDto($id = null)
    {
        return new ProxyTrunksRelBrandDto($id);
    }

    /**
     * @internal use EntityTools instead
     * @param ProxyTrunksRelBrandInterface|null $entity
     * @param int $depth
     * @return ProxyTrunksRelBrandDto|null
     */
    public static function entityToDto(EntityInterface $entity = null, $depth = 0)
    {
        if (!$entity) {
            return null;
        }

        Assertion::isInstanceOf($entity, ProxyTrunksRelBrandInterface::class);

        if ($depth < 1) {
            return static::createDto($entity->getId());
        }

        if ($entity instanceof \Doctrine\ORM\Proxy\Proxy && !$entity->__isInitialized()) {
            return static::createDto($entity->getId());
        }

        /** @var ProxyTrunksRelBrandDto $dto */
        $dto = $entity->toDto($depth-1);

        return $dto;
    }

    /**
     * Factory method
     * @internal use EntityTools instead
     * @param ProxyTrunksRelBrandDto $dto
     * @return self
     */
    public static function fromDto(
        DataTransferObjectInterface $dto,
        \Ivoz\Core\Application\ForeignKeyTransformerInterface $fkTransformer
    ) {
        Assertion::isInstanceOf($dto, ProxyTrunksRelBrandDto::class);

        $self = new static();

        $self
            ->setBrand($fkTransformer->transform($dto->getBrand()))
            ->setProxyTrunk($fkTransformer->transform($dto->getProxyTrunk()))
        ;

        $self->initChangelog();

        return $self;
    }

    /**
     * @internal use EntityTools instead
     * @param ProxyTrunksRelBrandDto $dto
     * @return self
     */
    public function updateFromDto(
        DataTransferObjectInterface $dto,
        \Ivoz\Core\Application\ForeignKeyTransformerInterface $fkTransformer
    ) {
        Assertion::isInstanceOf($dto, ProxyTrunksRelBrandDto::class);

        $this
            ->setBrand($fkTransformer->transform($dto->getBrand()))
            ->setProxyTrunk($fkTransformer->transform($dto->getProxyTrunk()));



        return $this;
    }

    /**
     * @internal use EntityTools instead
     * @param int $depth
     * @return ProxyTrunksRelBrandDto
     */
    public function toDto($depth = 0)
    {
        return self::createDto()
            ->setBrand(\Ivoz\Provider\Domain\Model\Brand\Brand::entityToDto(self::getBrand(), $depth))
            ->setProxyTrunk(\Ivoz\Provider\Domain\Model\ProxyTrunk\ProxyTrunk::entityToDto(self::getProxyTrunk(), $depth));
    }

    /**
     * @return array
     */
    protected function __toArray()
    {
        return [
            'brandId' => self::getBrand() ? self::getBrand()->getId() : null,
            'proxyTrunkId' => self::getProxyTrunk()->getId()
        ];
    }
    // @codeCoverageIgnoreStart

    /**
     * Set brand
     *
     * @param \Ivoz\Provider\Domain\Model\Brand\BrandInterface $brand | null
     *
     * @return static
     */
    public function setBrand(\Ivoz\Provider\Domain\Model\Brand\BrandInterface $brand = null)
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * Get brand
     *
     * @return \Ivoz\Provider\Domain\Model\Brand\BrandInterface | null
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * Set proxyTrunk
     *
     * @param \Ivoz\Provider\Domain\Model\ProxyTrunk\ProxyTrunkInterface $proxyTrunk
     *
     * @return static
     */
    protected function setProxyTrunk(\Ivoz\Provider\Domain\Model\ProxyTrunk\ProxyTrunkInterface $proxyTrunk)
    {
        $this->proxyTrunk = $proxyTrunk;

        return $this;
    }

    /**
     * Get proxyTrunk
     *
     * @return \Ivoz\Provider\Domain\Model\ProxyTrunk\ProxyTrunkInterface
     */
    public function getProxyTrunk()
    {
        return $this->proxyTrunk;
    }

    // @codeCoverageIgnoreEnd
}
