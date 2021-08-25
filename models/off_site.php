<?php
// Заявки пользователей
namespace app\models;

use Yii;
use yii\base\Model;
use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;


class Off_site extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'cc_crash';
    }

//    public function rules()
//    {
//
//        return [
//            [['id','charg','charg1','maktx'], 'safe'],
//        ];
//    }

    public static function getDb()
    {
        return Yii::$app->get('db_mysql_site');
    }

}

