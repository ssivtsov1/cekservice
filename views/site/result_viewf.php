<script>

    window.addEventListener('load', function () {
        var n1=localStorage.getItem('num');
        var flag_back=localStorage.getItem('flag_back');
        $('table tr').each(function(row){
            $(this).find('td').each(function(cell){
                $(this).css({"background" : "#fff"});
                if(row==n1 && flag_back==1) {
                    // $(this).css({"background" : "#30d5c8"});  // Выделение строки таблицы бирюзовым цветом
                    $(this).css({"background" : "#d4d4d4"});
                    localStorage.setItem('flag_back',0);
                }
            });
        });

        $("img").click(function(){	// Событие клика на маленькое изображение
            var img = $(this);	// Получаем изображение, на которое кликнули
            var src = img.attr('src'); // Достаем из этого изображения путь до картинки
            var p=$(this).position();

            $("body").append("<div class='popup'>"+ //Добавляем в тело документа разметку всплывающего окна
                "<div class='popup_bg'></div>"+ // Блок, который будет служить фоном затемненным

                "<img src='"+src+"' class='popup_img' />"+ // Са мо увеличенное фото
                "<img src='"+'cross-photo.jpg'+"' class='close-photo' />"+ // крестик для закрития фото
                "</div>");
            $(".popup").css("top", p.top );
            $(".popup").fadeIn(600); // Медленно выводим изображение
            $(".popup_bg").click(function(){	// Событие клика на затемненный фон
                $(".popup").fadeOut(600);	// Медленно убираем всплывающее окно
                setTimeout(function() {	// Выставляем таймер
                    $(".popup").remove(); // Удаляем разметку всплывающего окна
                }, 600);
            });
        });

        $('body').on('click', '.foto_d', function (e) {	// Событие клика на маленькое изображение

            var img = $(this);	// Получаем изображение, на которое кликнули
            var src = img.attr('src'); // Достаем из этого изображения путь до картинки

            // var p=$(this).position();
            var p=localStorage.getItem('top_d');
            // alert(p);
            $("body").append("<div class='popup'>"+ //Добавляем в тело документа разметку всплывающего окна
                "<div class='popup_bg'></div>"+ // Блок, который будет служить фоном затемненным
                "<img src='"+src+"' class='popup_img' />"+ // Са мо увеличенное фото
                "</div>");
            $(".popup").css("top", p );
            $(".popup").fadeIn(600); // Медленно выводим изображение
            $(".popup_bg").click(function(){	// Событие клика на затемненный фон
                $(".popup").fadeOut(600);	// Медленно убираем всплывающее окно
                setTimeout(function() {	// Выставляем таймер
                    $(".popup").remove(); // Удаляем разметку всплывающего окна
                }, 600);
            });
        });

        $('body').on('mousedown', '.popup_event_d', function (e) {
                e.preventDefault();
                // Нажатие на колесико мыши
              if(e.button == 1){
                  var f=localStorage.getItem("cur_photo");
                  var id=localStorage.getItem("cur_id");
                  var href='detail_photo?id='+id+'&file_path='+f+'&num='+n1;
                  window.location.href=href;
                }
         });

        $('body').on('dblclick', '#w0', function (e) {
            $('.popup_event').children().remove();
            $('.popup_event_d').children().remove();
        });

        $('body').on('click', '.pict-cross', function (e) {
            $('.popup_event').children().remove();
        });

        $('body').on('click', '.pict-cross_d', function (e) {
            $('.popup_event_d').children().remove();
        });

        $('body').on('click', '.update-modal-click', function (e) {

            var id = $(this).data('id');
            var num = $(this).data('num');
            var p1=$(this).position();
            localStorage.setItem("top_d", p1.top);

              $('table tr').each(function(row){
                $(this).find('td').each(function(cell){
                    $(this).css({"background" : "#fff"});
                    if(row==num) {
                        // $(this).css({"background" : "#30d5c8"});
                        $(this).css({"background" : "#d4d4d4"});
                    }
                });
            });

            $(this).addClass('hasFocus');
            $.ajax({
                url: '/cekservice/web/site/gdata',
                data: {id: id},
                type: 'GET',
                success: function(res){
                    // $('.popup_event').find('#tbl_rez').remove();
                    $('.popup_event').children().remove();
                    $('.popup_event_d').children().remove();
                    var p=localStorage.getItem("top_d");
                    // $(".popup_event").css("top",  p);
                    // $('.container').children().not('.main').remove();
                    var t='<img class="pict-cross" src="cross.png">';
                    $('.popup_event').append(t);
                    var t='<table id="tbl_rez"  cellpadding="" cellspacing="" border=1>';
                    $('.popup_event').append(t);
                    var t='<tr class="tbl_row">';
                    $('.popup_event').append(t);
                    var t='<th class="tbl_header"> № </th>';
                    $('.popup_event').append(t);
                    var t='<th class="tbl_header"> Подія </th>';
                    $('.popup_event').append(t);
                    var t='<th class="tbl_header"> Фото (кільк.) </th>';
                    $('.popup_event').append(t);
                    var t='</tr>';
                    $('.popup_event').append(t);

                    for(var ii = 0; ii<res.cur.length; ii++) {
                        var nazv_sob = res.cur[ii].nazv_sob;
                        var kol = res.cur[ii].kol;
                        var t='<tr class="tbl_row">';
                         $('.popup_event').append(t);
                         t='<td class="td_exl">' + (ii+1) + '</td>';
                        $('.popup_event').append(t);

                        // t='<td>' + '<a id="view_event" class="ref_'+id +'_'+res.cur[ii].id_event+'"'+
                        // 'href="/cekservice/web/gdata_d?id='+id+'&id_event='+res.cur[ii].id_event+'">'+nazv_sob+'</a></td>';
                        t='<td class="td_exl">' + '<a id="view_event" class="ref_'+id +'_'+res.cur[ii].id_event+'"'+
                            ' href="#" onclick='+'"'+"f_event("+id+','+res.cur[ii].id_event+');'+" return false;"+'"'+'>'+nazv_sob+'</a></td>';

                        $('.popup_event').append(t);
                        t='<td class="td_exl">' + kol+ '</td>';
                        $('.popup_event').append(t);
                        t='</tr>';
                        $('.popup_event').append(t);
                    }
                    t='</table>';
                    $('.popup_event').append(t);
                    // $('.popup_event').show();
                    // $(".popup_event").css("top",  0);

                    // $('#w0').scrollTop(+p);
                    p=(+p)+120;
                    var  p2=(+p)-120;
                    $(".popup_event").css("top",  p);

                    // $("html, body").scrollTop(0);

                    $(".popup_event").fadeIn(600); // Медленно выводим изображение

                    if(!res) alert('Данные не верны!');

                },
                error: function (data) {
                    console.log('Error', data);
                },

            });
            // var p=localStorage.getItem("top_d");
            // $('body').scrollTop(+p);

            setTimeout(function () {
                // $('.hasFocus').focus();
            }, 400);


            // alert(p);

        });

    });
