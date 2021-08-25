<?php
/*Ввод основных данных для рассчета*/

namespace app\models;

use Yii;
use yii\base\Model;

class InputPeriod extends Model
{
    public $date1;               // Дата нач
    public $date2;              // Дата конец
    public $nomer;              // № авто

    public function attributeLabels()
    {
        return [
            'date1' => 'Період з ',
            'date2' => 'Період по',
            'nomer' => '№ авто',
        ];
    }

    public function rules()
    {
        return [
            ['date1', 'required'],
            ['date2', 'required'],
            ['nomer', 'safe'],
        ];
    }

}
