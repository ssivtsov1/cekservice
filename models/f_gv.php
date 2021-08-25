<?php
namespace app\models;

use Yii;
use yii\base\Model;
use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;


class F_gv extends \yii\db\ActiveRecord
{
    public $res;
    public $tel;
    public $town;
    public $street;
    public $house;
    public $korp;

    public static function tableName()
    {
        return 'clm_paccnt_tbl';
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
            [['id','res','tel','town','house','street','korp'], 'safe'],
        ];
    }

    public function search($params,$sql)
    {
        $query = f_gv::findBySql($sql);
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
        return Yii::$app->get('db_gv');
    }



}
