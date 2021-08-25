<?php
/**
 * Created by PhpStorm.
 * User: ssivtsov
 * Date: 21.06.2017
 * Time: 9:49
 */
namespace app\models;

use Yii;
use yii\base\Model;
use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;


class Client extends \yii\db\ActiveRecord
{
    public $id_t;
    public $search_town;
    public $search_street;
    //public $id_town;
    public $id_street;
    public $adr_street;
    public $adr_flat;

    public static function tableName()
    {
        return 'vw_client';
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_t' => '',
            'lic_sch' => 'Особовий рахунок:',
            'edrpou' => 'ЄДРПОУ:',
            'name_s' => 'Скорочена назва',
            'name_f' => 'Повна назва:',
            'add_name' => 'ПІБ для додатку:',
            'addr' => 'Адреса:',
            'tel' => 'Телефон:',
            'tel_work' => 'Телефон робочий:',
            'email' => 'Електронна пошта:',
            'ind' => 'Індекс:',
            'num_cnt' => '№ договору:',
            'date_cnt' => 'Дата договору:',
            'plat_nds' => 'Платник НДС:',
            'obl' => 'Область:',
            'district' => 'Район:',
            'town' => 'Населений пункт:',
            'street' => 'Вулиця:',
            'house' => 'Будинок:',
            'korp' => 'Корпус:',
            'flat' => 'Квартира:',
            'nazv_res' => 'РЕМ:',
            'flag_budjet' => 'Бюджет:',
            'dt_indicat' => 'День місяця:',
            'dt_start' => 'День початку періоду:',
            'adr_old' => 'Стара адреса:',

            'adr_town' => 'Населений пункт:',
            'adr_street' => 'Вулиця:',
            'adr_flat' => 'Будинок та квартира:',
            'search_town' => 'Населений пункт:',
            'search_street' => 'Вулиця:',
            'id_street' => '',
            'id_client' => 'Код спож.',

        ];
    }


    public function rules()
    {
        return [
            [['id','tel','lic_sch','edrpou','name_s','name_f','addr','plat_nds','tel_work','adr_old',
                'email','ind','obl','district','town','street','house','korp','add_name',
                'flat','nazv_res','id_t','search_town','flag_budjet','date_cnt','id_client',
                'search_street','id_town','id_street','dt_indicat','dt_start'], 'safe'],
                ];
    }

     public function search($params)
    {
        $query = client::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['lic_sch' => SORT_ASC]]
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'name_s', $this->name_s]);
        $query->andFilterWhere(['like', 'adr_old', $this->adr_old]);
        $query->andFilterWhere(['like', 'addr', $this->addr]);
        $query->andFilterWhere(['like', 'tel', $this->tel]);
        $query->andFilterWhere(['like', 'tel_work', $this->tel_work]);
        $query->andFilterWhere(['like', 'edrpou', $this->edrpou]);
        $query->andFilterWhere(['like', 'name_f', $this->name_f]);
        $query->andFilterWhere(['=', 'plat_nds', $this->plat_nds]);
        $query->andFilterWhere(['=', 'lic_sch', $this->lic_sch]);
        $query->andFilterWhere(['=', 'nazv_res', $this->nazv_res]);
        $query->andFilterWhere(['=', 'id_client', $this->id_client]);
        return $dataProvider;
    }
    
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public static function getDb()
    {
        if (Yii::$app->session->has('res')) {
            $role=Yii::$app->session->get('res');

        }

        switch ($role) {
            case 1:
                return Yii::$app->get('db');
            case 2:
                return Yii::$app->get('db_dn');
            case 3:
                return Yii::$app->get('db');
            case 4:
                return Yii::$app->get('db_krg');
            case 5:
                return Yii::$app->get('db_pv');
            case 6:
                return Yii::$app->get('db_vg');
            case 7:
                return Yii::$app->get('db_zv');
            case 8:
                return Yii::$app->get('db_in');
            case 9:
                return Yii::$app->get('db_ap');
        }


    }


}

