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
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

    <?= $form->field($model, 'type')->label('Тип відключення') -> textInput() -> dropDownList ( $arr )?>

    <?= $form->field($model, 'begin_date')->label('Дата початку')-> widget(\yii\jui\DatePicker::classname(), ['language' => 'uk']) ?>

    <?= $form->field($model, 'end_date')->label('Дата закінчення')-> widget(\yii\jui\DatePicker::classname(), ['language' => 'uk']) ?>

    <?= $form->field($model, 'pidrozdil')->label('Підрозділ')  -> dropDownList ( $arr1 ) ?>

    <?= Html::submitButton('Надіслати',['class' => 'btn btn-success']) ?>

    <?php ActiveForm::end() ?>
</div>
