<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii \ helpers \ ArrayHelper;
use yii\helpers\Url;
?>


<script>

     window.addEventListener('load', function(){
         $('#data_person-lic').keydown(function (e) {
             if(e.code===13) return false;
         });
         $('#data_person-val1').keydown(function (e) {
             if(e.code===13) alert('1');
         });
    });

</script>

<div class = 'test col-xs-3' >
    <h3>Передача показників лічильника</h3>


    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

    <?= $form->field($model, 'lic')->label('Особовий рахунок') -> textinput ()?>

    <?= $form->field($model, 'init')->textinput ( ['autocomplete' => 'off','maxlength' => true,'onBlur' =>
        '$.get("' . Url::to('/cekservice/web/site/get_zones?lic=') .
        '"+$("#data_person-lic").val()+$(this).val(),
                   function(data) {
                          var z=data.cur[0];
                          var let_q=0;
                          if(z!=0 && data.cur[9] == 1) {
//                          var z1=z;
//                          var z = z.substring(0, 1);
//                          var ss = z1.substring(2);
//                          var pos = ss.indexOf(" ");
//                          var adr = ss.substring(pos);
//                          var cnt = z1.substring(2,pos+2);
                            var cnt = data.cur[1];
                            var adr = data.cur[2];
                           var val1 = data.cur[3];
                           var val21 = data.cur[4];
                           var val22 = data.cur[5];
                           var val31 = data.cur[6];
                           var val32 = data.cur[7];
                           var val33 = data.cur[8];
                          
//                          alert(z);
//                          alert(cnt);
//                          alert(adr);
//                          return;
                   
                        $("#data_person-cnt").val(cnt);
                        $("#data_person-zones").val(z);
                        $("#data_person-valp1").val(val1);
                        $("#data_person-valp21").val(val21);
                        $("#data_person-valp22").val(val22);
                         $("#data_person-valp31").val(val31);
                         $("#data_person-valp32").val(val32);
                         $("#data_person-valp33").val(val33);  
                          
                          }
                          else
                          {
//                                alert(11111);
                                var adr = "";
                                $(".zona_1").css("display", "none");
                                $(".zona_2").css("display", "none");
                                $(".zona_3").css("display", "none");
                                var e =$("span").text();
//                                alert(e);
                                $( ".msg" ).remove();
                                $(".zona_0").css("display", "block");
                                $(".ok_t").hide();
                                let_q=1;
                          }
//                         alert(z);
//                         return;
                        if( let_q==0) {
                          if(z==0)
                          {
                                $(".zona_1").hide();
                                $(".zona_2").hide();
                                $(".zona_3").hide();
                                $(".zona_0").show();
                                $(".field-data_person-tel").hide();
                               
                          }
                         if(z==1)
                          {
                                $(".zona_1").show();
                                $(".zona_2").hide();
                                 $(".zona_3").hide();
                                 $(".zona_0").hide();
                                  $(".zona_adr").show();
                                 $("#data_person-val1").focus();
                                 $(".ok_t").show();
                                 $(".field-data_person-tel").show();
                                 $( ".msg" ).remove();
                                 $( ".field-data_person-init" ).append("<span class="+String.fromCharCode(34)+"msg"+String.fromCharCode(34)+">"+adr+ "</span>");
                       
                                 $("#data_person-val21").val(0);
                                 $("#data_person-val22").val(0);
                                 $("#data_person-val31").val(0);
                                 $("#data_person-val32").val(0);
                                 $("#data_person-val33").val(0);
                          }
                           if(z==2)
                          {
                                $(".zona_1").hide();
                                $(".zona_2").show();
                                 $(".zona_3").hide();
                                 $(".zona_0").hide();
                                 $("#data_person-val21").focus();
                                  $(".ok_t").show();
                                   $(".field-data_person-tel").show();
                                    $( ".msg" ).remove();
                                 $( ".field-data_person-init" ).append("<span class="+String.fromCharCode(34)+"msg"+String.fromCharCode(34)+">"+adr+ "</span>");
                                   
                                 $("#data_person-val1").val(0);
                                 $("#data_person-val31").val(0);
                                 $("#data_person-val32").val(0);
                                 $("#data_person-val33").val(0);
                                   
                          }
                           if(z==3)
                          {
                                $(".zona_1").hide();
                                $(".zona_2").hide();
                                 $(".zona_3").show();
                                 $(".zona_0").hide();
                                 $("#data_person-val31").focus();
                                  $(".ok_t").show();
                                   $(".field-data_person-tel").show();
                                   $( ".msg" ).remove();
                                 $( ".field-data_person-init" ).append("<span class="+String.fromCharCode(34)+"msg"+String.fromCharCode(34)+">"+adr+ "</span>");
                                  
                                    $("#data_person-val1").val(0);
                                    $("#data_person-val21").val(0);
                                   $("#data_person-val22").val(0);
                              
                          }
                          }
//                          alert(z);
                      
                  });'
    ])?>

    <div class="zona_0">
        <span class="label label-danger">Такий особовий рахунок відсутній</span>

    </div>


    <div class="zona_1">
    <?= $form->field($model, 'val1')->label('Введіть показання лічильника') -> textinput ()?>

    </div>

    <div class="zona_2">


    <?= $form->field($model, 'val21')->label('Показання лічильника: День') -> textinput ()?>

    <?= $form->field($model, 'val22')->label('Показання лічильника: Ніч') -> textinput ()?>

    </div>

    <div class="zona_3">

    <?= $form->field($model, 'val31')->label('Показання лічильника: Пік') -> textinput ()?>

    <?= $form->field($model, 'val32')->label('Показання лічильника: Напівпік') -> textinput ()?>

    <?= $form->field($model, 'val33')->label('Показання лічильника: Ніч') -> textinput ()?>

    </div>

    <?= $form->field($model, 'tel')->label('Телефон') -> textinput ()?>
    <?= $form->field($model, 'cnt')->textinput ()?>
    <?= $form->field($model, 'zones')->textinput ()?>
    <?= $form->field($model, 'valp1')->textinput ()?>
    <?= $form->field($model, 'valp21')->textinput ()?>
    <?= $form->field($model, 'valp22')->textinput ()?>
    <?= $form->field($model, 'valp31')->textinput ()?>
    <?= $form->field($model, 'valp32')->textinput ()?>
    <?= $form->field($model, 'valp33')->textinput ()?>

    <?= Html::submitButton('Надіслати',['class' => 'btn btn-success ok_t','value' => 'pokaz']) ?>

    <?php ActiveForm::end() ?>
</div>
