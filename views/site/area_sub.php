<script>
    $('body').on('blur','input.pok_act',function(){
        var re = $(this).closest('tr').find('td.re').html();

        if(re==0) {
            var pok_act = $(this).closest('tr').find('input.pok_act').val();
            var koef_tr = $(this).closest('tr').find('td.k_tr').html();

            if (koef_tr > 1) {
                koef_tr = 1;
                var pok_react = pok_act * koef_tr * 0.8;
                var pok_act = pok_act * koef_tr;
            }
            else
                var pok_react = pok_act * 0.8;
            $(this).closest('tr').find('input.pok_react').val(pok_react);
            $(this).closest('tr').find('input.pok_act').val(pok_act);
        }
        if(re==1) {
            var pok_act = $(this).closest('tr').find('input.pok_act').val();
            var koef_tr = $(this).closest('tr').find('td.k_tr').html();

            if (koef_tr > 1)
                var pok_act = pok_act * koef_tr;

           // $(this).closest('tr').find('input.pok_act').val(pok_act);
        }
    });
    // передача показаний через AJAX запрос
    $('body').on('click', '.super-add-pok', function (e) {
        var id = $(this).data('id');
        var code_eqp = $(this).data('code_eqp');
        var type_eqp = $(this).data('type_eqp');
        var code_area = $(this).data('code_area');
        var code_tu = $(this).data('code_tu');
        var pok_act = $(this).closest('tr').find('input.pok_act').val();
        var pok_react = $(this).closest('tr').find('input.pok_react').val();
        var pok_gen = $(this).closest('tr').find('input.pok_gen').val();
        var rnd=parseInt(Math.random()*1000);
        //alert(rnd);
        $(this).addClass('hasFocus');

        // alert(pok_act);
        // alert(pok_react);
        // alert(pok_gen);


        $.ajax({
            url: '/abnlegal/web/site/add_pok',
            // dataType: 'text',
            data: {id: id, code_eqp: code_eqp, type_eqp: type_eqp,
                code_area: code_area,code_tu: code_tu,
                pok_act: pok_act, pok_react: pok_react,pok_gen: pok_gen },
            type: 'GET',
            success: function(res){
                if(!res) alert('Данные не верны!');
            },
            error: function (data) {
                console.log('Error', data);
            },

        });

        setTimeout(function () {
            $('.hasFocus').focus();
        }, 300);


    });
    // Удаление показаний через AJAX запрос
    $('body').on('click', '.super-del-pok', function (e) {
        var yy=confirm("Ви впевнені, що хочете видалити показання?");
        if (yy==false) return;
        var id = $(this).data('id');
        var code_eqp = $(this).data('code_eqp');
        var type_eqp = $(this).data('type_eqp');
        var code_area = $(this).data('code_area');
        var code_tu = $(this).data('code_tu');
        var pok_act = $(this).closest('tr').find('input.pok_act').val();
        var pok_react = $(this).closest('tr').find('input.pok_react').val();
        var pok_gen = $(this).closest('tr').find('input.pok_gen').val();
        $(this).addClass('hasFocus');

        $.ajax({
            url: '/abnlegal/web/site/del_pok',
            // dataType: 'text',
            data: {id: id, code_eqp: code_eqp, type_eqp: type_eqp,
                code_area: code_area,code_tu: code_tu,
                pok_act: pok_act, pok_react: pok_react,pok_gen: pok_gen },
            type: 'GET',
            success: function(res){
                if(!res) alert('Данные не верны!');
            },
            error: function (data) {
                console.log('Error', data);
            },

        });
        $(this).closest('tr').find('input.pok_act').val('');
        $(this).closest('tr').find('input.pok_react').val('');
        $(this).closest('tr').find('input.pok_gen').val('');
        setTimeout(function () {
            $('.hasFocus').focus();
        }, 300);
    });
</script>



<?php


use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use yii\grid\CheckboxColumn;
use yii\grid\SerialColumn;

