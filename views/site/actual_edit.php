<?php
// Ввод статуса при просмотре данных по актуализации

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use app\models\spr_status_actual;
use yii\bootstrap\Modal;
$this->title = 'Перегляд данних';
$this->params['breadcrumbs'][] = 'Зміна статусу данних';
    
?>        

<div class="site-login">

    <h3><?= Html::encode($this->title) ?></h3>
    
    <div class="row calc-connect">
<!--        <div class="col-lg-4 calc-form1">-->
            <?php $form = ActiveForm::begin(['id' => 'inputdata',
                'options' => [
                    'class' => 'form-horizontal col-lg-25',
                    'enctype' => 'multipart/form-data'
                    
                ]]); ?>

            <div class="col-lg-6" id="docs">
                <p class="text-warning-doc">Документи (у форматі pdf):</p>
                <? if (count($doc_v)==0): ?>
                    <p class="text-warning-doc">Документи відсутні</p>
                <? endif; ?>

                <span class="text-warning-doc">ІНН:</span>
            <? if(is_doc($doc_v,1)): ?>

                <?= Html::a('...',['site/doc_request'], [
                    'data' => [
                        'method' => 'post',
                        'params' => [
                            'doc' => 1,
                            'id' => $model->id_unique,
                        ],
                    ],'class' => 'btn btn-info']); ?>

            <? endif; ?>
                <br>
                <br>

                <span class="text-warning-doc">Паспорт:</span>
                <? if(is_doc($doc_v,2)): ?>

                    <?= Html::a('...',['site/doc_request'], [
                        'data' => [
                            'method' => 'post',
                            'params' => [
                                'doc' => 2,
                                'id' => $model->id_unique,
                            ],
                        ],'class' => 'btn btn-info']); ?>

                <? endif; ?>
                <br>
                <br>

                <span class="text-warning-doc">Право власності:</span>
                <? if(is_doc($doc_v,3)): ?>

                    <?= Html::a('...',['site/doc_request'], [
                        'data' => [
                            'method' => 'post',
                            'params' => [
                                'doc' => 3,
                                'id' => $model->id_unique,
                            ],
                        ],'class' => 'btn btn-info']); ?>

                <? endif; ?>
                <br>
                <br>

                <span class="text-warning-doc">Заява на приєднання:</span>
                <? if(is_doc($doc_v,4)): ?>

                    <?= Html::a('...',['site/doc_request'], [
                        'data' => [
                            'method' => 'post',
                            'params' => [
                                'doc' => 4,
                                'id' => $model->id_unique,
                            ],
                        ],'class' => 'btn btn-info']); ?>
                <? endif; ?>

            </div>

            <div class="col-lg-4" id="vact_left">
             <?=$form->field($model, 'status')->dropDownList(
                 ArrayHelper::map(app\models\spr_status_actual::find()->all(), 'item', 'nazv'));?>
            <?= $form->field($model, 'nazv')->textInput(['disabled' => true]) ?>
            <?= $form->field($model, 'fio')->textInput(['disabled' => true]) ?>
            <?= $form->field($model, 'adres')->textInput(['disabled' => true]) ?>
            <?= $form->field($model, 'tel')->textInput(['disabled' => true]) ?>
            <?= $form->field($model, 'email')->textInput(['disabled' => true]) ?>
            
            <div class="form-group">
                <?= Html::submitButton('OK', ['class' => 'btn btn-primary']); ?>

            </div>

            <?php

                ActiveForm::end();
            ?>
            </div>
<!--        </div>-->
    </div>
</div>

 
 
 



