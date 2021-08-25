<?php
// Передача показаний помимо личного кабинета
namespace app\models;
use Yii;
use yii\base\Model;
use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;

class Transitvalue extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'transitvalue';
    }

    public function rules()
    {
        date_default_timezone_set('Europe/Kiev');
        return [

            [['code','dat_ind','value_1','value_21','value_22','value_31',
              'value_32','value_33',], 'safe'],
        ];
    }

    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public static function getDb()
    {
        return Yii::$app->get('db_dn');
    }

}

