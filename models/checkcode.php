<?php

namespace app\models;

use yii\base\Model;

//use yii\web\Power_outages;


class Checkcode extends Model
{
    public $code;
    public $src;

    public function __construct($i,$config=[])
    {
        $this->src = $i;
//        parent::__construct($config);

    }

    public function rules()
    {
        return [
            // ...
            ['code', 'in','range'=>range($this->src,$this->src),'message' => "Введіть правильний код !"],
            [['code','src'], 'safe'],
        ];
    }


}




