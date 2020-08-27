<?php

namespace Ivoz\Provider\Domain\Model\ApplicationServer;

/**
 * ApplicationServer
 */
class ApplicationServer extends ApplicationServerAbstract implements ApplicationServerInterface
{
    use ApplicationServerTrait;

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
