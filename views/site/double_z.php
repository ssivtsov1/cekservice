<?php


use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

use yii\grid\GridView;
use yii\grid\ActionColumn;
use yii\grid\CheckboxColumn;
use yii\grid\SerialColumn;

$this->title = "Дублі заявок з $date1 по $date2";
//$this->layout->title='Звіти [auto]';
$this->params['breadcrumbs'][] = $this->title;

echo Html::a('Експорт в Excel', ['site/autodouble2excel'
],
    ['class' => 'btn btn-info excel_btn',
        'data' => [
            'method' => 'post',
            'params' => [
                'data' => $sql
            ],
        ]]);
?>
<div class="site-spr">

    <h3><?= Html::encode($this->title) ?></h3>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'summary' => false,
        'emptyText' => 'Нічого не знайдено',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'trzDdate',
            'MODEL',
            'GOS_NOM',
            'cel',
            'marshrut',
            'marshrut_km',
            'note',
            'note_res',
            'sogl',
            'kol'
        ],
    ]); ?>

</div>



