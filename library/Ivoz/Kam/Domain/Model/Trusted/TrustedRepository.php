<?php

namespace Ivoz\Kam\Domain\Model\Trusted;

use Doctrine\Common\Collections\Selectable;
use Doctrine\Common\Persistence\ObjectRepository;

interface TrustedRepository extends ObjectRepository, Selectable
{

}
