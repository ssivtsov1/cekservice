<?php
//namespace app\models;
use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use app\models\spr_res;
use app\models\status_con;
$arr1 = ['- Виберіть РЕМ','Дніпровські РЕМ  (м. Дніпро)','Жовтоводські РЕМ  (м. Жовті Води та м. Вільногірськ)',
    'Павлоградські РЕМ  (м. Павлоград та с.м.т. Гвардійське)',
'Криворізькі РЕМ  (м. Кривий Ріг та м. Апостолове)'];

//debug($model->id);
//debug($role);
?>

<br>
<?php $form = ActiveForm::begin([
    'options' => ['enctype' => 'multipart/form-data'],
    'enableAjaxValidation' => false,]); ?>

<div class="scrolldown">
    <!-- Иконка fa-chevron-up (Font Awesome) -->
    <i class="fa fa-chevron-down"></i>
    <!--            <i class="glyphicon glyphicon-eject"></i>-->
</div>

<div class="row">
    <div class="col-lg-6" id="docs">
        <? if($mode==0): ?>
            <p class="text-warning-doc">Документи (у форматі pdf, jpg, png):</p>
            <?= $form->field($model, 'doc1')->fileInput(); ?>

            <?= $form->field($model, 'doc2')->fileInput(); ?>

            <?= $form->field($model, 'doc3')->fileInput(); ?>

            <?= $form->field($model, 'doc4')->fileInput(); ?>

              <a href="https://cek.dp.ua/images/document/dogovor/add1_v2.docx">Зразок заяви на приєднання</a>

        <? endif; ?>


    </div>


    <div class="col-lg-4">

        <? if(1==2) {
        Modal::begin([
            'header' => '<h3>Довідка по вибору РЕМ</h3>',
            'toggleButton' => [
                'label' => 'Довідка по вибору РЕМ',
                'tag' => 'button',
                'class' => 'btn btn-success',
            ]
        ]);
        $t = 'с.м.т. Гвардійське - Павлоградські РЕМ';
        $t1 = 'м. Вільногірськ - Жовтоводські РЕМ';
        $t2 = 'м. Апостолово - Криворізькі РЕМ';
        ?>

        <table width="1000px" class="table table-bordered table-hover table-condensed ">
            <th width="1000px"></th>

            <tr>
                <td><?= $t ?></td>
            </tr>
            <tr>
                <td><?= $t1 ?></td>
            </tr>
            <tr>
                <td><?= $t2 ?></td>
            </tr>
        </table>
        <?php
            Modal::end(); }
            ?>




        <?= $form->field($model, 'id_res') -> dropDownList ( $arr1 ) ?>
        <?= $form->field($model, 'fio')->textarea() ?>
        <?= $form->field($model, 'adres')->textarea() ?>

        <?= $form->field($model, 'tel',['inputTemplate' => '<div class="input-group"><span class="input-group-addon">'
            . '<span class="glyphicon glyphicon-phone"></span></span>{input}</div>'])->textInput(
            ['maxlength' => true,'onBlur' => 'norm_tel($(this).val())']) ?>

        <?= $form->field($model, 'email',
            ['inputTemplate' => '<div class="input-group"><span class="input-group-addon">'
                . '<span class="glyphicon glyphicon-envelope"></span></span>{input}</div>'])->textInput() ?>


        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'ОК' : 'OK', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>

            <?php ActiveForm::end(); ?>
        </div>
    </div>