$this->title = 'Площадки [ '.$nazv_cl.' ]';
$this->params['breadcrumbs'][] = $this->title;
$data=$dataProvider->getModels();
$k=count($data);
//debug($dataProvider);
//debug($dataProvider->getModels());
if($k>7):
?>

<div class="site-spr">
<? else: ?>
<div class="site-spr">
<? endif; ?>
    <h3><?= Html::encode($this->title) ?></h3>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'summary' => false,
        'columns' => [
//           [
//            'class' => \yii\grid\ActionColumn::class,
//            'buttons'=>[
//                'update'=>function ($url, $model) {
//                    $customurl=Yii::$app->getUrlManager()->createUrl(['/site/update_type_energy',
//                        'id'=>$model['code_tu'],'name'=>$model['name'],'id_client'=>$model['id_client']]);
//                    return \yii\helpers\Html::a( '<span class="glyphicon glyphicon-pencil"></span>', $customurl,
//                        ['title' => Yii::t('yii', 'Редагувати'), 'data-pjax' => '0']);
//                }
//            ],
//             'template' => '{update}',
//            ],
//            [
//                'format' => 'raw',
//                'header' => 'Введення <br /> показань',
//                'value' => function($model) {
//                    if(!$model->sub)
//                    return \yii\helpers\Html::a( '<span class="glyphicon glyphicon-book"></span>', ['site/input_value'],[
//                        'data' => [
//                            'method' => 'get',
//                            'params' => [
//                                'id' => $model->id_client,
//                                'code_eqp' => $model->code_cnt,
//                                'type_eqp' => $model->type_eqp,
//                                'code_area' => $model->code_area,
//                            ]]],
//                        ['title' => Yii::t('yii', 'Ввести показання'), 'data-pjax' => '0']
//                    );
//                    else
//                        return;
//
//
//                }
//            ],
//            ['class' => 'yii\grid\SerialColumn'],
            //'level',
            [
                'class' => \yii\grid\ActionColumn::class,
                'buttons'=>[
                    'update'=>function ($url, $model) {
                        $customurl=Yii::$app->getUrlManager()->createUrl(['/site/update_type_energy',
                            'id'=>$model['code_tu'],'name'=>$model['name'],'id_client'=>$model['id_client'],
                            'eerm'=>$model['eerm']]);
                        return \yii\helpers\Html::a( '<span class="glyphicon glyphicon-pencil"></span>', $customurl,
                            ['title' => Yii::t('yii', 'Редагувати'), 'data-pjax' => '0']);
                    }
                ],
                'template' => '{update}',
            ],
            [
                'format' => 'raw',
                'header' => 'L',
                'value' => function($model) {
                    return $value = $model->level;

                }
            ],
            //'code_tu',
            [
                'format' => 'raw',
                'header' => 'Код <br /> точки',
                'value' => function($model) {
                    return $value = $model->code_tu;

                }
            ],
            //'name_area',
            [
                'format' => 'raw',
                'header' => 'Назва <br /> площ.',
                'value' => function($model) {
                    return $value = $model->name_area;

                }
            ],
            [
                'format' => 'raw',
                'header' => 'ТП',
                'value' => function($model) {
                    return $value = $model->name_tp;

                }
            ],
            //'name',
            [
                'format' => 'raw',
                'header' => 'Назва <br /> точки',
                'value' => function($model) {
                    return $value = $model->name;

                }
            ],
            //'power',
            [
                'format' => 'raw',
                'header' => 'P, кВт',
                'value' => function($model) {
                    return $value = $model->power;

                }
            ],
            //'koef_tr',
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

            //'type',
            //'carry',
            'num_eqp',
            //'zones',
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
            //'hour_month',
//            [
//                'format' => 'raw',
//                'header' => 'Години <br /> роботи',
//                'value' => function($model) {
//                    return $value = $model->hour_month;
//
//                }
//            ],
            //'type_energy',
            'sub_cl',
            //'psub_cl',
            [
                'format' => 'raw',
                'header' => 'Предок <br /> субспоживача',
                'value' => function($model) {
                    return $value = $model->psub_cl;

                }
            ],


            [
                'format' => 'raw',
                'header' => 'Попер. показ <br /> [актив]',
                'value' => function($model) {
                    return $value = $model->value_prev_act;

                }
            ],
            [
                'format' => 'raw',
                'header' => 'Попер. показ <br /> [реактив]',
                'value' => function($model) {
                    return $value = $model->value_prev_react;

                }
            ],
            [
                'format' => 'raw',
                'header' => 'Попер. показ <br /> [генер.]',
                'value' => function($model) {
                    return $value = $model->value_prev_gen;

                }
            ],
            [
                'header'=>'Показники <br /> [актив]',
                'format'=>'raw',
                'headerOptions' => ['width' => '90'],
                'value' => function($model, $key, $index, $column){
                    return Html::input(
                        'text', 'Показники [актив]',
                        $value = $model->value_act,
                        [
                            'class' => 'pok_act form-control',
                            'data-pjax'=>false,
                            'style' => 'width:90px; border-radius:1px;padding-left:3px;',

                        ]);
                }
            ],

            [
                'header'=>'Показники <br /> [реактив]',
                'format'=>'raw',
                'headerOptions' => ['width' => '90'],
                'value' => function($model, $key, $index, $column){
                    return Html::input(
                        'text', 'Показники [реактив]',
                        $value = $model->value_react,
                        [
                            'class' => 'pok_react form-control',
                            'data-pjax'=>false,
                            'style' => 'width:90px; border-radius:1px;padding-left:3px;',

                        ]);
                }
            ],
            [
                'header'=>'Показники <br /> [генер.]',
                'format'=>'raw',
                'headerOptions' => ['width' => '90'],
                'value' => function($model, $key, $index, $column){
                    return Html::input(
                        'text', 'Показники [генер.]',
                        $value = $model->value_gen,
                        [
                            'class' => 'pok_gen form-control',
                            'data-pjax'=>false,
                            'style' => 'width:90px; border-radius:1px;padding-left:3px;',

                        ]);

                }
            ],

            [
                'header'=>'Запис',
                'format' => 'raw',
                'value' => function($model, $key, $index, $column) {
                    return Html::a(
                        '<i class="fa"> Записать</i>','#',
//                        Url::to(['site/add_pok', 'id' => $model->id_client,
//                                'code_eqp' => $model->code_eqp,
//                                'type_eqp' => $model->type_eqp,
//                                'code_area' => $model->code_area,
//                                'code_tu' => $model->code_tu,
//                                'pok_act' => 0]),

                        [
                            'data-id' => $model->id_client,
                            'data-code_eqp' => $model->code_cnt,
                            'data-type_eqp' => $model->type_eqp,
                            'data-code_area' => $model->code_area,
                            'data-code_tu' => $model->code_tu,
                            'data-pjax'=>false,
                            //'action'=>Url::to(['site/add_pok1']),
                            'class'=>'btn-sm btn-success super-add-pok',

                        ]


                    );

                }
            ],

            [
                'header'=>'',
                'format' => 'raw',
                'value' => function($model, $key, $index, $column) {
                    return Html::a(
                        '<i class="fa"> </i>','#',
                        [
                            'data-id' => $model->id_client,
                            'data-code_eqp' => $model->code_cnt,
                            'data-type_eqp' => $model->type_eqp,
                            'data-code_area' => $model->code_area,
                            'data-code_tu' => $model->code_tu,
                            'data-pjax'=>false,
                            //'action'=>Url::to(['site/add_pok1']),
                            'class'=>'btn-sm glyphicon glyphicon-remove super-del-pok',

                        ]

                    );

                }
            ],

        ],
    ]);

    echo Html::a('Розрахунок реактиву ', ['site/reactiv'],[
        'data' => [
            'method' => 'get',
            'params' => [
                'id' => $id
            ],],
        'class' => 'btn glyphicon glyphicon-tasks btn-info']);

    ?>

</div>



