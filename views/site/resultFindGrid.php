
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
//return;
$r=9-$k;

$this->title = 'Мережа ЦЕК ';
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
                'header' => 'РЕМ',
                'value' => function($model) {
                    return $value = $model['res'];
                }
            ],

            [
                'format' => 'raw',
                'header' => 'Телефон',
                'value' => function($model) {
                    return $value = $model['tel'];

                }
            ],

            [
                'format' => 'raw',
                'header' => 'Населений пункт',

                'value' => function($model) {
                    return $value = $model['town'];

                }
            ],
            [
                'format' => 'raw',
                'header' => 'Вулиця',

                'value' => function($model) {
                    return $value = $model['street'];

                }
            ],

            [
                'format' => 'raw',
                'header' => 'Будинок',
                'value' => function($model) {
                    return $value = $model['house'];
                }
            ],
            [
                'format' => 'raw',
                'header' => 'Корпус',
                'value' => function($model) {
                    return $value = $model['korp'];

                }
            ],



        ],
    ]);

    ?>

</div>
<?php
for($i=1;$i<$r;$i++){
?>
<br>
<?php
}
?>





