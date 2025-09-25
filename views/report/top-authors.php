<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Топ 10 авторов по количеству книг';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="report-top-authors">
    <h1><?= Html::encode($this->title) ?></h1>

    <form method="get">
        <table width="100%">
            <tr>
                <td width="150"><strong>Выберите год:</strong></td>
                <td width="200">
                    <?= Html::dropDownList('year', $selectedYear, array_combine($years, $years), [
                        'prompt' => 'Все годы',
                        'onchange' => 'this.form.submit()'
                    ]) ?>
                </td>
                <td>
                    <?= Html::submitButton('Показать', [
                        'style' => 'background-color: #007bff; color: white; padding: 6px 12px; border: none; border-radius: 4px;'
                    ]) ?>
                </td>
            </tr>
        </table>
    </form>

    <?php if ($selectedYear): ?>
        <h2>Результат за <?= Html::encode($selectedYear) ?> год</h2>

        <?php if (empty($topAuthors)): ?>
            <p>За выбранный год книги не найдены.</p>
        <?php else: ?>
            <table width="100%" cellpadding="8" cellspacing="0" border="1" style="border-collapse: collapse;">
                <thead>
                    <tr style="background-color: #f8f9fa;">
                        <th width="80" align="center"><strong>Место</strong></th>
                        <th><strong>ФИО автора</strong></th>
                        <th width="150" align="center"><strong>Количество книг</strong></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $position = 1; ?>
                    <?php foreach ($topAuthors as $author): ?>
                        <tr>
                            <td align="center"><?= $position ?></td>
                            <td><?= Html::encode($author['full_name']) ?></td>
                            <td align="center"><?= $author['book_count'] ?></td>
                        </tr>
                        <?php $position++; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    <?php else: ?>
        <p>Выберите год для просмотра отчета.</p>
    <?php endif; ?>
</div>