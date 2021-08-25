<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Введіть параметри пошуку';
//$model->sel = '1';
?>

<div class="site-login">

    <h4><?= Html::encode($this->title) ?></h4>

    <div class="row">
        <div class="col-lg-3">
            <?php $form = ActiveForm::begin(['id' => 'inputdatafind_cl',
                'options' => [
                    'class' => 'form-horizontal col-lg-25',
                    'enctype' => 'multipart/form-data',
                    'fieldConfig' => ['errorOptions' => ['encode' => false, 'class' => 'help-block']

                    ]]]); ?>

            <?= $form->field($model, 'id_client')->textInput() ?>
            <?= $form->field($model, 'short_cl')->textInput() ?>
            <?= $form->field($model, 'name_cl')->textInput() ?>
            <?= $form->field($model, 'lic_sch')->textInput() ?>
            <?= $form->field($model, 'date_cnt')->widget(\yii\jui\DatePicker::classname(), [
                'language' => 'uk',
            ]) ?>
            <?= $form->field($model, 'num_cnt')->textInput() ?>


        </div>
        <div class="col-lg-3">
            <?= $form->field($model, 'zpower')->
            dropDownList([1 => '=',2 => '>',3 => '>=',4 => '<',5 => '<=',6 => '<>'],['prompt'=>'']) ?>
            <?= $form->field($model, 'power')->textInput() ?>
            <?= $form->field($model, 'zeerm')->
            dropDownList([1 => '=',2 => '>',3 => '>=',4 => '<',5 => '<=',6 => '<>'],['prompt'=>'']) ?>
            <?= $form->field($model, 'eerm')->textInput() ?>
            <?= $form->field($model, 'zhour_month')->
            dropDownList([1 => '=',2 => '>',3 => '>=',4 => '<',5 => '<=',6 => '<>'],['prompt'=>'']) ?>
            <?= $form->field($model, 'hour_month')->textInput() ?>
            <?= $form->field($model, 'zvalue_act')->
            dropDownList([1 => '=',2 => '>',3 => '>=',4 => '<',5 => '<=',6 => '<>'],['prompt'=>'']) ?>
            <?= $form->field($model, 'value_act')->textInput() ?>
            <?= $form->field($model, 'zvalue_react')->
            dropDownList([1 => '=',2 => '>',3 => '>=',4 => '<',5 => '<=',6 => '<>'],['prompt'=>'']) ?>
            <?= $form->field($model, 'value_react')->textInput() ?>
            <?= $form->field($model, 'zvalue_gen')->
            dropDownList([1 => '=',2 => '>',3 => '>=',4 => '<',5 => '<=',6 => '<>'],['prompt'=>'']) ?>
            <?= $form->field($model, 'value_gen')->textInput() ?>

        </div>
        <div class="col-lg-3">
            <?= $form->field($model, 'adr_old')->textInput() ?>
            <?= $form->field($model, 'tel')->textInput() ?>
            <?= $form->field($model, 'zsub')->
            dropDownList([1 => '=',2 => '>',3 => '>=',4 => '<',5 => '<=',6 => '<>'],['prompt'=>'']) ?>
            <?= $form->field($model, 'sub')->textInput() ?>
            <?= $form->field($model, 'ztu')->
            dropDownList([1 => '=',2 => '>',3 => '>=',4 => '<',5 => '<=',6 => '<>'],['prompt'=>'']) ?>
            <?= $form->field($model, 'tu')->textInput() ?>
            <?= $form->field($model, 'zkoef_tr')->
            dropDownList([1 => '=',2 => '>',3 => '>=',4 => '<',5 => '<=',6 => '<>'],['prompt'=>'']) ?>
            <?= $form->field($model, 'koef_tr')->textInput() ?>
            <?= $form->field($model, 'eis')->textInput() ?>
            <?= $form->field($model, 're')->checkbox(); ?>

            <div class="form-group">
                <?= Html::submitButton('OK', ['class' => 'btn btn-primary']); ?>
            </div>

            <?php

            ActiveForm::end(); ?>
        </div>
    </div>
</div>

<script>
    function f_cause(p){
        if(p==2)
            $(".field-input_refusal-cause").show();
        else
            $(".field-input_refusal-cause").hide();
    }


    function rmenu(p){
        var y,i,c,nc='',phrase = '';

        y = p.length;
        for(i=0;i<y;i++)
        {
            c = p.substr(i,1);
            switch(c) {
                case 'q':  nc = 'й';
                    break;
                case 'w':  nc = 'ц';
                    break;
                case 'e':  nc = 'у';
                    break;
                case 'r':  nc = 'к';
                    break;
                case 't':  nc = 'е';
                    break;

                case 'y':  nc = 'н';
                    break;
                case 'u':  nc = 'г';
                    break;
                case 'i':  nc = 'ш';
                    break;
                case 'o':  nc = 'щ';
                    break;
                case 'p':  nc = 'з';
                    break;

                case '[':  nc = 'х';
                    break;
                case ']':  nc = 'ъ';
                    break;
                case 'a':  nc = 'ф';
                    break;
                case 's':  nc = 'ы';
                    break;
                case 'd':  nc = 'в';
                    break;

                case 'f':  nc = 'а';
                    break;
                case 'g':  nc = 'п';
                    break;
                case 'h':  nc = 'р';
                    break;
                case 'j':  nc = 'о';
                    break;
                case 'k':  nc = 'л';
                    break;

                case 'l':  nc = 'д';
                    break;
                case ';':  nc = 'ж';
                    break;
                case "'":  nc = 'э';
                    break;
                case 'z':  nc = 'я';
                    break;
                case 'x':  nc = 'ч';
                    break;

                case 'c':  nc = 'с';
                    break;
                case 'v':  nc = 'м';
                    break;
                case "b":  nc = 'и';
                    break;
                case 'n':  nc = 'т';
                    break;
                case 'm':  nc = 'ь';
                    break;
                case ',':  nc = 'б';
                    break;
                case '.':  nc = 'ю';
                    break;

                default:
                    nc = '';
                    break;
            }
            phrase = phrase + nc;
        }

        //alert(this.val);
//        $(this).val()
        //return phrase;
    }


</script>






