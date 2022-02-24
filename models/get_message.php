<?php

namespace app\models;

use yii\base\Model;

//use yii\web\Power_outages;


class Get_message extends Model
{
    public $email;
    public $lic;

    public function rules()
    {
        return [
            [['email'], 'required'],
            [['email'], 'email'],
            [['lic'], 'safe'],

        ];
    }
}