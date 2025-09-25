<?php declare(strict_types=1);

namespace app\models\reports;

final readonly class TopAuthorsReportModel
{
    public function __construct(
        public array $authors,
        public array $years,
    ) {
    }
}