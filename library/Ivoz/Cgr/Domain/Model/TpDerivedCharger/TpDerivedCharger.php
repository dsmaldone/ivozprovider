<?php

namespace Ivoz\Cgr\Domain\Model\TpDerivedCharger;

/**
 * TpDerivedCharger
 */
class TpDerivedCharger extends TpDerivedChargerAbstract implements TpDerivedChargerInterface
{
    use TpDerivedChargerTrait;

    /**
     * @codeCoverageIgnore
     * @return array
     */
    public function getChangeSet()
    {
        return parent::getChangeSet();
    }

    /**
     * Get id
     * @codeCoverageIgnore
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}
