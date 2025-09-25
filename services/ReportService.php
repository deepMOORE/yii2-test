<?php declare(strict_types=1);

namespace app\services;

use app\models\reports\TopAuthorsReportModel;
use app\repositories\AuthorRepository;
use app\repositories\BookRepository;

class ReportService
{
    public function __construct(
        private readonly AuthorRepository $authorRepository,
        private readonly BookRepository $bookRepository,
    ){
    }

    public function getTopAuthorsReport(?int $year): TopAuthorsReportModel
    {
        $years = $this->bookRepository->getAvailableYears();

        $authors = [];
        if ($year !== null) {
            $authors = $this->authorRepository->getTopAuthorsByYear($year, $this->getLimit());
        }

        return new TopAuthorsReportModel($authors, $years);
    }

    private function getLimit(): int
    {
        return 10;
    }
}