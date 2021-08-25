<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

$this->title = 'Фотофіксація лічильників';
//$this->layout->title='Звіти [auto]';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class = 'test col-xs-3' >
    <div class="info">
        <p><strong></strong> Фотофіксація лічильників</p>
    </div>
    <?php echo '<br>' ?>
    <?php echo '<br>' ?>




    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>


<!--    --><?//= Html::button('Дублі заявок', ArrayHelper::merge(['value'=>Url::to(['autodoublez'])], ['additionalOptions'])); ?>
    <?= Html::a('Перегляд фото', ['photo_counter_view'], ['class' => 'btn btn-primary']) ?>
    <?php echo '<br>' ?>
    <?php echo '<br>' ?>
    <?= Html::a('Формування завдання для контролера', ['imp_photo_data'], ['class' => 'btn btn-primary']) ?>
    <?php echo '<br>' ?>
    <?php echo '<br>' ?>
<!--    --><?//= Html::a('Завантаження фото з телефону', ['upload2server'], ['class' => 'btn btn-primary']) ?>

    <?php ActiveForm::end() ?>
</div>