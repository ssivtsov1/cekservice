<script>
    window.addEventListener('load', function () {
        $('.form-group').css('margin-bottom','7px');
    });
</script>
<?php

// Ввод основных данных для поиска данных фото счетчиков

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

    $this->title = 'Пошук фото лічильників';
    $arr1=['','Дата','Лічильник','ТП','Адреса','Подія','Всі фільтри'];

?>

<div class="site-login">
    <h3><?= Html::encode($this->title) ?></h3>
    <div class="row">

        <div>
            <?php $form = ActiveForm::begin(['id' => 'data_fotofix',
                'options' => [
                    'class' => 'form-horizontal col-lg-6',
                    'enctype' => 'multipart/form-data'

                ]]); ?>

            <?= $form->field($model, 'res')->dropDownList(
            ArrayHelper::map(app\models\spr_res1::findbysql(
            'select 0 as id ,"" as names union
                    select id,names
                     from spr_res ')->all(), 'id', 'names')) ?>

                <?= $form->field($model, 'fio')->textInput() ?>
                <?= $form->field($model, 'lic')->textInput() ?>
                <?= $form->field($model, 'sapid')->textInput() ?>
                <?= $form->field($model, 'eic')->textInput() ?>
                <?= $form->field($model, 'tp')->textInput() ?>
                <?= $form->field($model, 'counter')->textInput() ?>
                <?= $form->field($model, 'sn')->textInput() ?>
            <?= $form->field($model, 'date1')->
            widget(\yii\jui\DatePicker::classname(), [
                'language' => 'uk'
            ]) ?>
            <?= $form->field($model, 'date2')->
            widget(\yii\jui\DatePicker::classname(), [
                'language' => 'uk'
            ]) ?>

            <p class="text-warning adr_modal">Введіть адресу споживача (на українській мові):</p>

            <?= $form->field($model, 'town')->textInput(
                ['autocomplete' => 'off','maxlength' => true,'onkeyup' =>
                    '$.get("' . Url::to('/cekservice/web/sprav/get_search_town1?name=') .
                    '"+$(this).val(),
                   function(data) {
                         $("#data_fotofix-id_t").empty();
                         //$("#data_fotofix-id_t").show();
                         
                        $(".field-data_fotofix-id_t").show();
                        $("#data_fotofix-id_t").show();
                        
                         for(var ii = -1; ii<data.cur.length; ii++) {
                         if(ii==-1) {var q1=" ";var q2=" ";var n = 20000;
                            $("#data_fotofix-id_t").append("<option onClick="+String.fromCharCode(34)+"sel_town($(this).text(),"+n+");"
                            +String.fromCharCode(34)+" value="+n+">"+q1+"  "+q2+
                            "</option>");
                         }
                         else {
                         var q1 = data.cur[ii].town;
                         var q2 = "";
                         var n = data.cur[ii].id;
//                         alert(q1);
//                         alert(n);
                        // if(q1==null && ii<>0) continue;
//                         var q1 = q.substr(6);
//                         var n = q.substr(0,6);
                            
                        // alert("<option value="+n+">"+q1+q2+"</option>");
                        
                          $("#data_fotofix-id_t").append("<option onClick="+String.fromCharCode(34)+"sel_town($(this).text(),"+n+");"
                         +String.fromCharCode(34)+" value="+n+">"+q1+"  "+q2+
                         "</option>");
                         
                         $("#data_fotofix-id_t").attr("size", ii+2);
                         $("#data_fotofix-id_t").show();
                         $(".data_fotofix-client-id_t").show();
                         
                        }} 
                        if(data.cur.length==0) $("#data_fotofix-id_t").hide();
                  });'
                ]) ?>

            <?=$form->field($model, 'id_t')->
            dropDownList(['maxlength' => true,"onchange"=>"sel_town1(this,event)"]) ?>

            <?= $form->field($model, 'street')->textInput(
                ['autocomplete' => 'off','maxlength' => true,'onkeyup' => '$.get("' . Url::to('/cekservice/web/sprav/get_search_street1?name=') .
                    '"+$(this).val()+"&str="+$("#data_fotofix-town").val(),
                   function(data) {
                         $("#data_fotofix-id_street").empty();
                         for(var ii = 0; ii<data.cur.length; ii++) {
                         var q1 = data.cur[ii].street;
                         var n = data.cur[ii].id;
                         var q2 = $("#client-town").val();
                         //alert(q2);
//                         alert(n);
                         if(q1==null) continue;
                            
                         $("#data_fotofix-id_street").append("<option onClick="+String.fromCharCode(34)+
                         "sel_street($(this).text(),"+n+");"
                         +String.fromCharCode(34)+" value="+n+">"+q1+"</option>");
                         
//                         alert("<option onClick="+String.fromCharCode(34)+
//                         "sel_street($(this).text(),"+n+");"
//                         +String.fromCharCode(34)+" value="+n+">"+q1+"</option>");
                         
                         
                         $("#data_fotofix-id_street").attr("size", ii+2);
                         $("#data_fotofix-id_street").show();
                         $(".field-data_fotofix-id_street").show();
                        } 
                        if(data.cur.length==0) $("#data_fotofix-id_street").hide();
                  });'
                ]) ?>

            <?=$form->field($model, 'id_street')->
            dropDownList([]) ?>

            <?= $form->field($model, 'house') ?>

<!--            --><?//= $form->field($model, 'event')->dropDownList(
//                ArrayHelper::map(app\models\spr_sob::findbysql(
//                    'select 0 as id ,"" as names union
//                    select id,names
//                     from spr_sob ')->all(), 'id', 'names')) ?>

            <?=$form->field($model, 'event')->
            dropDownList(ArrayHelper::map(
                app\models\spr_sob::findbysql('Select  id,names from spr_sob')
                    ->all(), 'id', 'names'),
                [
                    'prompt' => 'Виберіть подію',
                    'onchange' => '$.get("' . Url::to('/cekservice/web/site/gettypephoto?id=') .
                        '"+$(this).val() ,
                    function(data) {
                         
                         $("#data_fotofix-type_image").empty();
                         for(var ii = 0; ii<data.tfoto.length; ii++) {
                         var q = data.tfoto[ii].names;
//                         alert(q);
                         if(q==null) continue;
                         var q1 = q.substr(2);
                         var n = q.substr(0,2);
                         $("#data_fotofix-type_image").append("<option value="+n+
                         " style="+String.fromCharCode(34)+"font-size: 10px;"+
                         String.fromCharCode(34)+">"+q1+"</option>");
                         }
                  });
                  ',
                ]
            ) ?>


            <?= $form->field($model, 'type_image')->dropDownList(
                ArrayHelper::map(app\models\spr_foto::findbysql(
                    'select 0 as id ,"" as names union
                    select id,names
                     from spr_foto ')->all(), 'id', 'names')) ?>

            <?= $form->field($model, 'other_items')-> textInput() -> dropDownList (
                    $arr1,[ 'onchange' => 'select_filter($(this).val());'] )?>

            <div class="form-group">
                <?= Html::submitButton('OK', ['class' => 'btn btn-primary']); ?>
                <?= Html::a('Формування завдання для контролера', ['imp_photo_data'], ['class' => 'btn btn-primary']) ?>
            </div>
            <?php
            ActiveForm::end(); ?>
        </div>
    </div>
</div>


<script>

    function sel_town(elem,id) {
        localStorage.setItem("id_town", id);
        $("#data_fotofix-town").val(elem);
        $(".field-data_fotofix-id_t").hide();
        $("#data_fotofix-id_t").hide();
        $("#data_fotofix-id_street").val('');

    }

    function sel_street(elem,town) {
        //alert(town);
        $("#data_fotofix-street").val(elem);
        $("#data_fotofix-id_town").val(town);
        $(".field-data_fotofix-id_street").hide();
        $("#data_fotofix-id_street").hide();

    }

    function sel_town1(elem,event) {
        alert(event.keyCode);
        if(event.keyCode==13) {
            $("#data_fotofix-town").val(elem);
            $("#data_fotofix-id_t").hide();
        }
    }

    function select_filter(id) {
        if(id==1){
            $('.field-data_fotofix-date1').show();
            $('.field-data_fotofix-date2').show();
            $('.field-data_fotofix-counter').hide();
            $('.field-data_fotofix-sn').hide();
            $('.field-data_fotofix-tp').hide();
            $('.field-data_fotofix-town').hide();
            $('.field-data_fotofix-street').hide();
            $('.field-data_fotofix-house').hide();
            $('.field-data_fotofix-id_t').hide();
            $('.field-data_fotofix-id_street').hide();
            $('.field-data_fotofix-type_image').hide();
            $('.field-data_fotofix-event').hide();
            $('.adr_modal').hide();
        }
        if(id==2){
            $('.field-data_fotofix-counter').show();
            $('.field-data_fotofix-sn').show();
            $('.field-data_fotofix-date1').hide();
            $('.field-data_fotofix-date2').hide();
            $('.field-data_fotofix-tp').hide();
            $('.field-data_fotofix-town').hide();
            $('.field-data_fotofix-street').hide();
            $('.field-data_fotofix-house').hide();
            $('.field-data_fotofix-id_t').hide();
            $('.field-data_fotofix-id_street').hide();
            $('.field-data_fotofix-type_image').hide();
            $('.field-data_fotofix-event').hide();
            $('.adr_modal').hide();
        }
        if(id==3){
            $('.field-data_fotofix-tp').show();
            $('.field-data_fotofix-date1').hide();
            $('.field-data_fotofix-date2').hide();
            $('.field-data_fotofix-counter').hide();
            $('.field-data_fotofix-sn').hide();
            $('.field-data_fotofix-town').hide();
            $('.field-data_fotofix-street').hide();
            $('.field-data_fotofix-house').hide();
            $('.field-data_fotofix-id_t').hide();
            $('.field-data_fotofix-id_street').hide();
            $('.field-data_fotofix-type_image').hide();
            $('.field-data_fotofix-event').hide();
            $('.adr_modal').hide();
        }
        if(id==4){
            $('.field-data_fotofix-town').show();
            $('.field-data_fotofix-street').show();
            $('.field-data_fotofix-house').show();
            $('.field-data_fotofix-id_t').show();
            $('.field-data_fotofix-id_street').show();
            $('.adr_modal').show();
            $('.field-data_fotofix-date1').hide();
            $('.field-data_fotofix-date2').hide();
            $('.field-data_fotofix-counter').hide();
            $('.field-data_fotofix-sn').hide();
            $('.field-data_fotofix-tp').hide();
            $('.field-data_fotofix-type_image').hide();
            $('.field-data_fotofix-event').hide();
        }
        if(id==5){
            $('.field-data_fotofix-type_image').show();
            $('.field-data_fotofix-event').show();
            $('.field-data_fotofix-date1').hide();
            $('.field-data_fotofix-date2').hide();
            $('.field-data_fotofix-tp').hide();
            $('.field-data_fotofix-town').hide();
            $('.field-data_fotofix-street').hide();
            $('.field-data_fotofix-house').hide();
            $('.field-data_fotofix-id_t').hide();
            $('.field-data_fotofix-id_street').hide();
            $('.field-data_fotofix-counter').hide();
            $('.field-data_fotofix-sn').hide();
            $('.adr_modal').hide();
        }
        if(id==6){
            $('.field-data_fotofix-type_image').show();
            $('.field-data_fotofix-event').show();
            $('.field-data_fotofix-date1').show();
            $('.field-data_fotofix-date2').show();
            $('.field-data_fotofix-tp').show();
            $('.field-data_fotofix-town').show();
            $('.field-data_fotofix-street').show();
            $('.field-data_fotofix-house').show();
            $('.field-data_fotofix-id_t').show();
            $('.field-data_fotofix-id_street').show();
            $('.field-data_fotofix-counter').show();
            $('.field-data_fotofix-sn').show();
            $('.adr_modal').show();
        }
        if(id==0){
            $('.field-data_fotofix-type_image').hide();
            $('.field-data_fotofix-event').hide();
            $('.field-data_fotofix-date1').hide();
            $('.field-data_fotofix-date2').hide();
            $('.field-data_fotofix-tp').hide();
            $('.field-data_fotofix-town').hide();
            $('.field-data_fotofix-street').hide();
            $('.field-data_fotofix-house').hide();
            $('.field-data_fotofix-id_t').hide();
            $('.field-data_fotofix-id_street').hide();
            $('.field-data_fotofix-counter').hide();
            $('.field-data_fotofix-sn').hide();
            $('.adr_modal').hide();

        }

    }
</script>







