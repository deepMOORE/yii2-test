<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\components\RbacHelper;

?>
<table border="1" cellpadding="10" cellspacing="0" width="100%">
    <tr>
        <td width="150" valign="top">
            <?php if ($model->cover_image): ?>
                <?= Html::img('/uploads/covers/' . $model->cover_image, [
                    'alt' => Html::encode($model->title),
                    'width' => 150,
                    'height' => 200
                ]) ?>
            <?php else: ?>
                <div align="center" width="150" height="200">
                    <em>Нет обложки</em>
                </div>
            <?php endif; ?>
        </td>
        <td valign="top">
            <h3><?= Html::a(Html::encode($model->title), ['view', 'id' => $model->id]) ?></h3>

            <p><strong>Автор(ы):</strong> <?= Html::encode($model->getAuthorsString()) ?></p>

            <p><strong>Год:</strong> <?= Html::encode($model->year) ?></p>

            <?php if ($model->isbn): ?>
                <p><strong>ISBN:</strong> <?= Html::encode($model->isbn) ?></p>
            <?php endif; ?>

            <?php if ($model->description): ?>
                <p><em>
                    <?= Html::encode(mb_strlen($model->description) > 200
                        ? mb_substr($model->description, 0, 200) . '...'
                        : $model->description) ?>
                </em></p>
            <?php endif; ?>

            <p>
                <?= Html::a('Подробнее', ['view', 'id' => $model->id]) ?>

                <?php if (RbacHelper::canManageBooks()): ?>
                    |
                    <?= Html::a('Редактировать', ['update', 'id' => $model->id], [
                        'style' => 'background-color: #5bc0de; color: white; padding: 4px 8px; text-decoration: none; border-radius: 3px; margin: 0 4px;'
                    ]) ?>
                    <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
                        'style' => 'background-color: #d9534f; color: white; padding: 4px 8px; text-decoration: none; border-radius: 3px; margin: 0 4px;',
                        'data' => [
                            'confirm' => 'Вы уверены, что хотите удалить эту книгу?',
                            'method' => 'post',
                        ],
                    ]) ?>
                <?php endif; ?>
            </p>
        </td>
    </tr>
</table>
<br>