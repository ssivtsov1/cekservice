<?php


use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use yii\grid\CheckboxColumn;
use yii\grid\SerialColumn;
//debug($dataProvider->getModels());
$this->title = 'Не передані показники з лічильників АСКОЕ в САП';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="site-spr10">

    <h3><?= Html::encode($this->title) ?></h3>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'summary' => false,
        'columns' => [

            ['class' => 'yii\grid\SerialColumn'],
            'lic',
            'ownername',
            'date',
            'val09',
            'val10',
            'status',
        ],
    ]); ?>

</div>


