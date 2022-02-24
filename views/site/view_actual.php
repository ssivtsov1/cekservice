<?php


use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use yii\grid\CheckboxColumn;
use yii\grid\SerialColumn;
//debug($dataProvider->getModels());
$this->title = 'Дані по актуалізації';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="site-spr10">

    <h3><?= Html::encode($this->title) ?></h3>
    <?
    // Кнопка выхода из сеанса авторизации
    echo Html::a('Вийти', ['site/logout'],
    ['class' => 'btn btn-info excel_btn',
    'data' => [
    'method' => 'post',
    ]]);
    ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'summary' => false,
        'filterModel' => $searchModel,
        'columns' => [

            ['class' => 'yii\grid\SerialColumn'],
            [
                /**
                 * Указываем класс колонки
                 */
                'class' => \yii\grid\ActionColumn::class,
                'buttons'=>[

                    'update'=>function ($url, $model) {
                        $customurl=Yii::$app->getUrlManager()->createUrl(['/site/actual_edit','id'=>$model['id'],'mod'=>'actual']); //$model->id для AR
                        return \yii\helpers\Html::a( '<span class="glyphicon glyphicon-pencil"></span>', $customurl,
                            ['title' => Yii::t('yii', 'Редагувати'), 'data-pjax' => '0']);
                    }
                ],
                /**
                 * Определяем набор кнопочек. По умолчанию {view} {update} {delete}
                 */
                'template' => '{update}',
            ],
            'nazv',
            'fdate',
            'fio',
            'adres',
            'tel',
            'email',
            'nazv_status',
        ],
    ]); ?>

</div>


