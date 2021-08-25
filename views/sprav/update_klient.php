<?php
//namespace app\models;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use app\models\spr_res;
use app\models\spr_client_adr;

//$adr = Spr_client_adr::find()->where('id_adr=:id', [':id' => $model->id_adr])->one();
//$model->id_street=$adr->id_town;
?>

<div class="user-form">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data'],
        'enableAjaxValidation' => false,]); ?>


    <?= $form->field($model, 'lic_sch') ?>
    <?= $form->field($model, 'edrpou') ?>
    <?= $form->field($model, 'name_s')->textarea(['rows' => 1, 'cols' => 25]) ?>
    <?= $form->field($model, 'name_f')->textarea(['rows' => 2, 'cols' => 25]) ?>
    <?= $form->field($model, 'add_name')->textarea(['rows' => 2, 'cols' => 25]) ?>
    <?= $form->field($model, 'adr_old')->textarea(['rows' => 2, 'cols' => 25,'disabled' => true]) ?>

    <p class="text-warning">Адреса споживача:</p>

    <?= $form->field($model, 'town')->textInput(
        ['autocomplete' => 'off','maxlength' => true,'onkeyup' => '$.get("' . Url::to('/abnlegal/web/sprav/get_search_town?name=') .
            '"+$(this).val(),
                   function(data) {
                         $("#client-id_t").empty();
                         
                        
                         for(var ii = -1; ii<data.cur.length; ii++) {
                         if(ii==-1) {var q1=" ";var q2=" ";var n = 20000;
                            $("#client-id_t").append("<option onClick="+String.fromCharCode(34)+"sel_town($(this).text(),"+n+");"
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
                         $("#client-id_t").append("<option onClick="+String.fromCharCode(34)+"sel_town($(this).text(),"+n+");"
                         +String.fromCharCode(34)+" value="+n+">"+q1+",  "+q2+
                         "</option>");
                         else
                         $("#client-id_t").append("<option onClick="+String.fromCharCode(34)+"sel_town($(this).text(),"+n+");"
                         +String.fromCharCode(34)+" value="+n+">"+q1+"  "+q2+
                         "</option>");
                         
                         //$("#client-id_t").append("<option value="+n+">"+"<span>"+q1+"</span>+"<span>"+q2+"</span></option>");
                         $("#client-id_t").attr("size", ii+2);
                         //$("#client-id_t").focus();
                         $("#client-id_t").show();
                         $(".field-client-id_t").show();
                         
                        }} 
                        if(data.cur.length==0) $("#client-id_t").hide();
                  });'
        ]) ?>

    <?=$form->field($model, 'id_t')->
    dropDownList(['maxlength' => true,"onchange"=>"sel_town1(this,event)"]) ?>

    <?= $form->field($model, 'street')->textInput(
        ['autocomplete' => 'off','maxlength' => true,'onkeyup' => '$.get("' . Url::to('/abnlegal/web/sprav/get_search_street?name=') .
            '"+$(this).val()+"&str="+$("#client-town").val(),
                   function(data) {
                         $("#client-id_street").empty();
                         for(var ii = 0; ii<data.cur.length; ii++) {
                         var q1 = data.cur[ii].street;
                         var n = data.cur[ii].id;
                         var q2 = $("#client-town").val();
                         //alert(q2);
//                         alert(n);
                         if(q1==null) continue;
                            
                         $("#client-id_street").append("<option onClick="+String.fromCharCode(34)+
                         "sel_street($(this).text(),"+n+");"
                         +String.fromCharCode(34)+" value="+n+">"+q1+"</option>");
                         
//                         alert("<option onClick="+String.fromCharCode(34)+
//                         "sel_street($(this).text(),"+n+");"
//                         +String.fromCharCode(34)+" value="+n+">"+q1+"</option>");
                         
                         
                         $("#client-id_street").attr("size", ii+2);
                         $("#client-id_street").show();
                         $(".field-client-id_street").show();
                        } 
                        if(data.cur.length==0) $("#client-id_street").hide();
                  });'
        ]) ?>

    <?=$form->field($model, 'id_street')->
    dropDownList([]) ?>

    <?= $form->field($model, 'house') ?>
    <?= $form->field($model, 'korp') ?>
    <?= $form->field($model, 'flat') ?>


    <?= $form->field($model, 'num_cnt') ?>

    <?= $form->field($model, 'date_cnt')->
    widget(\yii\jui\DatePicker::classname(), [
        'language' => 'uk'
    ]) ?>
    <?= $form->field($model, 'tel') ?>
    <?= $form->field($model, 'email') ?>
    <?= $form->field($model, 'id_town')->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'flag_budjet')->checkbox([
        'onchange' => 'showfields(this.checked);',
        'label' => 'Бюджет',
        'labelOptions' => [
            'style' => 'padding-left:10px;'
        ],
        'disabled' => false
    ]); ?>
    <?= $form->field($model, 'dt_indicat') ?>
    <?= $form->field($model, 'dt_start') ?>
    
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'ОК' : 'OK', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script>


    function sel_town(elem,id) {
        localStorage.setItem("id_town", id);
        $("#client-town").val(elem);
        $(".field-client-id_t").hide();
        $("#client-id_t").hide();
        $("#client-street").val('');

    }

    function sel_street(elem,town) {
        //alert(town);
        $("#client-street").val(elem);
        $("#client-id_town").val(town);
        $(".field-client-id_street").hide();
        $("#client-id_street").hide();

    }

    function sel_town1(elem,event) {
        alert(event.keyCode);
        if(event.keyCode==13) {
            $("#client-town").val(elem);
            $("#client-id_t").hide();
        }
    }
</script>
