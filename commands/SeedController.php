<?php

namespace app\commands;

use Faker\Factory;
use yii\console\Controller;
use app\models\Author;
use app\models\Book;
use app\models\BookAuthor;

class SeedController extends Controller
{
    public function actionGenerate($count = 50)
    {
        $faker = Factory::create();

        echo "Генерация $count случайных книг с авторами...\n";

        for ($i = 0; $i < $count; $i++) {
            $author = new Author();
            $author->full_name = $faker->name;
            $author->save();

            $book = new Book();
            $book->title = $faker->sentence(rand(2, 5));
            $book->year = $faker->numberBetween(1800, 2023);
            $book->description = $faker->paragraph(rand(3, 6));
            $book->isbn = $faker->isbn13;
            $book->save();

            $bookAuthor = new BookAuthor();
            $bookAuthor->book_id = $book->id;
            $bookAuthor->author_id = $author->id;
            $bookAuthor->save();

            if ($faker->boolean(30)) {
                $additionalAuthor = new Author();
                $additionalAuthor->full_name = $faker->name;
                $additionalAuthor->save();

                $additionalBookAuthor = new BookAuthor();
                $additionalBookAuthor->book_id = $book->id;
                $additionalBookAuthor->author_id = $additionalAuthor->id;
                $additionalBookAuthor->save();
            }

            if (($i + 1) % 10 === 0) {
                echo "Создано " . ($i + 1) . " книг...\n";
            }
        }

        echo "Генерация завершена! Создано $count книг.\n";
    }

    public function actionClear()
    {
        echo "Очистка всех данных...\n";

        BookAuthor::deleteAll();
        Book::deleteAll();
        Author::deleteAll();

        echo "Все данные очищены!\n";
    }

    public function actionReset($count = 20)
    {
        $this->actionClear();
        $this->actionGenerate($count);

        echo "База данных пересоздана с $count записями!\n";
    }
}