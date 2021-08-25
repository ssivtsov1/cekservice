<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\assets\AppAsset_eye;
use yii\web\Request;
use app\models\schet;
use app\models\max_schet;

/* @var $this \yii\web\View */
/* @var $content string */
$session = Yii::$app->session;
$session->open();
$switch=$session->get('switch');
//$this->title = "Визначення мережі ЦЕК";
        
if(isset($switch)){
   
    if($switch==0)
        AppAsset::register($this);
    else
        AppAsset_eye::register($this);
}
else {
    AppAsset::register($this);
}
?>


<script>
    window.addEventListener('load', function(){

        var d = '<?php echo $this->context->face;?>';
        if(d==1)
            $(".sw_ver").css('display','none');

              var ua = navigator.userAgent;
              if (ua.search(/Firefox/) == -1) {
              //alert(navigator.userAgent);    
              $(".rh1").css('dicplay','none');
              $(".rh2").css('dicplay','none');
              $(".rh3").css('dicplay','none');
              $(".rh1").css('padding-left','17.1%');
              $(".rh2").css('padding-left','17.1%');
              $(".rh3").css('padding-left','17.1%');
              $(".rh1").css('dicplay','inline-block');
              $(".rh2").css('dicplay','inline-block');
              $(".rh3").css('dicplay','inline-block');}
          });


          
</script>
    

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet"> 
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php
    $flag=1;
    $role=0;
    $department = '';

    $flag=1;
    $role=3;
    $this->head() ?>
</head>
<body>

<?php $this->beginBody() ?>
    <div class="wrap">

        <div class="info-main col-lg-12">   
          <div class="info-header col-lg-12">    
        <!--Вывод логотипа-->


              <? if(strpos(Yii::$app->request->url,'power_outages')):  ?>
                  <img class="logo_site" src="../Logo.png" alt="ЦЕК" />
                  <?      $this->title = "Відключення"; ?>
              <? endif; ?>
              <?
              if(strpos(Yii::$app->request->url,'auto')):  ?>
                   <img class="logo_site" src="../Logo.png" alt="ЦЕК" />
                  <?      $this->title = "Звіти [auto]"; ?>
              <? endif; ?>

        <div class="name-company">              
            <p class="head_cek"><span>П<i>р</i>ат Підприємство з експлуатації електричних мереж</span>
                <s>Центральна Енергетична Компанія</s></p>
            <div>Твоє джерело енергії</div>
        </div>
        <div class="head-phone">              
        <div class="call">
        <div class="custom">
                <p><a href="tel:0800300015">0 800 300 015</a></p>
        <div><span>Call-центр</span>безкоштовно цілодобово</div></div>
            <p>
            <?php
//            $qq = $this->context->face;
//            debug($qq);
//            if($qq==0):
            ?>

           <div class="sw_ver"><span class="glyphicon glyphicon-eye-open"></span>
               <?php

               $switch=$session->get('switch');

                if(isset($switch)):
                    if($switch==0):
               ?>         
                    <a href="/Connect/web/switch">Версія для слабозорих</a></div>
                    <?php endif; ?>
               <?php if($switch==1): ?>
                        <a href="/Connect/web/switch">Звичайна версія</a></div>
               <?php endif; ?>
               <?php endif; ?>
               <?php if(!isset($switch)): ?>
                    <a href="/Connect/web/switch">Версія для слабозорих</a></div>
               <?php endif; ?>
                </p> 
                    <div class="clr"></div>
        </div>
        </div>
        

        </div>
<!--        --><?php //endif; ?>

        </div>
        <div class="container">
            
              <?= $content ?>
        </div>
    </div>

<!--    <footer class="footer">-->
<!--        <div class="container">-->
<!--            <p class="pull-left">&copy; ЦЕК --><?//= date('Y') ?><!--</p>-->
<!--            <p class="pull-right">--><?//= //Yii::powered() ?><!--</p>-->
<!--        </div>-->
<!--    </footer>-->


<div id="footer" class="fix">
      <div class="wrap1">
<!--        <div class="footer-logo">-->
<!--            <div class="moduletable">-->
<!---->
<!---->
<!--            -->
<!--            <div class="custom">-->
<!--                --><?php
               $switch=$session->get('switch');
