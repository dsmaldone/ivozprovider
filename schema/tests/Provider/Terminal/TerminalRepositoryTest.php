<?php

namespace Tests\Provider\Terminal;

use Ivoz\Provider\Domain\Model\Domain\Domain;
use Ivoz\Provider\Domain\Model\Domain\DomainInterface;
use Ivoz\Provider\Domain\Model\Domain\DomainRepository;
use Ivoz\Provider\Domain\Model\Terminal\TerminalRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Tests\DbIntegrationTestHelperTrait;
use Ivoz\Provider\Domain\Model\Terminal\Terminal;

class TerminalRepositoryTest extends KernelTestCase
{
    use DbIntegrationTestHelperTrait;

    /**
     * @test
     */
    public function test_runner()
    {
        $this->its_instantiable();
        $this->it_finds_one_by_name_and_domain();
        $this->it_counts_registrable_devices_by_brand();
    }

    public function its_instantiable()
    {
        /** @var TerminalRepository $repository */
        $repository = $this
            ->em
            ->getRepository(Terminal::class);

        $this->assertInstanceOf(
            TerminalRepository::class,
            $repository
        );
    }

    public function it_finds_one_by_name_and_domain()
    {
        /** @var TerminalRepository $repository */
        $repository = $this
            ->em
            ->getRepository(Terminal::class);

        /** @var DomainRepository $domainRepository */
        $domainRepository = $this
            ->em
            ->getRepository(Domain::class);

        /** @var DomainInterface $domain */
        $domain = $domainRepository->find(3);

        $terminal = $repository->findOneByNameAndDomain(
            'alice',
            $domain
        );

        $this->assertInstanceOf(
            Terminal::class,
            $terminal
        );
    }

    public function it_counts_registrable_devices_by_brand()
    {
        /** @var TerminalRepository $repository */
        $repository = $this
            ->em
            ->getRepository(Terminal::class);

        $num = $repository->countRegistrableDevices([1]);

        $this->assertInternalType(
            'int',
            $num
        );
    }
}
