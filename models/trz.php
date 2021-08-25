<?php
// Заявки пользователей
namespace app\models;
use Yii;
use yii\base\Model;
use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;


class Trz extends \yii\db\ActiveRecord
{
   public $kol;
    public $user_name;

    public static function tableName()
    {
        return 'vw_tzr';
    }

    public function attributeLabels()
    {
        return [
            'MODEL' => 'Модель',
            'GOS_NOM' => 'Державний №',
            'cel' => 'Мета виїзду',
            'marshrut' => 'Маршрут',
            'marshrut_km' => 'Відстань, км',
            'note_res' => 'Примітка РЕМ',
            'note' => 'Примітка',
            'trzDdate' => 'Дата заявки',
            'kol' => 'Кількість заявок',
            'name_res_ts' => 'РЕМ',
            'name_pzay' => 'Тип заявки',
            'FIO' => 'Подано',
            'name_res_ts' => 'Погоджено РЕМ',
            'NumbPers' => 'Кільк. людей',
            'name_char' => 'Вид ТЗ',
            'name_gsm_o' => 'Вид палива',
            'tel' => 'Телефон',
            'name_user_res' => "Погоджено",
            'sogl' => "Погодження логіст."
        ];
    }

//    public function getAttributeLabels()
//    {
//        return [
//            0 => 'Модель',
//           1 => 'Державний №',
//            2 => 'Мета виїзду',
//            3 => 'Маршрут',
//            4 => 'Відстань, км',
//            5 => 'Примітка РЕМ',
//            6 => 'Примітка',
//            7 => 'Дата заявки',
//            8 => 'Кількість заявок',
//            9 => 'РЕМ',
//            10 => 'Тип заявки',
//            11 => 'Подано',
//            12 => 'Погоджено',
//            13 => 'Кільк. людей',
//            14 => 'Вид ТЗ',
//            15 => 'Вид палива',
//            16 => 'Телефон',
//            17 => 'Зясовано'
//        ];
//    }


    public function rules()
    {
        date_default_timezone_set('Europe/Kiev');
        return [
            [['model','gos_nom','trzDdate','kol','cel',
                'marshrut','marshrut_km','note_res','kol',
                'tel','name_gsm_o','name_char','NumbPers','name_res_ts',
                'FIO','name_pzay','name_res_ts','note','sogl'], 'safe'],
        ];
    }

     public function search($params,$sql)
    {
        $query = trz::findBySql($sql);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'inn', $this->inn]);
        $query->andFilterWhere(['like', 'schet', $this->schet]);
        

        return $dataProvider;
    }

    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public static function getDb()
    {
        return Yii::$app->get('db_trz');
    }

}

