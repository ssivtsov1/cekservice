<?php
/*Справочник областей
 */
namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;

class Spr_area_type_energy extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'spr_area_type_eqp';
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Вид споживання',
        ];
    }

    public function rules()
    {
        return [
            [['id','type'], 'safe'],
        ];
    }

    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public static function getDb()
    {
        return Yii::$app->get('db');
    }

}

