<?php

namespace Ivoz\Provider\Domain\Model\Service;

use Ivoz\Core\Domain\Model\EntityInterface;

interface ServiceInterface extends EntityInterface
{
    /**
     * @return array
     */
    public function getChangeSet();

    /**
     * Set iden
     *
     * @param string $iden
     *
     * @return self
     */
    public function setIden($iden);

    /**
     * Get iden
     *
     * @return string
     */
    public function getIden();

    /**
     * Set defaultCode
     *
     * @param string $defaultCode
     *
     * @return self
     */
    public function setDefaultCode($defaultCode);

    /**
     * Get defaultCode
     *
     * @return string
     */
    public function getDefaultCode();

    /**
     * Set extraArgs
     *
     * @param boolean $extraArgs
     *
     * @return self
     */
    public function setExtraArgs($extraArgs);

    /**
     * Get extraArgs
     *
     * @return boolean
     */
    public function getExtraArgs();

    /**
     * Set name
     *
     * @param \Ivoz\Provider\Domain\Model\Service\Name $name
     *
     * @return self
     */
    public function setName(\Ivoz\Provider\Domain\Model\Service\Name $name);

    /**
     * Get name
     *
     * @return \Ivoz\Provider\Domain\Model\Service\Name
     */
    public function getName();

    /**
     * Set description
     *
     * @param \Ivoz\Provider\Domain\Model\Service\Description $description
     *
     * @return self
     */
    public function setDescription(\Ivoz\Provider\Domain\Model\Service\Description $description);

    /**
     * Get description
     *
     * @return \Ivoz\Provider\Domain\Model\Service\Description
     */
    public function getDescription();

}
