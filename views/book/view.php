<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\components\RbacHelper;

$this->title = $book->title;
$this->params['breadcrumbs'][] = ['label' => 'Каталог книг', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<table border="1" cellpadding="15" cellspacing="0" width="100%">
    <tr>
        <td width="250" valign="top">
            <?php if ($book->cover_image): ?>
                <?= Html::img('/uploads/covers/' . $book->cover_image, [
                    'alt' => Html::encode($book->title),
                    'width' => 250,
                    'height' => 350
                ]) ?>
            <?php else: ?>
                <div align="center" width="250" height="350">
                    <h3>Нет обложки</h3>
                </div>
            <?php endif; ?>
        </td>
        <td valign="top">
            <h1><?= Html::encode($book->title) ?></h1>

            <p><strong>Автор(ы):</strong></p>
            <ul>
                <?php foreach ($book->authors as $author): ?>
                    <li><?= Html::encode($author->full_name) ?></li>
                <?php endforeach; ?>
            </ul>

            <p><strong>Год выпуска:</strong> <?= Html::encode($book->year) ?></p>

            <?php if ($book->isbn): ?>
                <p><strong>ISBN:</strong> <?= Html::encode($book->isbn) ?></p>
            <?php endif; ?>

            <p>
                <?= Html::a('← Вернуться к каталогу', ['index']) ?>

                <?php if (RbacHelper::canManageBooks()): ?>
                    <br><br>
                    <?= Html::a('Редактировать', ['update', 'id' => $book->id], [
                        'style' => 'background-color: #5bc0de; color: white; padding: 8px 16px; text-decoration: none; border-radius: 4px; margin: 0 8px 0 0;'
                    ]) ?>
                    <?= Html::a('Удалить', ['delete', 'id' => $book->id], [
                        'style' => 'background-color: #d9534f; color: white; padding: 8px 16px; text-decoration: none; border-radius: 4px;',
                        'data' => [
                            'confirm' => 'Вы уверены, что хотите удалить книгу "' . Html::encode($book->title) . '"?',
                            'method' => 'post',
                        ],
                    ]) ?>
                <?php endif; ?>
            </p>
        </td>
    </tr>
</table>

<?php if ($book->description): ?>
    <hr>
    <h3>Описание</h3>
    <p><?= Html::encode($book->description) ?></p>
<?php endif; ?>