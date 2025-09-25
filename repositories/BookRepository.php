<?php declare(strict_types=1);

namespace app\repositories;

use app\models\Book;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;

class BookRepository
{
    public function getAvailableYears(): array
    {
        return Book::find()
            ->select('year')
            ->distinct()
            ->orderBy('year DESC')
            ->column();
    }

    public function findModel($id): ?Book
    {
        return Book::findOne($id);
    }

    public function getDataProvider($options = []): ActiveDataProvider
    {
        $pageSize = $options['pageSize'] ?? 20;
        $sort = $options['sort'] ?? ['created_at' => SORT_DESC];

        return new ActiveDataProvider([
            'query' => Book::find()->with('authors'),
            'pagination' => [
                'pageSize' => $pageSize,
            ],
            'sort' => [
                'defaultOrder' => $sort
            ],
        ]);
    }
}