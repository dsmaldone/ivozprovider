<?php

namespace Ivoz\Kam\Domain\Model\UsersCdr;

/**
 * UsersCdr
 */
class UsersCdr extends UsersCdrAbstract implements UsersCdrInterface
{
    use UsersCdrTrait;

    const DIRECTION_OUTBOUND = "outbound";
    const DIRECTION_INBOUND = "inbound";

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getOwner()
    {
        if (!is_null($this->getUser())) {
            return $this->getUser()->getFullNameExtension();
        } elseif (!is_null($this->getFriend())) {
            return $this->getFriend()->getName();
        } elseif (!is_null($this->getRetailAccount())) {
            return $this->getRetailAccount()->getName();
        } elseif (!is_null($this->getResidentialDevice())) {
            return $this->getResidentialDevice()->getName();
        }

        if ($this->getDirection() === UsersCdr::DIRECTION_OUTBOUND) {
            return $this->getCaller();
        } else {
            return $this->getCallee();
        }
    }

    /**
     * @return string
     */
    public function getParty()
    {
        if ($this->getDirection() === UsersCdr::DIRECTION_OUTBOUND) {
            return $this->getCallee();
        } else {
            return $this->getCaller();
        }
    }
}
