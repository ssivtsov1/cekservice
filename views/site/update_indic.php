<?php
// Ввод показаний счетчиков

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use app\models\spr_area_type_energy;

use yii\bootstrap\Modal;
$this->title = 'Введення показань';
$this->params['breadcrumbs'][] = 'Введення показань';
//  debug($model);
?>

<script>

    window.addEventListener('load', function(){

        $('.form-group').css('margin-bottom','0px');
        $('.label-info').css('font-size','90%');
        $('.label-info').css('margin-bottom','-10px');

    });
</script>

<div class="site-login">

    <h3><?= Html::encode($this->title) ?></h3>
    
    <div class="row calc-connect">
        <div class="col-lg-4 calc-form">
            <?php $form = ActiveForm::begin(['id' => 'inputdata',
                'options' => [
                    'class' => 'form-horizontal col-lg-25',
                    'enctype' => 'multipart/form-data'
                    
                ]]); ?>
            <?
            if($vid=='Актив')
             echo('<span class="label label-info">Вид енергії: '.$vid.'</span>');
            if($vid=='Реактив')
                echo('<span class="label label-warning">Вид енергії: '.$vid.'</span>');
            if($vid=='Генерація')
                echo('<span class="label label-danger">Вид енергії: '.$vid.'</span>');
             ?>
            <?= $form->field($model, 're')->checkbox(); ?>
            <?= $form->field($model, 'name')->textInput(['disabled' => true]) ?>
            <?= $form->field($model, 'type')->textInput(['disabled' => true]) ?>
            <?= $form->field($model, 'num_eqp')->textInput(['disabled' => true]) ?>
            <?= $form->field($model, 'koef_tr')->textInput(['disabled' => true]) ?>
            <?= $form->field($model, 'value_diff')->textInput(['disabled' => true]) ?>
            <?= $form->field($model, 'date')->widget(\yii\jui\DatePicker::classname(), [
                'language' => 'uk'
            ]) ?>
            <?= $form->field($model, 'value')->textInput() ?>



            <div class="form-group">
                <?= Html::submitButton('OK', ['class' => 'btn btn-primary']); ?>

            </div>

            <?php

                ActiveForm::end();
            ?>
        </div>
    </div>
</div>

 
 
 



