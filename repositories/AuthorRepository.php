<?php declare(strict_types=1);

namespace app\repositories;

use app\models\Author;

class AuthorRepository
{
    public function getTopAuthorsByYear(int $year, int $limit): array
    {
        return Author::find()
            ->select(['{{%authors}}.*', 'COUNT({{%books}}.id) as book_count'])
            ->joinWith('books')
            ->where(['{{%books}}.year' => $year])
            ->groupBy('{{%authors}}.id')
            ->orderBy('book_count DESC, {{%authors}}.full_name ASC')
            ->limit($limit)
            ->asArray()
            ->all();
    }
}