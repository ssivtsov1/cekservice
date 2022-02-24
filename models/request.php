<?php
/**
 * Используется для сохранения документов для актуализации
 *
 */
namespace app\models;

use Yii;
use yii\base\Model;
use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;

class Request extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'vw_request';
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'inn' => 'ІНН:',
            'tel' => 'Телефон:',
            'id_res' => 'РЕМ:',
            'fio'=> 'П.І.Б. :',
            'email'=> 'Електронна пошта:',
            'adres'=> 'Адреса:',
            'nazv'=> 'РЕМ:',
            'status'=> 'Статус:',
            'nazv_status'=> 'Статус:',
            'fdate'=> 'Дата:',
        ];
    }

    public function rules()
    {
        return [
            [['id_res','inn','res','fio','adres','email','tel','doc1',
                'doc2','doc3','doc4','id_unique','status',
                'nazv','date','nazv_status','fdate'], 'safe'],
        ];
    }

    public function search($params,$role)
    {
        switch($role) {
            case 3: // Полный доступ
                $query = request::find();
                break;
            default:
                $query = request::find()->
                where('id_res=:id_res',[':id_res' => $role-10]);
          }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['id' => SORT_ASC]]
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }
        $query->andFilterWhere(['like', 'fio', $this->fio]);
        return $dataProvider;
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