//                if(isset($switch)):
//                    if($switch==0):
//               ?><!--         -->
<!--                        <p><img src="../Logo-footer.png" alt=""></p>-->
<!--                    --><?php //endif; ?>
<!--               --><?php //if($switch==1): ?>
<!--                        <p><img class="logo-footer" src="../Logo.png" alt=""></p>-->
<!--               --><?php //endif; ?>
<!--               --><?php //endif; ?>
<!--               --><?php //if(!isset($switch)): ?><!-- -->
<!--                        <p><img src="../Logo-footer.png" alt=""></p>-->
<!--                --><?php //endif; ?>
<!--            </div>-->
<!--            </div>-->
<!--	-->
<!--        </div>       -->
<!--        <div class="footer-menu1">-->
<!--        <div class="moduletable">-->
<!--                <ul class="nav1 menu">-->
<!--                <li class="item-132"><a href="https://cek.dp.ua/index.php/tovarystvo.html"><span>Про підприємство</span></a></li>-->
<!--                <li class="item-133"><a href="https://cek.dp.ua/index.php/tovarystvo/kerivnytstvo.html"><span>Керівництво</span></a></li>-->
<!--                <li class="item-134"><a href="https://cek.dp.ua/index.php/cpojivaham/hrafik-pryiomu-hromadian.html"><span>Графік прийому</span></a></li>-->
<!--                <li class="item-135"><a href="https://cek.dp.ua/index.php/tovarystvo/strukturni-pidrozdily.html"><span>Структурні підрозділи</span></a></li>-->
<!--                <li class="item-136"><a href="https://cek.dp.ua/index.php/tovarystvo/zakup/investprohrama-zakupivli.html"><span>Інвестиційна программа</span></a></li>-->
<!--                -->
<!--                </ul>-->
<!--        </div>-->
<!--	-->
<!--        </div>-->
<!--        <div class="footer-menu2">-->
<!--                <div class="moduletable">-->
<!--                    <ul class="nav1 menu">-->
<!--                    <li class="item-138"><a href="https://cek.dp.ua/index.php/cpojivaham.html"><span>Споживачам</span></a></li>-->
<!--                    <li class="item-139"><a href="https://cek.dp.ua/index.php/cpojivaham/pryiednannia-do-elektromerezh.html"><span>Приєднання до електромереж</span></a></li>-->
<!--                    <li class="item-140"><a href="https://cek.dp.ua/index.php/cpojivaham/vidkliuchennia.html"><span>Відключення</span></a></li>-->
<!--                    <li class="item-141"><a href="https://cek.dp.ua/index.php/cpojivaham/zahalna-informatsiia/nashi-posluhy.html"><span>Наші послуги</span></a></li>-->
<!--                    <li class="item-143"><a href="https://cek.dp.ua/index.php/pres-tsentr.html"><span>Прес-центр</span></a></li>-->
<!--                    <li class="item-137"><a href="https://cek.dp.ua/index.php/tovarystvo/personal/vakansii.html"><span>Вакансії</span></a></li>-->
<!--                    </ul>-->
<!--		</div>-->
<!--	-->
<!--        </div>-->
<!--<div class="footer-cont">-->
<!--<div class="moduletable">-->
<!--						-->
<!---->
<!--<div class="custom">-->
<!--    <div><span>Контакти:</span></div>-->
<!--<div>вул. Дмитра Кедріна, 28,&nbsp; м. Дніпро, 49008, Україна</div>-->
<!--<div class="tel-foot">-->
<!--    <a href="tel:0562310384"><span>Телефон:</span> 0562 31-03-84</a>-->
<!--</div>-->
<!--<div><a href="tel:0562312480"><span>Факс:</span> 0562 31-24-80</a></div>-->
<!--<div><a href="tel:0800300015"><span>Call-центр:</span> 0800 30-00-15</a></div>-->
<!--<div><a href="mailto:kanc@cek.dp.ua"><span>E-mail:</span> kanc@cek.dp.ua</a></div>-->
<!--<p class="soc1">-->
<!--    <a href="http://www.facebook.com/pratpeemcek" target="_blank" class="soc">-->
<!--        <img src="/images/face.png" alt="">&nbsp; </a> <a href="https://www.youtube.com/channel/UCLOQrRe56Fkcgph2SdNAfhA?disable_polymer=true" -->
<!--           target="_blank" class="yout">-->
<!--        <img src="/images/youtube.png" alt=""></a></p>-->
<!--</div>-->
<!--</div>-->
<!--	-->
<!--</div>-->
        <div class="footer">


            <div id="container_footer" class="container">

                <?php
                $day = date('j');
                $month = date('n');
                $day_week = date('w');
                switch ($day_week)  {
                    case 0:
                        $dw = 'нед.';
                        break;
                    case 1:
                        $dw = 'пон.';
                        break;
                    case 2:
                        $dw = 'вівт.';
                        break;
                    case 3:
                        $dw = 'середа';
                        break;
                    case 4:
                        $dw = 'четв.';
                        break;
                    case 5:
                        $dw = 'п’ятн.';
                        break;
                    case 6:
                        $dw = 'суб.';
                        break;

                }
                $day = $day.' '.$dw;
                ?>

                <table width="100%" class="table table-condensed" id="calendar_footer">
                    <tr>
                        <th width="8.33%">
                            <?php
                            if($month==1) echo '<div id="on_ceil">'.$day.'</div>';
                            ?>

                        </th>
                        <th width="8.33%">
                            <?php
                            if($month==2) echo '<div id="on_ceil">'.$day.'</div>';
                            ?>
                        </th>
                        <th width="8.33%">
                            <?php
                            if($month==3) echo '<div id="on_ceil">'.$day.'</div>';
                            ?>
                        </th>
                        <th width="8.33%">
                            <?php
                            if($month==4) echo '<div id="on_ceil">'.$day.'</div>';
                            ?>
                        </th>
                        <th width="8.33%">
                            <?php
                            if($month==5) echo '<div id="on_ceil">'.$day.'</div>';
                            ?>
                        </th>
                        <th width="8.33%">
                            <?php
                            if($month==6) echo '<div id="on_ceil">'.$day.'</div>';
                            ?>
                        </th>
                        <th width="8.33%">
                            <?php
                            if($month==7) echo '<div id="on_ceil">'.$day.'</div>';
                            ?>
                        </th>
                        <th width="8.33%">
                            <?php
                            if($month==8) echo '<div id="on_ceil">'.$day.'</div>';
                            ?>
                        </th>
                        <th width="8.33%">
                            <?php
                            if($month==9) echo '<div id="on_ceil">'.$day.'</div>';
                            ?>
                        </th>
                        <th width="8.33%">
                            <?php
                            if($month==10) echo '<div id="on_ceil">'.$day.'</div>';
                            ?>
                        </th>
                        <th width="8.33%">
                            <?php
                            if($month==11) echo '<div id="on_ceil">'.$day.'</div>';
                            ?>
                        </th>
                        <th width="8.33%">
                            <?php
                            if($month==12) echo '<div id="on_ceil">'.$day.'</div>';
                            ?>
                        </th>
                    </tr>
                    <tr>

                        <td>
                            <?= "січень" ?>
                        </td>
                        <td>
                            <?= "лютий" ?>
                        </td>
                        <td>
                            <?= "березень" ?>
                        </td>
                        <td>
                            <?= "квітень" ?>
                        </td>
                        <td>
                            <?= "травень" ?>
                        </td>
                        <td>
                            <?= "червень" ?>
                        </td>
                        <td>
                            <?="липень" ?>
                        </td>
                        <td>
                            <?= "серпень" ?>
                        </td>
                        <td>
                            <?= "вересень" ?>
                        </td>
                        <td>
                            <?= "жовтень" ?>
                        </td>
                        <td >
                            <?= "листопад" ?>
                        </td>
                        <td>
                            <?= "грудень" ?>
                        </td>
                    </tr>


                </table>

            </div>





        </div>
      </div>
    </div>


<div class="footer-copy">
      <div class="wrap1">

        <div class="moduletable">


        <div class="custom">
            <div class="copy-text">© ПрАТ «Підприємство з експлуатації електричних мереж «Центральна енергетична компанія»</div>

        </div>
            <div class="clr"></div>
        </div>

      </div>
</div>


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
