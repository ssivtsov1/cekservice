<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

$this->title = 'Звіти для програми auto';
//$this->layout->title='Звіти [auto]';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class = 'test col-xs-3' >
    <div class="info">
        <p><strong></strong> Звіти для програми auto</p>
    </div>
    <?php echo '<br>' ?>
    <?php echo '<br>' ?>




    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>


<!--    --><?//= Html::button('Дублі заявок', ArrayHelper::merge(['value'=>Url::to(['autodoublez'])], ['additionalOptions'])); ?>
    <?= Html::a('Дублі заявок', ['autodouble_f'], ['class' => 'btn btn-primary']) ?>
    <?php echo '<br>' ?>
    <?php echo '<br>' ?>
    <?= Html::a('Перегляд заявок', ['autoviewz'], ['class' => 'btn btn-primary']) ?>

    <?php ActiveForm::end() ?>
</div>