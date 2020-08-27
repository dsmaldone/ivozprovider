<?php

namespace Ivoz\Provider\Domain\Model\ConditionalRoute;

use Ivoz\Core\Application\DataTransferObjectInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;

/**
 * ConditionalRouteTrait
 * @codeCoverageIgnore
 */
trait ConditionalRouteTrait
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var ArrayCollection
     */
    protected $conditions;


    /**
     * Constructor
     */
    protected function __construct()
    {
        parent::__construct(...func_get_args());
        $this->conditions = new ArrayCollection();
    }

    abstract protected function sanitizeValues();

    /**
     * Factory method
     * @internal use EntityTools instead
     * @param ConditionalRouteDto $dto
     * @param \Ivoz\Core\Application\ForeignKeyTransformerInterface  $fkTransformer
     * @return static
     */
    public static function fromDto(
        DataTransferObjectInterface $dto,
        \Ivoz\Core\Application\ForeignKeyTransformerInterface $fkTransformer
    ) {
        /** @var static $self */
        $self = parent::fromDto($dto, $fkTransformer);
        if (!is_null($dto->getConditions())) {
            $self->replaceConditions(
                $fkTransformer->transformCollection(
                    $dto->getConditions()
                )
            );
        }
        $self->sanitizeValues();
        if ($dto->getId()) {
            $self->id = $dto->getId();
            $self->initChangelog();
        }

        return $self;
    }

    /**
     * @internal use EntityTools instead
     * @param ConditionalRouteDto $dto
     * @param \Ivoz\Core\Application\ForeignKeyTransformerInterface  $fkTransformer
     * @return static
     */
    public function updateFromDto(
        DataTransferObjectInterface $dto,
        \Ivoz\Core\Application\ForeignKeyTransformerInterface $fkTransformer
    ) {
        parent::updateFromDto($dto, $fkTransformer);
        if (!is_null($dto->getConditions())) {
            $this->replaceConditions(
                $fkTransformer->transformCollection(
                    $dto->getConditions()
                )
            );
        }
        $this->sanitizeValues();

        return $this;
    }

    /**
     * @internal use EntityTools instead
     * @param int $depth
     * @return ConditionalRouteDto
     */
    public function toDto($depth = 0)
    {
        $dto = parent::toDto($depth);
        return $dto
            ->setId($this->getId());
    }

    /**
     * @return array
     */
    protected function __toArray()
    {
        return parent::__toArray() + [
            'id' => self::getId()
        ];
    }
    /**
     * Add condition
     *
     * @param \Ivoz\Provider\Domain\Model\ConditionalRoutesCondition\ConditionalRoutesConditionInterface $condition
     *
     * @return static
     */
    public function addCondition(\Ivoz\Provider\Domain\Model\ConditionalRoutesCondition\ConditionalRoutesConditionInterface $condition)
    {
        $this->conditions->add($condition);

        return $this;
    }

    /**
     * Remove condition
     *
     * @param \Ivoz\Provider\Domain\Model\ConditionalRoutesCondition\ConditionalRoutesConditionInterface $condition
     */
    public function removeCondition(\Ivoz\Provider\Domain\Model\ConditionalRoutesCondition\ConditionalRoutesConditionInterface $condition)
    {
        $this->conditions->removeElement($condition);
    }

    /**
     * Replace conditions
     *
     * @param ArrayCollection $conditions of Ivoz\Provider\Domain\Model\ConditionalRoutesCondition\ConditionalRoutesConditionInterface
     * @return static
     */
    public function replaceConditions(ArrayCollection $conditions)
    {
        $updatedEntities = [];
        $fallBackId = -1;
        foreach ($conditions as $entity) {
            $index = $entity->getId() ? $entity->getId() : $fallBackId--;
            $updatedEntities[$index] = $entity;
            $entity->setConditionalRoute($this);
        }
        $updatedEntityKeys = array_keys($updatedEntities);

        foreach ($this->conditions as $key => $entity) {
            $identity = $entity->getId();
            if (in_array($identity, $updatedEntityKeys)) {
                $this->conditions->set($key, $updatedEntities[$identity]);
            } else {
                $this->conditions->remove($key);
            }
            unset($updatedEntities[$identity]);
        }

        foreach ($updatedEntities as $entity) {
            $this->addCondition($entity);
        }

        return $this;
    }

    /**
     * Get conditions
     * @param Criteria | null $criteria
     * @return \Ivoz\Provider\Domain\Model\ConditionalRoutesCondition\ConditionalRoutesConditionInterface[]
     */
    public function getConditions(Criteria $criteria = null)
    {
        if (!is_null($criteria)) {
            return $this->conditions->matching($criteria)->toArray();
        }

        return $this->conditions->toArray();
    }
}
