<?php
// Основное хранилище данных (фотофиксация счетчиков)
namespace app\models;

use Yii;
use yii\base\Model;
use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;

class Fotofix extends \yii\db\ActiveRecord
{
    public $kol;
    public $num;

    public static function tableName()
    {
        return 'vw_fotofix';  // Вид
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'note' => 'Примітка',
            'nazv_res' => 'РЕМ',
            'ls' => 'Ос/рах.',
            'potrebitel' => 'П.І.Б',
            'adres' => 'Адреса',
            'dates' => 'Дата',
            'nazv_sob' => 'Подія',
            'type_foto' => 'Тип фото',
            'f1' => 'Фото',
            'operator' => 'Контролер',
            'status' => 'Статус',
            'eic' => 'EIC код',
            'counter' => 'Лічильник',
            'sn' => 'Сер. №',
            'zonity' => 'Зон',
            'zone0' => 'Зона загальна',
            'zone1' => 'Зона 1',
            'zone2' => 'Зона 2',
            'zone3' => 'Зона 3',
            'tp' => 'ТП',
            'sapid' => 'К. рахунок',
            'zdate' => 'Дата показань',
        ];
    }

    public function rules()
    {
        return [

                 [['id','note','nazv_res','ls','potrebitel','dates','type_foto',
                     'f1','nazv_sob','operator'],'safe'],
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
            ['zdate', 'safe'],
            ['kol', 'safe'],
        ];
    }

    public function search($params,$sql)
    {
        $query = fotofix::findBySql($sql);
        $query->sql = $sql;

        $dataProvider = new ActiveDataProvider([
            'query' => $query,

        ]);
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }
        return $dataProvider;
    }

    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public static function getDb()
    {
        return Yii::$app->get('db_mysql_site10');
    }

}
