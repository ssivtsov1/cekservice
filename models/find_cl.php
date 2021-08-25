<?php
// Поиск потребителей
namespace app\models;

use Yii;
use yii\base\Model;

class Find_cl extends Model
{
    public $name_cl;
    public $short_cl;
    public $id_client;
    public $eerm;
    public $name;
    public $koef_tr;
    public $hour_month;
    public $type_energy;
    public $code_tu;
    public $power;
    public $name_area;
    public $code_area;
    public $sub;
    public $sub_cl;
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
    public $tu;
    public $lic_sch;
    public $edrpou;
    public $adr_old;
    public $num_cnt;
    public $date_cnt;
    public $tel;
    public $area;
    public $eis;
    public $zpower;
    public $zeerm;
    public $zhour_month;
    public $zvalue_act;
    public $zvalue_react;
    public $zvalue_gen;
    public $zsub;
    public $zarea;
    public $zkoef_tr;
    public $ztu;

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'eis' => 'EIS код',
            'id_client' => 'Код споживача',
            'name_cl' => 'Повна назва споживача',
            'short_cl' => 'Коротка назва',
            'lic_sch' => 'Особовий рах.',
            'edrpou' => 'ЄДРПОУ',
            'adr_old' => 'Адреса',
            'num_cnt' => '№ договору',
            'date_cnt' => 'Дата договору',
            'tel' => 'Телефон',
            'name' => 'Назва точки',
            'code_tu' => 'Код точки',
            'code_eqp' => 'Код точки',
            'n_cnt' => '№ лічильника',
            'name_area' => 'Назва площадки',
            'area' => 'Площадки',
            'tu' => 'Точки обл.',
            'code_area' => 'Код площадки',
            'koef_tr' => 'Коеф трансф.',
            'client' => 'Споживач',
            'eerm' => 'ЕЕРМ',
            'hour_month' => 'Години роботи',
            're' => 'Наявність лічильнка реакт. енергії',
            'type_energy' => 'Вид спожив.',
            'power' => 'Потужність',
            'sub' => 'Суб.кільк.',
            'sub_cl' => 'Субспоживач',
            'num_eqp' => '№ ліч.',
            'zones' => 'Зона',
            'carry' => 'Розр.',
            'type' => 'Тип ліч.',
            'k_tr' => 'Коеф. трансф.',
            'value_act' => 'Спож.(актив)',
            'value_react' => 'Спож.(реактив)',
            'value_gen' => 'Спож.(генер.)',
            'zpower' => '',
            'zeerm' => '',
            'zsub' => '',
            'zhour_month' => '',
            'zvalue_act' => '',
            'zvalue_react' => '',
            'zvalue_gen' => '',
            'zarea' => '',
            'zkoef_tr' => '',
            'ztu' => '',
        ];
    }

    public function rules()
    {
        return [
            [['name','code_eqp','koef_tr','code_tu','id_client','type_eqp','koef_tr',
                'client','eerm','hour_month','type_energy','adr_old','tel','area','n_cnt',
                'power','name_area','code_area','sub','sub_cl','edrpou','num_cnt','date_cnt',
                'psub_cl','level','code_cnt','type','num_eqp','zones','carry','eis','tu',
                'value_act','value_react','value_gen','id_client','short_cl','name_cl',
                'value_diff_act','value_diff_react','value_diff_gen','lic_sch','zhour_month',
                'value_prev_act','value_prev_react','value_prev_gen','zpower','zeerm','re',
                'zvalue_act','zvalue_react','zvalue_gen','zsub','zarea','zkoef_tr','ztu'], 'safe'],
            [['eerm'], 'number'],
        ];
    }
}


