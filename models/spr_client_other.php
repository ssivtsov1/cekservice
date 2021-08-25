<?php
/**
 Справочник разных данных потребителя
 */
namespace app\models;

use Yii;
use yii\base\Model;
use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;


class Spr_client_other extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'clm_statecl_tbl';
    }


    public function rules()
    {
        return [
            [['id_client','doc_dat','phone','e_mail',
                'flag_budjet','dt_start','dt_indicat'], 'safe'],
            ];
    }


    
}


