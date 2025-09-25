<?php declare(strict_types=1);

namespace app\services;

use app\models\Book;
use app\repositories\BookRepository;
use app\services\queue\jobs\books\NewBookNotifyUsersJob;
use app\services\queue\QueueJobDispatcher;
use yii\db\Exception;
use yii\web\NotFoundHttpException;

class BookService
{
    public function __construct(
        private readonly BookRepository $bookRepository,
    ){
    }

    public function create($data)
    {
        $model = new Book();

        if ($model->load($data) && $model->validate()) {
            if ($model->save()) {
                if (is_array($model->authorIds) && !empty($model->authorIds)) {
                    QueueJobDispatcher::dispatch(new NewBookNotifyUsersJob([
                        'authorIds' => $model->authorIds,
                        'book' => $model,
                    ]));
                }
                return $model;
            }
            throw new Exception('Не удалось сохранить книгу');
        }

        return $model;
    }

    public function update($id, $data)
    {
        $model = $this->requireBookById($id);

        if ($model->load($data) && $model->validate()) {
            if ($model->save()) {
                return $model;
            }
            throw new Exception('Не удалось обновить книгу');
        }

        return $model;
    }

    public function delete($id)
    {
        $model = $this->requireBookById($id);

        if (!$model->delete()) {
            throw new Exception('Не удалось удалить книгу');
        }

        return true;
    }

    public function findModel($id)
    {
        return $this->bookRepository->findModel($id);
    }

    public function getDataProvider($options = [])
    {
        return $this->bookRepository->getDataProvider($options);
    }

    private function requireBookById($id): Book
    {
        $model = $this->bookRepository->findModel($id);
        if ($model === null) {
            throw new NotFoundHttpException('Книга не найдена.');
        }

        return $model;
    }
}