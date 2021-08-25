<?php
// Данные с колл-центра
namespace app\models;

use Yii;
use yii\base\Model;
use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;

class Data_cc extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'accounts';
    }


    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public static function getDb()
    {
        return Yii::$app->get('db_pg_call_center');
    }

}
