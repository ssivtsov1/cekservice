<?php
/**
 * Модель для закачки данных со счетчиков АСКОЕ в САП.
 */
namespace app\models;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;

class Data_askoe extends Model
{
    public $res;     // Участок (РЭС)
    public $code;   // Лицевой счет

    public function attributeLabels()
    {
        return [
            'res' => 'РЕМ:',
            'code' => 'Особовий рахунок:',
        ];
    }

    public function rules()
    {
        return [
            [['res', 'code'], 'safe'],
            [ ['res'], 'integer', 'min' => 1,'message' => 'Виберіть РЕМ']
        ];
    }
}
