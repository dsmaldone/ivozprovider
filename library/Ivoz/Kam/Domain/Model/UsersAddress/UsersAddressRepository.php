<?php

namespace Ivoz\Kam\Domain\Model\UsersAddress;

use Doctrine\Common\Collections\Selectable;
use Doctrine\Common\Persistence\ObjectRepository;

interface UsersAddressRepository extends ObjectRepository, Selectable
{

}
