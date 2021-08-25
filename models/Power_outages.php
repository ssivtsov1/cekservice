<?php

namespace app\models;

use yii\base\Model;

//use yii\web\Power_outages;


class Power_outages extends Model
{
    public $type;
    public $begin_date;
    public $end_date;
    public $pidrozdil;


    public function rules()
    {
        return [
            [['type',  'begin_date', 'end_date', 'pidrozdil'], 'safe'],
            [['end_date'], 'default', 'value' => function ($model, $attribute) {
                return date('Y-m-d');
            }],

        ];
    }
}