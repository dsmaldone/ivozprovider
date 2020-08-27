<?php

namespace Ivoz\Provider\Application\Service\CallCsvReport;

use Assert\Assertion;
use Ivoz\Core\Application\DataTransferObjectInterface;
use Ivoz\Core\Application\Service\Assembler\CustomDtoAssemblerInterface;
use Ivoz\Core\Application\Service\StoragePathResolverCollection;
use Ivoz\Core\Domain\Model\EntityInterface;
use Ivoz\Provider\Domain\Model\CallCsvReport\CallCsvReportDto;
use Ivoz\Provider\Domain\Model\CallCsvReport\CallCsvReportInterface;

class CallCsvReportDtoAssembler implements CustomDtoAssemblerInterface
{
    protected $storagePathResolver;

    public function __construct(
        StoragePathResolverCollection $storagePathResolver
    ) {
        $this->storagePathResolver = $storagePathResolver;
    }

    /**
     * @param CallCsvReportInterface $callCsvReport
     * @throws \Exception
     */
    public function toDto(EntityInterface $callCsvReport, int $depth = 0, string $context = null): DataTransferObjectInterface
    {
        Assertion::isInstanceOf($callCsvReport, CallCsvReportInterface::class);

        /** @var CallCsvReportDTO $dto */
        $dto = $callCsvReport->toDto($depth);
        $id = $callCsvReport->getId();

        if (!$id) {
            return $dto;
        }

        if (!is_null($callCsvReport->getCsv()->getFileSize())) {
            $pathResolver = $this
                ->storagePathResolver
                ->getPathResolver('Csv');

            $dto->setCsvPath(
                $pathResolver->getFilePath($callCsvReport)
            );
        }

        return $dto;
    }
}
