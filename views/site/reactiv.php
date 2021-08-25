<?php


use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use yii\grid\CheckboxColumn;
use yii\grid\SerialColumn;
use app\models\reactiv;

$this->title = 'Результат розрахунку [ '.$nazv_cl.' ]';;
$this->params['breadcrumbs'][] = $this->title;
$session = Yii::$app->session;
$session->open();
$area=$session->get('url_area');
//$par=$area['id'];
$par=$id;
?>
<div class="site-spr">
    <?= Html::a('&#11014;'.' Площадки',["area?&id=$par"], ['class' => 'btn btn-success']); ?>
    <h3><?= Html::encode($this->title) ?></h3>
    <?php if ($sub==0): ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'summary' => false,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
           
            'code_tu',
            'name',
            'name_area',
            'name_tp',
            'pwr',
            //'koef_tr',
            'eerm',
            'hour_month',
            'potr_act',
            'potr_react',
            'potr_gen',
            'tg_r',
            'tg_rp',
            'ps',
            'pg',
            'p1',
            'p2',
            'p3'
        ],
    ]);

    $itog = $dataProvider->getModels();
   // debug($itog);
   // $itog[0]['p3'];
    $s=0;
    /*
    foreach ($itog as $v){
       // if($v['id_client']==$id)
            $s+= $v['p3'];
    }
    */
        foreach ($itog as $v){
            $tab=$v['itog'];
            break;
        }
        $z='select p3 from '.$tab;
        $model1 = reactiv::findbySql($z)->one();
        $s=$model1->p3;
        $z='drop table '.$tab;
        Yii::$app->db->createCommand($z)->execute();
    ?>
    <?php endif; ?>

    <?php if ($sub==1): ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'summary' => false,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'name_kl',
                //'code_tu',
                //'name_cnt',
                'name_area',
                'name_tp',
                'pwr',
                //'koef_tr',
                'eerm',
                //'hour_month',
                [
                    'format' => 'raw',
                    'header' => 'Години <br /> роботи',
                    'value' => function($model) {
                        return $value = $model->hour_month;

                    }
                ],
                //'potr_act',
                [
                    'format' => 'raw',
                    'header' => 'Споживання <br /> актив',
                    'value' => function($model) {
                        return $value = $model->potr_act;

                    }
                ],
                //'potr_react',
                [
                    'format' => 'raw',
                    'header' => 'Споживання <br /> реактив',
                    'value' => function($model) {
                        return $value = $model->potr_react;

                    }
                ],
                //'potr_gen',
                [
                    'format' => 'raw',
                    'header' => 'Споживання <br /> генер.',
                    'value' => function($model) {
                        return $value = $model->potr_gen;

                    }
                ],
                'tg_r',
                'tg_rp',
                'ps',
                'pg',
                'p1',
                'p2',
                'p3'
            ],
        ]);

        $itog = $dataProvider->getModels();
        //debug($itog);
        //$itog[0]['p3'];
        $s=0;
        foreach ($itog as $v){
//            if($v['id_client']==$id)
//                $s+= $v['p3'];
            $tab=$v['itog'];
            break;
        }
        $z='select p3 from '.$tab;
        $model1 = reactiv::findbySql($z)->one();
        $s=$model1->p3;
        $z='drop table '.$tab;
        Yii::$app->db->createCommand($z)->execute();
        ?>
    <?php endif; ?>
    <br>
    <h3><?= Html::encode("Плата за перетоки реактивної електроенергії") ?></h3>
    <table class="table table-bordered table-hover table-condensed">
        <thead>
        <tr>
            <th width="400px">Споживач </th>
            <th width="150px">Плата, грн.</th>
            <th width="150px">ПДВ, грн.</th>
            <th width="150px">Всього, грн.</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td><?= $nazv_cl ?></td>
            <td><?= $s ?></td>
            <td><?= zero_e(round($s*0.2,2)) ?></td>
            <td><?= zero_e($s+round($s*0.2,2)) ?></td>
        </tr>

        </tbody>
    </table>
</div>

