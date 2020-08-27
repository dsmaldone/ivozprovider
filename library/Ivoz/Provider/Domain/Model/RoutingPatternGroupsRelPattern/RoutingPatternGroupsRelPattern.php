<?php

namespace Ivoz\Provider\Domain\Model\RoutingPatternGroupsRelPattern;

/**
 * RoutingPatternGroupsRelPattern
 */
class RoutingPatternGroupsRelPattern extends RoutingPatternGroupsRelPatternAbstract implements RoutingPatternGroupsRelPatternInterface
{
    use RoutingPatternGroupsRelPatternTrait;

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
