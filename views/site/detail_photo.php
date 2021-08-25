<?php


use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

use yii\grid\GridView;
use yii\grid\ActionColumn;
use yii\grid\CheckboxColumn;
use yii\grid\SerialColumn;
use yii\widgets\DetailView;
use yii\widgets\ListView;
use yii\widgets\LinkPager;

$this->title = 'Перегляд фото (детально)';
$this->params['breadcrumbs'][] = $this->title;
//$img = $_GET['file_path'];

$img = $file_path;

?>
<script>

    window.onload=function(){
        //  Реакция на нажатие кнопки  - Назад
        window.history.pushState({page: 1}, "", "");
        window.onpopstate = function(event) {
            // "event" object seems to contain value only when the back button is clicked
            // and if the pop state event fires due to clicks on a button
            // or a link it comes up as "undefined"

            if(event){
               // alert('go back');
               localStorage.setItem('flag_back',1);
                history.go(-1); // go back
                var num = <?php echo $num; ?>;
                localStorage.setItem('num',num);
            }
            else{
                // Continue user action through link or button
                // alert('1111');
            }
        }

        localStorage.setItem("angle", 0);
        localStorage.setItem("q", 0);
        $('#rotate').bind('click', function(){
            var angle = Number(localStorage.getItem("angle"))+90;
            var q = Number(localStorage.getItem("q"))+1;
            localStorage.setItem("q", q);
            localStorage.setItem("angle", angle);
            //$(".img_detail").rotate(angel);

            $(".img_detail").rotate({animateTo:angle});

            if(q%2==1) {
                $(".img_detail").css('margin-top', '100px');
                $("#map_q").css('margin-top', '160px');
                $(".span_single").css('display', 'none');
            }
            else {
                $(".img_detail").css('margin-top', '12px');
                $("#map_q").css('margin-top', '15px');
                $(".span_single").css('display', 'inline');
            }
        });

        //var tp = "<?php //echo $id_tp; ?>//";
           setTimeout(function () {
            initMap();
        }, 600); // время в мс

        $('.img_detail').lightzoom({zoomPower   : 3.5});

    }

</script>

<div class="site-spr">
    <div class="site-detail">
        <h4><?= Html::encode($this->title) ?></h4>
        <!--<? echo "<img src=data/foto_wifi/byt/".$img.'>'; ?>-->
        <div class="detail-photo">
            <div class="detail-photo-data1">
                <?=changeDateFormat($date, 'd.m.Y');?>
            </div>
            <?php if(!empty($fio)): ?>
                <div class="detail-photo-data2">
                    <?='Користувач електроенергією: '. $fio;?>
                </div>
            <?php endif; ?>
            <?php if(!empty($ls)): ?>
                <div class="detail-photo-data2">
                    <?='Особовий рахунок: '. $ls;?>
                    <?='<br> ';?>
                    <?='Адреса: '. $adres;?>
                    <?='<br> ';?>
                    <?='№ лічильника: '. $mas[0] . ' ' . 'Кількість зон - '.$mas[1];?>
                    <?='<br> ';?>
                    <?
                    if($mas[1]==1)
                        echo('Показники: ' . $mas[2] . ' кВт*год');
                    if($mas[1]==2)
                        echo('Показники: Загальна зона: ' . $mas[2] . ' кВт*год' . ' День: '. $mas[3] .
                            'кВт*год' . ' Ніч: '. $mas[4] . ' кВт*год' );
                    if($mas[1]==3)
                        echo('Показники: Загальна зона: ' . $mas[2] . ' кВт*год' . ' Пік: '. $mas[3] .
                            ' кВт*год' . ' Напівпік: '. $mas[4] . ' кВт*год' . ' Ніч: '. $mas[5] . ' кВт*год' );
                    ?>
                    <?='<br> ';?>
                    <?='Дата показників: '. $mas[6];?>
                </div>
            <?php endif;?>

            <?= \yii\helpers\Html::img("data/foto_wifi/byt/$img",['class'=>'img_detail']) ?>
        </div>

        <br>

    </div>
    <div class="form-group">
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <button class='btn btn-primary' id="rotate" > Поворот фото </button>
        <br>
        <br>

    </div>
<!--    --><?//= Html::a('Видалити фото', ['del_img', 'id' => $id,'file_path' => $img], [
//        'class' => 'btn btn-danger',
//        'data' => [
//            'confirm' => 'Ви впевнені, що хочете видалити це фото?',
//            'method' => 'post',
//        ]]);  ?>
</div>


<div class="clearfix"></div>
<br>

