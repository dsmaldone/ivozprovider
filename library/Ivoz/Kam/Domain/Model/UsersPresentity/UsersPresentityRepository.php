<?php

namespace Ivoz\Kam\Domain\Model\UsersPresentity;

use Doctrine\Common\Collections\Selectable;
use Doctrine\Common\Persistence\ObjectRepository;

interface UsersPresentityRepository extends ObjectRepository, Selectable
{

}
