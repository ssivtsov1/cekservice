<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use yii\grid\SerialColumn;
use yii\helpers\ArrayHelper;

$this->title = "Звіт по заявкам з $date1 по $date2";
//$this->params['breadcrumbs'][] = $this->title;
echo Html::a('Експорт в Excel', ['site/autoviewz2excel'
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

        <h4><?php

            echo Html::encode($this->title);
            ?></h4>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'summary' => false,
            'emptyText' => 'Нічого не знайдено',
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'trzDdate',
                'name_pzay',
                'sogl',
                'name_res_ts',
                'FIO',
                ['attribute' =>'name_user_res',
                    'label' => "Погоджено",
                    'format' => 'raw',
                    'encodeLabel' => false
                ],
                'cel',
                'MODEL',
                'GOS_NOM',
                'marshrut',
                'name_char',
                'name_gsm_o',
                'note',
                'note_res',
                'marshrut_km',

            ],
        ]);?>


    </div>

<?php
