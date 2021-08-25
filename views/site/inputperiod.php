<?php
// Ввод основных данных для поиска данных

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

if ($role == 0)
    $this->title = 'Звіт по заявкам за період';
if ($role == 1)
    $this->title = 'Дублі заявок';
?>

<div class="site-login">
    <h3><?= Html::encode($this->title) ?></h3>
    <div class="row">

        <div>
            <?php $form = ActiveForm::begin(['id' => 'inputperiod',
                'options' => [
                    'class' => 'form-horizontal col-lg-2',
                    'enctype' => 'multipart/form-data'

                ]]); ?>

            <?= $form->field($model, 'date1')->
            widget(\yii\jui\DatePicker::classname(), [
                'language' => 'uk'
            ]) ?>
            <?= $form->field($model, 'date2')->
            widget(\yii\jui\DatePicker::classname(), [
                'language' => 'uk'
            ]) ?>
            <? if($role==0): ?>
                <?= $form->field($model, 'nomer')->textInput() ?>
            <? endif; ?>

            <div class="form-group">
                <?= Html::submitButton('OK', ['class' => 'btn btn-primary']); ?>
            </div>
            <?php
            ActiveForm::end(); ?>
        </div>
    </div>
</div>






