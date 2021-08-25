<?php


use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use yii\grid\CheckboxColumn;
use yii\grid\SerialColumn;
//debug($dataProvider->getModels());
$this->title = 'Показники лічильників';
$this->params['breadcrumbs'][] = $this->title;
$session = Yii::$app->session;
$session->open();
$area=$session->get('url_area');
$par=$area['id'];
//debug($dataProvider->getModels());
//debug($dataProvider);

?>
<div class="site-spr2">
    <?= Html::a('&#11014;'.' Площадки',["area?&id=$par"], ['class' => 'btn btn-success']); ?>

    <h3><?= Html::encode($this->title) ?></h3>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'summary' => false,
        'columns' => [
           [
            'class' => \yii\grid\ActionColumn::class,
            'buttons'=>[
                'update'=>function ($url, $model) {
                    $customurl=Yii::$app->getUrlManager()->createUrl(['/site/update_indic',
                        'code_eqp'=>$model['code_eqp'],'id_client'=>$model['id_client'],
                        'num_eqp'=>$model['num_eqp'],'type'=>$model['type'],
                        'name'=>$model['name'],'code_tu'=>$model['code_tu'],
                        'vid_e'=>$model['vid_e'],'vid'=>$model['vid'],
                        'type_eqp'=>$model['type_eqp'],
                        'koef_tr'=>$model['ktr'],
                        're'=>$model['re'],
                        'gen'=>$model['gen'],
                        'code_area'=>$model['code_area']]);
                    return \yii\helpers\Html::a( '<span class="glyphicon glyphicon-pencil"></span>', $customurl,
                        ['title' => Yii::t('yii', 'Редагувати'), 'data-pjax' => '0']);
                }
            ],
             'template' => '{update}',
            ],

            ['class' => 'yii\grid\SerialColumn'],
           
            'id_client',
            'name',
            'type',
            'carry',
            'num_eqp',
            'zones',
            'koef_tr',
            'vid',
            'value_prev',
            'value',
            'value_diff'

        ],
    ]); ?>

</div>


