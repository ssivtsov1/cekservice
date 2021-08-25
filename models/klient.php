<?php
namespace app\models;
use Yii;
use yii\base\Model;
use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;
use yii\helpers;

class Klient extends \yii\db\ActiveRecord
{
    //public $id_adr;
    public $id_res;
    public $id_t;
    public $num_cnt;
    public $date_cnt;
    public $adr_old;
    public $dt_indicat;
//    public $tel;
//    public $email;
//    public $ind;
//    public $plat_nds;
//    public $nazv_res;

         
    public static function tableName()
    {
        return 'spr_client';
    }

    public function attributeLabels()
    {

             return [
                 'id' => 'ID',
                 'dt_indicat' => 'День місяця:',
                 'adr_old' => 'Стара адреса:',
                 'lic_sch' => 'Рахунок:',
                 'edrpou' => 'ЄДРПОУ:',
                 'name_s' => 'Скорочена назва',
                 'name_f' => 'Повна назва:',
                 'addr' => 'Адреса:',
                 'tel' => 'Телефон:',
                 'tel_work' => 'Телефон робочий:',
                 'email' => 'Електронна пошта:',
                 'num_cnt' => '№ договора:',
                 'date_cnt' => 'Дата договора:',
                 'ind' => 'Індекс:',
                 'plat_nds' => 'Платник НДС:',
                 'nazv_res' => 'РЕМ:',
        ];
    }

    public function rules()
    {
          return [
              [['id','tel','lic_sch','edrpou','name_s','name_f','plat_nds','tel_work','id_adr',
                  'email','id_adr','id_res','num_cnt','date_cnt','dt_indicat','adr_old','id_t'], 'safe'],
          ];
     
    }

          

    
    public function getId()
    {
        return $this->getPrimaryKey();
    }


}

