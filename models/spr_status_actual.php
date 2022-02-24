<?php
// Справочник событий (фотофиксация счетчиков)
namespace app\models;

use Yii;
use yii\base\Model;
use yii\behaviors\TimestampBehavior;


class Spr_status_actual extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'spr_status';
    }

    public function attributeLabels()
    {
        return [
            'item' => '№',
            'nazv' => 'Назва',
        ];
    }

    public function rules()
    {
        return [

                 [['item','nazv'],'safe'],
           
        ];
    }

    public function getId()
    {
        return $this->getPrimaryKey();
    }


    public static function getDb()
    {
        return Yii::$app->get('db_dnres');
    }

}
