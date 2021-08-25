<?php
// Площадки
namespace app\models;

use Yii;
use yii\base\Model;
use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;

class Indic extends \yii\db\ActiveRecord
{
    public $client;
    public $ktr;
    public $eerm;
    public $name;
    public $koef_tr;
    public $hour_month;
    public $zones;
   // public $code_tu;
    public $carry;
    public $num_eqp;
    public $type;
    public $type_eqp;
    public $vid;
    public $value_prev;
    public $re;
    public $gen;
    public $ident;
    public $cod_area;


    public static function tableName()
    {
        return 'legal_indic';
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'value' => 'Показання',
            'value_diff' => 'Різниця',
            'value_prev' => 'Попередні показники',
            'name' => 'Лічильник',
            'num_eqp' => '№ ліч.',
            'koef_tr' => 'Коеф трансф.',
            'ktr' => 'Коеф трансф.',
            'zones' => 'Зона',
            'carry' => 'Розр.',
            'hour_month' => 'Години роботи',
            'type' => 'Тип ліч.',
            'date' => 'Дата',
            'vid' => 'Вид енергії',
            'id_client' => 'Код споживача',
            're' => 'Наявність лічильника реакт. енергії',
        ];
    }

    public function rules()
    {
        return [
            ['date','required'],

            [['name','code_eqp','koef_tr','code_tu','id_client','vid','vid_e',
                'client','eerm','hour_month','value','num_eqp','value','value_prev',
                'value_diff','date','carry','zones','type','type_eqp','ktr',
                're','gen','cod_area','code_area','ident'], 'safe'],

        ];
    }

    public function search($params,$sql)
    {
        $query = indic::findBySql($sql);
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
        return Yii::$app->get('db');
    }

}


