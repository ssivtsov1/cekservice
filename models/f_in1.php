<?php
namespace app\models;

use Yii;
use yii\base\Model;
use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;


class F_in1 extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'cek_gfind';
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID'

        ];
    }

    public function rules()
    {
        return [
            [['id','rem','tel','town','house','street','korp','uid'], 'safe'],
        ];
    }

    public function search($params,$sql)
    {
        $query = f_in1::findBySql($sql);
        $query->sql = $sql;

        $dataProvider = new ActiveDataProvider([
            'query' => $query,

        ]);
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }
        return $dataProvider;
    }



    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public static function getDb()
    {
        return Yii::$app->get('db_in');
    }



}