</script>

<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use yii\grid\SerialColumn;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;

$this->title = "Фото лічильників";
//debug($dataProvider->getModels());
//$this->params['breadcrumbs'][] = $this->title;
//echo Html::a('Експорт в Excel', ['site/viewf2excel'
//],
//    ['class' => 'btn btn-info excel_btn',
//        'data' => [
//            'method' => 'post',
//            'params' => [
//                'data' => $sql
//            ],
//        ]]);
echo Html::a('Пошук', ['photo_counter_view'], ['class' => 'btn btn-success']);
?>
    <div class="site-spr">

        <h4><?php

            echo Html::encode($this->title);
            ?></h4>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'summary' => false,
            'emptyText' => 'Нічого не знайдено',
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    /**
                     * Указываем класс колонки
                     */
                    'class' => \yii\grid\ActionColumn::class,
                    'buttons'=>[

                        'update'=>function ($url, $model,$key)  {
//                            $customurl=Yii::$app->getUrlManager()->createUrl(['/site/gdata','id'=>$model['id'],'mod'=>'gdata']); //$model->id для AR
                            $customurl='# return false';
                            return \yii\helpers\Html::a( '<span class="glyphicon glyphicon-book"></span>', $customurl,
                                ['title' => Yii::t('yii', 'Історія'),
                                    'class'=>'update-modal-click grid-action',
                                    'data-id' => $model['id'],
                                    'data-num' => $model['num'],
                                    'data-pjax' => '0']);
                        }


                    ],
                    /**
                     * Определяем набор кнопочек. По умолчанию {view} {update} {delete}
                     */
                    'template' => '{update}',
                ],
                [
                    'format' => 'raw',
                    'header' => 'Перегляд',
                    'value' => function ($model) {
                        return \yii\helpers\Html::a('<span class="glyphicon glyphicon-list"></span>',
                            ['site/detail_photo?id=' . $model->id . "&file_path=$model->f1"."&num=$model->num"
                            ],
                            ['title' => Yii::t('yii', 'Відобразити детально фото'),
                                'class'=>'view_detal_photo',
                                'data-id' => $model['id'],
                                'data-num' => $model['num'],
                                'data-pjax' => '0']
                        );
                    }
                ],
                [
                    'attribute' => 'Фото',
                    'format' => 'html',
                    'value' => function ($data) {
                        if(!empty($data['f1']))
                            return Html::img('data/foto_wifi/byt/'. $data['f1'],
                                ['width' => '75px',' -moz-border-radius' => '10px']);
                        else
                            return '';
                    },
                ],
                'nazv_res',
                'dates',
                'ls',
                'eic',
                'sapid',
                'potrebitel',
                'adres',
                'nazv_sob',
                'type_foto',
                'counter',
                'sn',
                'tp',
                'zonity',
                'zone0',
                'zone1',
                'zone2',
                'zone3',
                'zdate',
                'operator'

            ],
        ]);?>


    </div>

