<?php

namespace Ivoz\Provider\Domain\Model\CallAclRelMatchList;

/**
 * CallAclRelPattern
 */
class CallAclRelMatchList extends CallAclRelMatchListAbstract implements CallAclRelMatchListInterface
{
    use CallAclRelMatchListTrait;

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
