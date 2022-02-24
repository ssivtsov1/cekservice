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

class Actual extends \yii\db\ActiveRecord
{
    public $doc1;
    public $doc2;
    public $doc3;
    public $doc4;

    public static function tableName()
    {
        return 'request';
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
            'doc1' => 'Індивідуальний податковий номер',
            'doc2' => "Паспорт",
            'doc3' => 'Право власності',
            'doc4' => 'Заява на приєднання',
        ];
    }

    public function rules()
    {
        return [
            [['id_res','inn','res','fio','adres','email','tel','doc1','id_request',
                'doc2','doc3','doc4','id_unique','status','date'], 'safe'],
            [['res','fio','id_res','doc1','doc2','adres'],'required','message'=>'Поле обов’язкове'],
            [['doc1'],'file','skipOnEmpty' => true,'extensions'=> ['jpg', 'jpeg', 'png', 'pdf']],
            [['doc2'],'file','skipOnEmpty' => true,'extensions'=> ['jpg', 'jpeg', 'png', 'pdf']],
            [['doc3'],'file','skipOnEmpty' => true,'extensions'=> ['jpg', 'jpeg', 'png', 'pdf']],
            [['doc4'],'file','skipOnEmpty' => true,'extensions'=> ['jpg', 'jpeg', 'png', 'pdf']],
        ];
    }

    public function upload($d,$rand)
    {
//         if($this->validate()){
        $n=substr($d,3);
        $path = "store/".$n.'_'.$rand.'-'.$this->$d->basename.'.'.$this->$d->extension;
        $this->$d->saveas($path);
        //$this->photo = $path;
        //$this->attachImage($path);
        //@unlink($path);
        return true;
//        }
//        else
//            return false;
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

