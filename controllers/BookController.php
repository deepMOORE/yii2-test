<?php

namespace app\controllers;

use app\models\Book;
use app\services\BookService;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use app\components\RbacHelper;
use Yii;

class BookController extends Controller
{
    private BookService $bookService;

    public function __construct($id, $module, BookService $bookService, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->bookService = $bookService;
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'view'],
                        'matchCallback' => function () {
                            return RbacHelper::canViewCatalog();
                        }
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create', 'update', 'delete'],
                        'matchCallback' => function () {
                            return RbacHelper::canManageBooks();
                        }
                    ],
                ],
            ],
        ];
    }
    public function actionIndex()
    {
        $dataProvider = $this->bookService->getDataProvider();

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $book = $this->bookService->findModel($id);

        return $this->render('view', [
            'book' => $book,
        ]);
    }

    public function actionCreate()
    {
        $model = new Book();

        if (Yii::$app->request->isPost) {
            try {
                $model = $this->bookService->create([Book::class => Yii::$app->request->post(Book::class)]);

                if (!$model->hasErrors()) {
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            } catch (\Exception $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->bookService->findModel($id);

        if (Yii::$app->request->isPost) {
            try {
                $model = $this->bookService->update($id, [Book::class => Yii::$app->request->post(Book::class)]);

                if (!$model->hasErrors()) {
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            } catch (\Exception $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        try {
            $this->bookService->delete($id);
            Yii::$app->session->setFlash('success', 'Книга успешно удалена');
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }

        return $this->redirect(['index']);
    }
}