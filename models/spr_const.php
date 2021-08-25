<?php
// Данные по стоимости подключения
namespace app\models;

use Yii;
use yii\base\Model;
use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;


class Spr_const extends \yii\db\ActiveRecord
{
    public $cost;
    
    public static function tableName()
    {
        return 'spr_const';
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Назва',
            'name_s' => 'Коротка назва',
            'value' => 'Значення',

            
        ];
    }

    public function rules()
    {
        return [
            [['id', 'name','name_s','value'], 'safe'],
        ];
    }
    
     //   Метод, необходимый для поиска
    public function search($params)
    {
        $query = spr_const::find()->orderBy('id');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,'pagination' => [
                'pageSize' => 20,],
        ]);
        if (!($this->load($params) && $this->validate())) {

            return $dataProvider;
        }

       // $query->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
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
