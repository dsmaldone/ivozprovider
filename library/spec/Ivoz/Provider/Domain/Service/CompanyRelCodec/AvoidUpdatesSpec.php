<?php

namespace spec\Ivoz\Provider\Domain\Service\CompanyRelCodec;

use Ivoz\Provider\Domain\Model\CompanyRelCodec\CompanyRelCodecInterface;
use Ivoz\Provider\Domain\Service\CompanyRelCodec\AvoidUpdates;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AvoidUpdatesSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(AvoidUpdates::class);
    }

    function its_does_nothing_on_new_entities(
        CompanyRelCodecInterface $entity
    ) {
        $entity
            ->getId()
            ->willReturn(null)
            ->shouldBeCalled();

        $this->execute($entity);
    }

    function its_does_now_allow_updated(
        CompanyRelCodecInterface $entity
    ) {
        $entity
            ->getId()
            ->willReturn(1)
            ->shouldBeCalled();

        $entity
            ->getChangedFields()
            ->willReturn(['companyId'])
            ->shouldBeCalled();

        $this
            ->shouldThrow(\DomainException::class)
            ->during('execute', [$entity]);
    }
}
