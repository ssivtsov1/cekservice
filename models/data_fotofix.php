<?php
/*Ввод основных данных для поиска фото счетчиков*/

namespace app\models;
use Yii;
use yii\base\Model;

class Data_fotofix extends Model
{
    public $date1;              // Дата нач
    public $date2;              // Дата конец
    public $fio;                   // Пользователь электроэнергией
    public $res;                  // РЭС
    public $lic;                    // Лицевой счет
    public $town;               // Населенный пункт
    public $street;             // Улица
    public $house;             // № дома
    public $event;             // Событие
    public $type_image;  // Тип фото
    public $id_street;
    public $id_t;
    public $sapid;    // Контокоррентный счет
    public $sn;         // № счетчика
    public $eic;         // EIC код
    public $tp;         // ТП
    public $counter;         // Тип счетчика
    public $other_items;         // Тип счетчика

    public function attributeLabels()
    {
        return [
            'date1' => 'Період з ',
            'date2' => 'Період по',
            'fio' => 'Користувач электроенергією',
            'lic' => 'Особовий рахунок',
            'res' => 'РЕМ',
            'town' => 'Населений пункт',
            'street' => 'Вулиця',
            'house' => '№ будинку',
            'event' => 'Подія',
            'type_image' => 'Тип фото',
            'id_t' => '',
            'id_street' => '',
            'eic' => 'EIC код',
            'counter' => 'Лічильник',
            'sn' => 'Сер. №',
            'zonity' => 'Зон',
            'zone0' => 'Зона загальна',
            'zone1' => 'Зона 1',
            'zone2' => 'Зона 2',
            'zone3' => 'Зона 3',
            'tp' => 'ТП',
            'sapid' => 'Контокорентний рахунок',
            'counter' => 'Тип лічильника',
            'other_items' => 'Інші фільтри',
        ];
    }

    public function rules()
    {
        return [
            ['date1', 'safe'],
            ['date2', 'safe'],
            ['fio', 'safe'],
            ['type_image', 'safe'],
            ['res', 'safe'],
            ['town', 'safe'],
            ['event', 'safe'],
            ['street', 'safe'],
            ['house', 'safe'],
            ['lic', 'safe'],
            ['id_t', 'safe'],
            ['id_street', 'safe'],
            ['eic', 'safe'],
            ['counter', 'safe'],
            ['sn', 'safe'],
            ['zonity', 'safe'],
            ['zone0', 'safe'],
            ['zone1', 'safe'],
            ['zone2', 'safe'],
            ['zone3', 'safe'],
            ['tp', 'safe'],
            ['sapid', 'safe'],
            ['tp', 'safe'],
            ['counter', 'safe'],
            ['other_items', 'safe'],
        ];
    }

}
