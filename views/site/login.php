<?php


use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;

$this->title = 'Вхід в програму:';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h2><?= Html::encode($this->title) ?></h2>

    <p>Будь ласка заповніть поля для входу:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

<!--            --><?//=$form->field($model, 'res')->dropDownList([
//    '1' => 'Гвардійский',
//    '2' => 'Дніпровский',
//    '4' => 'Криворізький',
//    '5' => 'Павлоградський',
//    '6' => 'Вільногірський',
//    '7' => 'Жовтоводський',
//    '8' => 'Інгулецький',
//    '9' => 'Апостолівський',


//]); ?>

            <?= $form->field($model, 'username') ?>

            <?= $form->field($model, 'password')->passwordInput() ?>

<!--        --><?//= $form->field($model, 'rememberMe')->checkbox() ?>

<!--            <div style="color:#999;margin:1em 0">-->
<!--                If you forgot your password you can --><?//= Html::a('reset it', ['site/request-password-reset']) ?><!--.-->
<!--            </div>-->

            <div class="form-group">
                <?= Html::submitButton('Увійти', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

<?php

function select_res() {
    $r = "select id,concat(town,'  (',nazv,')') as nazv from spr_res where id not in(11,12,13)";
    return $r;
}

?>