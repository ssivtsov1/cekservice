<?php
/**
 * Модель для ссылок на документы
 */

namespace app\models;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;


class Docs extends ActiveRecord
{
    public static function tableName()
    {
        return 'docs';
    }    


    public function rules()
    {
        return [
            [['id','id_doc','item_id','file_path','id_request'], 'safe'],
        ];
    }

    public static function getDb()
    {
        return Yii::$app->get('db_dnres');
    }

}
