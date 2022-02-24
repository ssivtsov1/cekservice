<?php
// Передача показаний помимо личного кабинета
namespace app\models;
use Yii;
use yii\base\Model;
use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;

class Send_msg extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'send_msg';
    }

    public function rules()
    {

        return [

            [['lic','email'], 'safe'],
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