<div class="popup_event">
</div>
<div class="popup_event_d">
</div>

<?php

//Modal::begin([
//    'header' => '<h4>Update Model</h4>',
//    'id' => 'update-modal',
//    'size' => 'modal-lg'
//]);
//
//echo "<div id='updateModalContent'>ааааа</div>";
//
//Modal::end();

?>

<script>
function f_event(id,id_event){
// Нажатие на ссылку в группировке фото по событиям
    $.ajax({
        url: '/cekservice/web/site/gdata_d',
        data: {id: id,id_event: id_event},
        type: 'GET',
        success: function(res){
            $('.popup_event_d').children().remove();
            var t='<img class="pict-cross_d" src="cross.png">';
            $('.popup_event_d').append(t);
            var t='<table id="tbl_rez1"  cellpadding="" cellspacing="" border=1>';
            $('.popup_event_d').append(t);
            var t='<tr class="tbl_row1">';
            $('.popup_event_d').append(t);
            var t='<th class="tbl_header1"> № </th>';
            $('.popup_event_d').append(t);
            var t='<th class="tbl_header1"> Фото </th>';
            $('.popup_event_d').append(t);
            var t='<th class="tbl_header1">Дата </th>';
            $('.popup_event_d').append(t);

            for(var ii = 0; ii<res.cur.length; ii++) {
                var f = res.cur[ii].f1;
                localStorage.setItem('cur_photo',f);
                localStorage.setItem('cur_id',id);
                var date = res.cur[ii].dates;

                var t='<tr class="tbl_row1">';
                $('.popup_event_d').append(t);
                t='<td>' + (ii+1) + '</td>';
                $('.popup_event_d').append(t);
                t='<td><img class="foto_d" src="' + "data/foto_wifi/byt/"+f + '" width="100" height="100"></td>';
                $('.popup_event_d').append(t);
                t='<td class="td_exl">' + date + '</td>';
                $('.popup_event_d').append(t);
                t='</tr>';
                $('.popup_event_d').append(t);
            }
            t='</table>';
            $('.popup_event_d').append(t);
            // $('.popup_event_d').show();
            $(".popup_event_d").fadeIn(600); // Медленно выводим изображение
            if(!res) alert('Данные не верны!');

        },
        error: function (data) {
            console.log('Error', data);
        },

    });

}
</script>

