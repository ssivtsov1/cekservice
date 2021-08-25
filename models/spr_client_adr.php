<?php
/**
 Справочник адресов
 */
namespace app\models;

use Yii;
use yii\base\Model;
use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;


class Spr_client_adr extends Model
{
    public $town;
    public $id_street;
    public $id_t;
    public $id;
    public $street;
    public $house;
    public $korp;


    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'house' => 'Будинок',
            'korp' => 'Корпус',
            'id_t' => '',
            'id_street' => '',
            'town' => 'Населений пункт',
            'street' => 'Вулиця',
        ];
    }

    public function rules()
    {
        return [
            [['id','house','korp','street',
                'id_t','town','id_street'], 'safe'],
            [['town'],'required','message'=>'Поле обов’язкове'],
             //Условная валидация поля house

//                ['house', 'required', 'when' => function($model) {
//                    return (strlen($model->street)==0) ;},
//                    'whenClient' => "function (attribute, value) {
//                    return strlen($('#spr_client_adr-street').val()) == 0;
//                     }"]

        ];
    }


}


