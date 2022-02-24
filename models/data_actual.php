<?php
/**
 * Модель для передачи данных для актуализации.
 */
namespace app\models;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;

class Data_actual extends Model
{
    public $tel;    // Телефон
    public $res;   // № РЭСа
    public $fio;   // № ФИО
    public $adres; // Адрес
    public $email; // Email

    public function attributeLabels()
    {
        return [
            'tel' => 'Телефон:',
            'res' => 'РЕМ:',
            'fio'=> 'П.І.Б. :',
            'email'=> 'Електронна пошта:',
             'adres'=> 'Адреса:'
        ];
    }

    public function rules()
    {
        return [
            [['tel', 'res','fio','email','adres'], 'safe'],
            [['res','fio'], 'required','message' => 'Поле обов’язкове'],
        ];
    }
}
