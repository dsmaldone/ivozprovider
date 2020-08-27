<?php

namespace Ivoz\Kam\Domain\Model\TrunksAddress;

/**
 * TrunksAddress
 */
class TrunksAddress extends TrunksAddressAbstract implements TrunksAddressInterface
{
    use TrunksAddressTrait;

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
