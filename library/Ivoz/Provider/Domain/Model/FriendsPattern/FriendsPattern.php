<?php

namespace Ivoz\Provider\Domain\Model\FriendsPattern;

/**
 * FriendsPattern
 */
class FriendsPattern extends FriendsPatternAbstract implements FriendsPatternInterface
{
    use FriendsPatternTrait;

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
