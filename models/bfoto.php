<?php
// Основное хранилище данных (фотофиксация счетчиков)
namespace app\models;

use Yii;
use yii\base\Model;
use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;

class Bfoto extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'bfoto';
    }


    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public static function getDb()
    {
        return Yii::$app->get('db_mysql_site10');
    }

}
