<?php

namespace Ivoz\Kam\Domain\Model\UsersWatcher;

use Doctrine\Common\Collections\Selectable;
use Doctrine\Common\Persistence\ObjectRepository;

interface UsersWatcherRepository extends ObjectRepository, Selectable
{

}
