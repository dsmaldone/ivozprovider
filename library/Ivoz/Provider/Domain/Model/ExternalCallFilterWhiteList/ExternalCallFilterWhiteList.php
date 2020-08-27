<?php

namespace Ivoz\Provider\Domain\Model\ExternalCallFilterWhiteList;

/**
 * ExternalCallFilterWhiteList
 */
class ExternalCallFilterWhiteList extends ExternalCallFilterWhiteListAbstract implements ExternalCallFilterWhiteListInterface
{
    use ExternalCallFilterWhiteListTrait;

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
