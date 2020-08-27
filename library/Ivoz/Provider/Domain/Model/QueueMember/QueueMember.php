<?php

namespace Ivoz\Provider\Domain\Model\QueueMember;

/**
 * QueueMember
 */
class QueueMember extends QueueMemberAbstract implements QueueMemberInterface
{
    use QueueMemberTrait;

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
