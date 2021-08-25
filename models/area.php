<?php
// Площадки
namespace app\models;

use Yii;
use yii\base\Model;
use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;

class Area extends \yii\db\ActiveRecord
{
    public $client;
    public $eerm;
    public $name;
    public $koef_tr;
    public $hour_month;
    public $type_energy;
    public $code_tu;
    public $power;
    public $id_client;
    public $name_area;
    public $code_area;
    public $sub;
    public $sub_cl;
    public $psub_cl;
    public $level;
    public $code_cnt;
    public $value_act;
    public $value_react;
    public $value_gen;
    public $value_diff_gen;
    public $value_diff_react;
    public $value_diff_act;
    public $value_prev_gen;
    public $value_prev_react;
    public $value_prev_act;
    public $type;
    public $carry;
    public $num_eqp;
    public $zones;
    public $re;
    public $lic_sch;
    public $edrpou;
    public $short_cl;
    public $name_cl;
    public $name_tp;
    public $name_s;
    public $name_f;
    public $num_cnt;
    public $date_cnt;
    public $adr_old;
    public $addr;
    public $tel;
    public $tel_work;
    public $dt_indicat;
    public $email;
    public $flag_budjet;
    public $eis;
    public $kol;

    public static function tableName()
    {
        return 'area_prop';
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Назва точки',
            'code_tu' => 'Код точки',
            'code_eqp' => 'Код точки',
            'type_eqp' => 'Вид спожив.',
            'name_area' => 'Назва площадки',
            'code_area' => 'Код площадки',
            'koef_tr' => 'Коеф трансф.',
            'client' => 'Споживач',
            'eerm' => 'ЕЕРМ',
            'hour_month' => 'Години роботи',
            'type_energy' => 'Вид спожив.',
            'power' => 'Потужність',
            'sub' => 'Субспоживач',
            'sub_cl' => 'Субспоживач',
            'psub_cl' => 'Предок субспоживача',
            'level' => 'Рівень входження',
            'num_eqp' => '№ ліч.',
            'zones' => 'Зона',
            'carry' => 'Розр.',
            'type' => 'Тип ліч.',
            'eis' => 'EIS код',
            'id_client' => 'Код споживача',
            'name_f' => 'Повна назва споживача',
            'name_s' => 'Коротка назва',
            'name_tp' => 'ТП',
            'lic_sch' => 'Особовий рах.',
            'edrpou' => 'ЄДРПОУ',
            'adr_old' => 'Адреса',
            'num_cnt' => '№ договору',
            'date_cnt' => 'Дата договору',
            'tel' => 'Телефон',
            'flag_budjet' => 'Бюджет:',
            'dt_indicat' => 'День місяця:',
            'tel_work' => 'Телефон робочий:',
            'addr' => 'Адреса:',

        ];
    }

    public function rules()
    {
        return [

            [['name','code_eqp','koef_tr','code_tu','id_client','type_eqp',
                'client','eerm','hour_month','type_energy',
                'power','name_area','code_area','sub','sub_cl',
                'psub_cl','level','code_cnt','type','num_eqp','zones','carry',
                'value_act','value_react','value_gen','name_tp',
                'value_diff_act','value_diff_react','value_diff_gen',
                'value_prev_act','value_prev_react','value_prev_gen'], 'safe'],
        ];
    }

    public function search($params,$sql)
    {
        $query = area::findBySql($sql);
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


