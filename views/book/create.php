<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Author;

$this->title = 'Добавить книгу';
$this->params['breadcrumbs'][] = ['label' => 'Каталог книг', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>

    <table width="100%">
        <tr>
            <td width="200" valign="top"><strong>Название:</strong></td>
            <td><?= $form->field($model, 'title')->textInput(['maxlength' => true])->label(false) ?></td>
        </tr>
        <tr>
            <td valign="top"><strong>Год выпуска:</strong></td>
            <td><?= $form->field($model, 'year')->textInput(['type' => 'number'])->label(false) ?></td>
        </tr>
        <tr>
            <td valign="top"><strong>ISBN:</strong></td>
            <td><?= $form->field($model, 'isbn')->textInput(['maxlength' => true])->label(false) ?></td>
        </tr>
        <tr>
            <td valign="top"><strong>Описание:</strong></td>
            <td><?= $form->field($model, 'description')->textarea(['rows' => 6])->label(false) ?></td>
        </tr>
        <tr>
            <td valign="top"><strong>Авторы:</strong></td>
            <td><?= $form->field($model, 'authorIds')->dropDownList(
                ArrayHelper::map(Author::find()->orderBy('full_name')->all(), 'id', 'full_name'),
                [
                    'multiple' => true,
                    'size' => 5,
                    'prompt' => ''
                ]
            )->label(false) ?></td>
        </tr>
        <tr>
            <td></td>
            <td>
                <div>
                    <?= Html::submitButton('Сохранить', ['style' => 'background-color: #5cb85c; color: white; padding: 8px 16px; border: none; border-radius: 4px; margin-right: 8px;']) ?>
                    <?= Html::a('Отмена', ['index'], ['style' => 'background-color: #6c757d; color: white; padding: 8px 16px; text-decoration: none; border-radius: 4px;']) ?>
                </div>
            </td>
        </tr>
    </table>

    <?php ActiveForm::end(); ?>

</div>