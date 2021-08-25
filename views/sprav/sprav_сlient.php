<?php


use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

use yii\grid\GridView;
use yii\grid\ActionColumn;
use yii\grid\CheckboxColumn;
use yii\grid\SerialColumn;
//,'id_town'=>$model['id_town']

$this->title = 'Довідник споживачів';
$this->params['breadcrumbs'][] = $this->title;
$zag = 'Всього знайдено: '.$q;
?>
<?//= Html::a('Добавити', ['createclient'], ['class' => 'btn btn-success']) ?>
<span> &nbsp; &nbsp; </span>

<?= Html::a(' Пошук', ['find_cl'], ['class' => 'btn btn-info glyphicon glyphicon-search']) ?>
<div class="site-spr">
    <h3><?= Html::encode($this->title) ?></h3>
    <p><?= Html::encode($zag) ?></p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'options' => [ 'style' => 'table-layout:auto;' ],

        'summary' => false,
        'emptyText' => 'Нічого не знайдено',
        'columns' => [
            [
                /**
                 * Указываем класс колонки
                 */
                'class' => \yii\grid\ActionColumn::class,
                'buttons'=>[
                    'delete'=>function ($url, $model) {
                        $customurl=Yii::$app->getUrlManager()->createUrl(['/sprav/delete','id'=>$model['id'],'mod'=>'sprklient']); //$model->id для AR
                        return \yii\helpers\Html::a( '<span class="glyphicon glyphicon-remove-circle"></span>', $customurl,
                            ['title' => Yii::t('yii', 'Видалити'),'data' => [
                                'confirm' => 'Ви впевнені, що хочете видалити цей запис ?',
                            ], 'data-pjax' => '0']);
                    },

                    'update'=>function ($url, $model) {
                        $customurl=Yii::$app->getUrlManager()->createUrl(['/sprav/update','id'=>$model['id'],
                            'mod'=>'sprklient']); //$model->id для AR
                        return \yii\helpers\Html::a( '<span class="glyphicon glyphicon-pencil"></span>', $customurl,
                            ['title' => Yii::t('yii', 'Редагувати'), 'data-pjax' => '0']);
                    }
                ],
                /**
                 * Определяем набор кнопочек. По умолчанию {view} {update} {delete}
                 */
                'template' => '{update} {delete}',
            ],

            [
                'format' => 'raw',
                'header' => 'Введення <br /> показань',
                'value' => function($model) {
                        return \yii\helpers\Html::a( '<span class="glyphicon glyphicon-book"></span>', ['site/area'],[
                            'data' => [
                                'method' => 'get',
                                'params' => [
                                    'id' => $model->id_client,
                                ]]],
                            ['title' => Yii::t('yii', 'Ввести показання'), 'data-pjax' => '0']
                        );

                }
            ],
            [
                'format' => 'raw',
                'header' => 'Обладн.',
                'value' => function($model) {
                    return \yii\helpers\Html::a( '<span class="glyphicon glyphicon-cog"></span>', ['site/equipment'],[
                        'data' => [
                            'method' => 'get',
                            'params' => [
                                'id' => $model->id_client,
                            ]]],
                        ['title' => Yii::t('yii', 'Обладнання'), 'data-pjax' => '0']
                    );

                }
            ],

            ['class' => 'yii\grid\SerialColumn'],
             'id_client',
            ['attribute' =>'lic_sch',
                'options' => ['style' => 'width: 150px; max-width: 150px;'],
                'contentOptions' => ['style' => 'width: 150px; max-width:150px;'],

            ],
            ['attribute' =>'edrpou',
                'options' => ['style' => 'width: 150px; max-width: 150px;'],
                'contentOptions' => ['style' => 'width: 150px; max-width:150px;'],

            ],
            ['attribute' =>'name_s',
                'options' => ['style' => 'width: 150px; max-width: 150px;'],
                'contentOptions' => ['style' => 'width: 150px; max-width:150px;'],

            ],
            ['attribute' =>'name_f',
                'headerOptions' => ['width' => '350px;'],

            ],
            'num_cnt',
            'date_cnt',
            ['attribute' =>'adr_old',
                'contentOptions' => ['style' => 'width: 230px; max-width:230px;'],

            ],
            ['attribute' =>'addr',
                'contentOptions' =>function ($model, $key, $index, $column){
                    return ['class' => 'adr_potreb'];
                },
            ],
            ['attribute' =>'tel',
                'value' => function ($model){
                    $q = trim($model->tel);

                    $tels = explode(',',$q);
                    $s = '';
                    $i = 0;
                    foreach ($tels as $t) {
                        $i++;
                        $q = only_digit($t);

                        if (strlen($q) == 9) $q = '0' . $q;
                        $q = tel_normal($q);
                        //debug($q);
                        if($i>1)
                            $s.=','.chr(13).$q;
                        else
                            $s=$q;

                    }
                    return $s;
                },
                'contentOptions' => ['style' => 'width: 130px; max-width:130px;'],
                'format' => 'raw'
            ],
            'tel_work',
            'email',
            ['attribute' =>'flag_budjet',
                //'format' => ['decimal', 0],
                'value' => function ($model){
                    if($model->flag_budjet == 0)
                        return 'ні';
                    else
                        return 'так';

                },
            ],
            'dt_indicat',
                        

        ],
    ]); ?>


    
</div>



