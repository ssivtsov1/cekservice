<?php
//namespace app\models;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use app\models\spr_res;
use app\models\spr_client_adr;

?>

<div class="col-lg-6">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data'],
        'enableAjaxValidation' => false,]); ?>


    <h3>Пошук мережі ЦЕК</h3>
    <p class="text-warning">Введіть адресу споживача (на українській мові):</p>

    <?= $form->field($model, 'town')->textInput(
        ['autocomplete' => 'off','maxlength' => true,'onkeyup' => '$.get("' . Url::to('/cekservice/web/sprav/get_search_town?name=') .
            '"+$(this).val(),
                   function(data) {
                         $("#spr_client_adr-id_t").empty();
                         //$("#spr_client_adr-id_t").show();
                         
                        $(".field-spr_client_adr-id_t").show();
                        $("#spr_client_adr-id_t").show();
                        
                         for(var ii = -1; ii<data.cur.length; ii++) {
                         if(ii==-1) {var q1=" ";var q2=" ";var n = 20000;
                            $("#spr_client_adr-id_t").append("<option onClick="+String.fromCharCode(34)+"sel_town($(this).text(),"+n+");"
                            +String.fromCharCode(34)+" value="+n+">"+q1+"  "+q2+
                            "</option>");
                         }
                         else {
                         var q1 = data.cur[ii].town;
                         if(data.cur[ii].district!="")
                         var q2 = (data.cur[ii].district)+" р-н";
//                         alert(q2);
                         var n = data.cur[ii].id;
//                         alert(q1);
//                         alert(n);
                        // if(q1==null && ii<>0) continue;
//                         var q1 = q.substr(6);
//                         var n = q.substr(0,6);
                            
                        // alert("<option value="+n+">"+q1+q2+"</option>");
                        
                        if(data.cur[ii].district!="")
                         $("#spr_client_adr-id_t").append("<option onClick="+String.fromCharCode(34)+"sel_town($(this).text(),"+n+");"
                         +String.fromCharCode(34)+" value="+n+">"+q1+",  "+q2+
                         "</option>");
                         else
                         $("#spr_client_adr-id_t").append("<option onClick="+String.fromCharCode(34)+"sel_town($(this).text(),"+n+");"
                         +String.fromCharCode(34)+" value="+n+">"+q1+"  "+q2+
                         "</option>");
                         
                         //$("#spr_client_adr-id_t").append("<option value="+n+">"+"<span>"+q1+"</span>+"<span>"+q2+"</span></option>");
                         $("#spr_client_adr-id_t").attr("size", ii+2);
                         //$("#client-id_t").focus();
                         $("#spr_client_adr-id_t").show();
                         $(".spr_client_adr-client-id_t").show();
                         
                        }} 
                        if(data.cur.length==0) $("#spr_client_adr-id_t").hide();
                  });'
        ]) ?>

    <?=$form->field($model, 'id_t')->
    dropDownList(['maxlength' => true,"onchange"=>"sel_town1(this,event)"]) ?>

    <?= $form->field($model, 'street')->textInput(
        ['autocomplete' => 'off','maxlength' => true,'onkeyup' => '$.get("' . Url::to('/cekservice/web/sprav/get_search_street?name=') .
            '"+$(this).val()+"&str="+$("#spr_client_adr-town").val(),
                   function(data) {
                         $("#spr_client_adr-id_street").empty();
                         for(var ii = 0; ii<data.cur.length; ii++) {
                         var q1 = data.cur[ii].street;
                         var n = data.cur[ii].id;
                         var q2 = $("#client-town").val();
                         //alert(q2);
//                         alert(n);
                         if(q1==null) continue;
                            
                         $("#spr_client_adr-id_street").append("<option onClick="+String.fromCharCode(34)+
                         "sel_street($(this).text(),"+n+");"
                         +String.fromCharCode(34)+" value="+n+">"+q1+"</option>");
                         
//                         alert("<option onClick="+String.fromCharCode(34)+
//                         "sel_street($(this).text(),"+n+");"
//                         +String.fromCharCode(34)+" value="+n+">"+q1+"</option>");
                         
                         
                         $("#spr_client_adr-id_street").attr("size", ii+2);
                         $("#spr_client_adr-id_street").show();
                         $(".field-spr_client_adr-id_street").show();
                        } 
                        if(data.cur.length==0) $("#spr_client_adr-id_street").hide();
                  });'
        ]) ?>

    <?=$form->field($model, 'id_street')->
    dropDownList([]) ?>

    <?= $form->field($model, 'house') ?>
    <?= $form->field($model, 'korp') ?>


    <div class="form-group">
        <?= Html::submitButton('OK', ['class' => 'btn btn-primary']); ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script>
    // $('body').on('focus','#spr_client_adr-town',function(){
    //
    //         // $(".field-spr_client_adr-id_t").show();
    //         // $("#spr_client_adr-id_t").show();
    //
    // });

    function sel_town(elem,id) {
        localStorage.setItem("id_town", id);
        $("#spr_client_adr-town").val(elem);
        $(".field-spr_client_adr-id_t").hide();
        $("#spr_client_adr-id_t").hide();
        $("#spr_client_adr-id_street").val('');

    }

    function sel_street(elem,town) {
        //alert(town);
        $("#spr_client_adr-street").val(elem);
        $("#spr_client_adr-id_town").val(town);
        $(".field-spr_client_adr-id_street").hide();
        $("#spr_client_adr-id_street").hide();

    }

    function sel_town1(elem,event) {
        alert(event.keyCode);
        if(event.keyCode==13) {
            $("#spr_client_adr-town").val(elem);
            $("#spr_client_adr-id_t").hide();
        }
    }
</script>
