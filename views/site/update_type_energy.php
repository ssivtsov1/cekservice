<?php
// Ввод основных данных для рассчета стоимости работ и услуг

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use app\models\spr_area_type_energy;

use yii\bootstrap\Modal;
$this->title = 'Вид споживання (по реактиву) для площадки';
$this->params['breadcrumbs'][] = 'Вид споживання (по реактиву) для площадки';
    
?>        

<div class="site-login">

    <h3><?= Html::encode($this->title) ?></h3>
    
    <div class="row calc-connect">
        <div class="col-lg-4 calc-form">
            <?php $form = ActiveForm::begin(['id' => 'inputdata',
                'options' => [
                    'class' => 'form-horizontal col-lg-25',
                    'enctype' => 'multipart/form-data'
                    
                ]]); ?>

             <? echo('Площадка: '.$name); ?>
            
             <?=$form->field($model, 'type_eqp')->dropDownList(
                 ArrayHelper::map(app\models\spr_area_type_energy::find()->all(), 'id', 'type'));?>
            <?= $form->field($model, 'eerm') ?>
            
            <div class="form-group">
                <?= Html::submitButton('OK', ['class' => 'btn btn-primary']); ?>

            </div>

            <?php

                ActiveForm::end();
            ?>
        </div>
    </div>
</div>

 
 
 



