<?php
// Модель для вывода непереданных показаний со
// счетчиков АСКОЕ в САП
namespace app\models;
use Yii;
use yii\base\Model;
use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;
use yii\helpers;

class Err_trans extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'err_trans';
    }

    public function attributeLabels()
    {
             return [
                 'val09' => 'Показання [день],кВт',
                 'val10' => 'Показання [ніч],кВт',
                 'lic' => 'Особовий рахунок',
                 'ownername' => 'Споживач',
                 'date' => 'Дата',
                 'status' => 'Статус',

        ];
    }

    public function rules()
    {
          return [
              [['val09','val10','lic','ownername','date','status'
                 ], 'safe'],
          ];
    }

    public function search($params)
    {
        $query = err_trans::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'err' => SORT_ASC
                ]
            ]

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
        return Yii::$app->get('db_askoe_real');
    }
}

