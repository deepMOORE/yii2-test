<?php

namespace app\controllers;

use app\services\ReportService;
use yii\web\Controller;
use yii\filters\AccessControl;
use app\components\RbacHelper;
use Yii;

class ReportController extends Controller
{
    private ReportService $reportService;

    public function __construct($id, $module, ReportService $reportService, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->reportService = $reportService;
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'matchCallback' => function () {
                            return RbacHelper::canViewCatalog();
                        }
                    ],
                ],
            ],
        ];
    }

    public function actionTopAuthors()
    {
        $year = Yii::$app->request->get('year', date('Y'));

        $report = $this->reportService->getTopAuthorsReport($year);

        return $this->render('top-authors', [
            'topAuthors' => $report->authors,
            'selectedYear' => $year,
            'years' => $report->years,
        ]);
    }
}