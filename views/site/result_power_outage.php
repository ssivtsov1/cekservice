<?php
// Отображение показателей
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

use yii\grid\GridView;
use yii\grid\ActionColumn;
use yii\grid\SerialColumn;
use yii\widgets\DetailView;
use \app\models\Power_outages;
?>

<div class = 'test'>
    <?php

    echo "<table class='table table-bordered'>";
    echo "<th>№</th>";
    echo "<th>Вид роботи</th>";
    echo "<th>Адреса</th>";
    echo "<th>Дата початку</th>";
    echo "<th>Дата закінчення</th>";
    echo "<th>Дата розміщення</th>";
    echo "<th>Підстанція</th>";
    echo "<th>РЕМ</th>";
    echo "<th>Тип відключення</th>";
    echo "<th>Статус</th>";

    $i = 0;
    //for($i=0;$i<$kol;$i++) {
    foreach ($data as $v) {
        $i++;
        echo('<tr>');
        echo('<td>' . $i . '</td>');
        echo('<td>' . $v['descr']. '</td>');
        echo('<td class="custom_tbl">' . converting_string($v['addresses']). '</td>');
        echo('<td>' . $v['date_begin']. '</td>');
        echo('<td>' . $v['date_end']. '</td>');
        echo('<td>' . $v['dtcreate']. '</td>');
        echo('<td>' . $v['enobject']. '</td>');
        echo('<td>' . $v['encode']. '</td>');
        echo('<td>' . $v['type_otkl']. '</td>');
        echo('<td>' . $v['status']. '</td>');

        echo('</tr>');
    }
    echo '</table>';
    ?>
</div>
