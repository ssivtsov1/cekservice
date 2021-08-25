<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
$this->title = 'Передача показань лічильників з АСКОЕ в САП';
$this->params['breadcrumbs'][] = $this->title;
$arr1 = ['- Виберіть район *-','Дніпропетровський РЕМ',  'Жовтоводський РЕМ', 'Гвардійський РЕМ', 'Павлоградський РЕМ'];
?>
<div class = 'col-xs-5'>
    <h3><?=$this->title ?></h3>
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

    <?= $form->field($model, 'res')->label('РЕМ')  -> dropDownList ( $arr1 ) ;
    echo $form->field($model, 'code')->label('Особовий рахунок')->textinput();
    ?>

    <?= Html::submitButton('ОК',['class' => 'btn btn-success']) ?>

    <?php ActiveForm::end() ?>
</div>
