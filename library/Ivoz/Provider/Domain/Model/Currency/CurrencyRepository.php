<?php

namespace Ivoz\Provider\Domain\Model\Currency;

use Doctrine\Common\Collections\Selectable;
use Doctrine\Common\Persistence\ObjectRepository;

interface CurrencyRepository extends ObjectRepository, Selectable
{

}
