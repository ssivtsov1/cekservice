<?php
/**
 * Модель для передачи показаний счетчиков  в САП по лиц. счету.
 */
namespace app\models;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;

class Data_person extends Model
{
    public $lic;     // Лицевой счет
    public $tel;   // Телефон
    public $zones;   // Кол-во зон
    public $cnt;   // № счетчика
    public $val1; // Однозонный счетчик (показания)
    public $val21; // 2 зонный счетчик (показания) день
    public $val22; // 2 зонный счетчик (показания) ночь
    public $val31; // 3 зонный счетчик (показания)
    public $val32; // 3 зонный счетчик (показания)
    public $val33; // 3 зонный счетчик (показания)
// Предыдущие показания
    public $valp1; // Однозонный счетчик (показания)
    public $valp21; // 2 зонный счетчик (показания) день
    public $valp22; // 2 зонный счетчик (показания) ночь
    public $valp31; // 3 зонный счетчик (показания)
    public $valp32; // 3 зонный счетчик (показания)
    public $valp33; // 3 зонный счетчик (показания)
    public $init; // Буквы инициалов пользователя электроэнергии

    //
    public function attributeLabels()
    {
        return [
            'tel' => 'Телефон:',
            'lic' => 'Особовий рахунок:',
            'val1'=> 'Показники:',
             'init'=> 'Перші літери прізвища імені та по баткові, наприклад:
             Петров Сергій Васильович - введіть ПСВ'
        ];
    }

    public function rules()
    {
        return [
            [['tel', 'lic','val1','val21','val22','val31','val32','val33',
                'valp1','valp21','valp22','valp31','valp32','valp33','cnt','zones'], 'safe'],
            [['lic','val1','val21','val22','val31','val32','val33','tel','init'], 'required','message' => 'Поле обов’язкове'],
        ];
    }
}
