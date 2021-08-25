<?php
// Справочник РЭСов
namespace app\models;

use Yii;
use yii\base\Model;
use yii\behaviors\TimestampBehavior;


class Spr_res1 extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'spr_res';
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'names' => 'Назва РЕМ',
        ];
    }

    public function rules()
    {
        return [

                 [['id','names'],'safe'],
           
        ];
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
