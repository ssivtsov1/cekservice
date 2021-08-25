<?php
// Вывод результата рассчета стоимости подключения
 
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\Response;
use app\models\forExcel;

use yii\bootstrap\Modal;

?>
<?php
if(empty($is)) {
    $r = 'Мережа не належить Центральній Енергетичній Компанії';

}

else {
    $r = "Мережа Центральної Енергетичної Компанії [ $is ]";
    $tel=$model[0]->tel;
}

?>

<div class="site-login">
    <h4><?= Html::encode("Результат пошуку:") ?></h4>
    <br>
    
        <table width="600px" class="table table-bordered table-hover table-condensed ">
            <thead>
            <tr>
                <th width="150px">РЕМ</th>
                <?php
                if(!empty($is)):
                    ?>
                    <th width="150px">Телефон</th>
                <?php
                endif;
                ?>

            </tr>
            </thead>
            <tbody>

            <tr>
                <td><?= $r ?></td>
                <?php
                if(!empty($is)):
                    ?>
                    <td><?= $tel ?></th>
                <?php
                endif;
                ?>

            </tr>
            
            </tbody>
        </table>
</div>


<?php
Modal::begin([
'header' => '<h3>Результат пошуку</h3>',
'toggleButton' => [
'label' => 'Результат пошуку',
'tag' => 'button',
'class' => 'btn btn-success',
]
]);

?>

<?php
if(empty($is)) {
    $r = 'Мережа не належить Центральній Енергетичній Компанії';

}

else {
    $r = "Мережа Центральної Енергетичної Компанії [ $is ]";
    $tel=$model[0]->tel;
}

?>

<div class="site-login">
<!--    <h4>--><?//= Html::encode("Результат пошуку:") ?><!--</h4>-->
    <br>

    <table width="600px" class="table table-bordered table-hover table-condensed ">
        <thead>
        <tr>
            <th width="150px">РЕМ</th>
            <?php
                if(!empty($is)):
            ?>
            <th width="150px">Телефон</th>
            <?php
                endif;
            ?>

        </tr>
        </thead>
        <tbody>

        <tr>
            <td><?= $r ?></td>
            <?php
            if(!empty($is)):
                ?>
                <td><?= $tel ?></th>
            <?php
            endif;
            ?>

        </tr>

        </tbody>
    </table>
</div>

<?php
    Modal::end();
?>
</br>
</br>
</br>
</br>



