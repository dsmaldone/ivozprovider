<?php

namespace Ivoz\Provider\Domain\Model\MatchList;

use Doctrine\Common\Collections\Selectable;
use Doctrine\Common\Persistence\ObjectRepository;

interface MatchListRepository extends ObjectRepository, Selectable
{
    public function getIdsByCompanyId(int $companyId): array;
}
