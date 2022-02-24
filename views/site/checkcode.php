<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii \ helpers \ ArrayHelper;
use yii\jui\DatePicker;
?>
<div class = 'test col-xs-3' >
    <p>На Вашу електронну скриньку прийде повідомлення з кодом підтвердження. Введіть код підтвердження.</p>
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

<!--    --><?// echo $checkcode; ?>
    <?= $form->field($model_check, 'code')->label('Код підтвердження') -> textInput() ?>


    <?= Html::submitButton('OK',['class' => 'btn btn-success']) ?>

    <?php ActiveForm::end() ?>
</div>
