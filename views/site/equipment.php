<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use yii\grid\CheckboxColumn;
use yii\grid\SerialColumn;
use yii\helpers\Url;
use yii\web\JqueryAsset;

$data=$dataProvider->getModels();
$k=count($data);
//debug($dataProvider);
$cl=$data[0]['name_f'];
$this->title = 'Обладнання '.'[ '.$cl.' ]';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-spr">
    <h3><?= Html::encode($this->title) ?></h3>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'summary' => false,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'format' => 'raw',
                'header' => 'Площадка',
                'value' => function($model) {
                    return $value = $model->name_area;
                }
            ],

            [
                'format' => 'raw',
                'header' => 'Назва <br /> точки',
                'value' => function($model) {
                    return $value = $model->name;

                }
            ],
            'type',
            'carry',
            'num_eqp',
            'zones',
            [
                'format' => 'raw',
                'header' => 'Потужність, <br /> кВт.',
                'contentOptions' =>function ($model, $key, $index, $column){
                    return ['class' => 'power'];
                },
                'value' => function($model) {
                    return $value = $model->power;

                }
            ],
            [
                'format' => 'raw',
                'header' => 'Коеф. <br /> транс.',
                'contentOptions' =>function ($model, $key, $index, $column){
                    return ['class' => 'k_tr'];
                },
                'value' => function($model) {
                    return $value = $model->koef_tr;

                }
            ],
            'eerm',
            [
                'format' => 'raw',
                'header' => 'RE',
                'contentOptions' =>function ($model, $key, $index, $column){
                    return ['class' => 're'];
                },
                'value' => function($model) {
                    return $value = $model->re;

                }
            ],
            [
                'format' => 'raw',
                'header' => 'Години <br /> роботи',
                'value' => function($model) {
                    return $value = $model->hour_month;

                }
            ],

            [
                'format' => 'raw',
                'header' => 'EIS код',
                'value' => function($model) {
                    return $value = $model->eis;

                }
            ],
            [
                'format' => 'raw',
                'header' => 'Субспож. кільк.',
                'value' => function($model) {
                    return $value = $model->kol;

                }
            ],

        ],
    ]);

    ?>

</div>




