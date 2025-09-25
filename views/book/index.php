<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\helpers\Url;
use app\components\RbacHelper;

$this->title = 'Каталог книг';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (RbacHelper::canManageBooks()): ?>
        <p>
            <?= Html::a('Добавить книгу', ['create'], ['style' => 'background-color: #5cb85c; color: white; padding: 8px 16px; text-decoration: none; border-radius: 4px; display: inline-block; margin-bottom: 10px;']) ?>
        </p>
    <?php endif; ?>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_book_item',
        'summary' => 'Показано {begin}-{end} из {totalCount} книг',
        'emptyText' => 'Книги не найдены',
        'layout' => "{summary}\n<div class=\"books-grid\">{items}</div>\n{pager}",
    ]) ?>

</div>