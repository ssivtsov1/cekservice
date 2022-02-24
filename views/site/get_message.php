<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii \ helpers \ ArrayHelper;
use yii\jui\DatePicker;
$arr = ['- Оберіть тип *-', 'Планові', 'Аварійні'];
$arr1 = ['- Виберіть район *-', 'Дніпропетровські РЕМ', 'Вільногірські РЕМ', 'Павлоградські РЕМ', 'Гвардійська дільниця', 'Жовтоводські РЕМ', 'Криворізькі РЕМ','Апостолівська дільниця', 'Інгулецька дільниця'];
//$model->begin_date = date("Y-m-d");
//$model->end_date = $model->begin_date ;
?>
<div class = 'test col-xs-3' >
    <h3>Відключення у електромережах</h3>
    <h4>Введіть адресу електронної пошти для отримання повідомлень</h4>
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

    <?= $form->field($model, 'lic')->label('Особовий рахунок') -> textInput(['disabled' => true]) ?>
    <?= $form->field($model, 'email')->label('Адреса пошти') -> textInput() ?>

<!--    <p>Після підтвердження вводу адреси пошти Вам на електронну скриньку прийде повідомлення з кодом </p>-->

    <?= Html::submitButton('OK',['class' => 'btn btn-success']) ?>

    <?php ActiveForm::end() ?>
</div>
