<?php

namespace Ivoz\Provider\Domain\Model\RoutingPattern;

use Doctrine\Common\Collections\Selectable;
use Doctrine\Common\Persistence\ObjectRepository;

interface RoutingPatternRepository extends ObjectRepository, Selectable
{

}
