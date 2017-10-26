<?php

namespace spec\Ivoz\Provider\Application\Service\Brand;

use Ivoz\Provider\Application\Service\Brand\BrandDtoAssembler;
use Ivoz\Provider\Domain\Model\Brand\BrandDTO;
use Ivoz\Provider\Domain\Model\Brand\BrandInterface;
use PhpSpec\Exception\Example\FailureException;
use PhpSpec\ObjectBehavior;

class BrandDtoAssemblerSpec extends ObjectBehavior
{
    protected $brand;

    function let(
        BrandInterface $brand
    ) {
        $this->brand = $brand;

        $this->beConstructedWith(
            '/opt/storage'
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(BrandDtoAssembler::class);
    }

    function it_should_do_nothing_with_no_id()
    {
        $dto = new BrandDTO();
        $this
            ->brand
            ->getId()
            ->willReturn(null);

        $this
            ->brand
            ->toDTO()
            ->willReturn($dto);

        $this
            ->toDto($this->brand)
            ->shouldReturn($dto);
    }

    function it_should_resolve_file_path_by_the_id()
    {
        $dto = new BrandDTO();
        $this
            ->brand
            ->getId()
            ->willReturn(1);

        $this
            ->brand
            ->toDTO()
            ->willReturn($dto);

        $this->toDto($this->brand);
        $logoPath = $dto->getLogoPath();

        if ($logoPath !== '/opt/storage/ivozprovider_model_brands.logo/0/1') {
            throw new FailureException($logoPath);
        }
    }

    function it_creates_subpaths_for_long_ids()
    {
        $dto = new BrandDTO();
        $this
            ->brand
            ->getId()
            ->willReturn(123456);

        $this
            ->brand
            ->toDTO()
            ->willReturn($dto);

        $this->toDto($this->brand);
        $logoPath = $dto->getLogoPath();

        if ($logoPath !== '/opt/storage/ivozprovider_model_brands.logo/1/2/3/4/5/123456') {
            throw new FailureException($logoPath);
        }
    }
}