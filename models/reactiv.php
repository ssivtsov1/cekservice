<?php
// Рассчет реактива
namespace app\models;

use Yii;
use yii\base\Model;
use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;

class Reactiv extends \yii\db\ActiveRecord
{
    public $client;
    public $ktr;
    public $eerm;
    public $name;
    public $koef_tr;
    public $hour_month;
    public $pwr;
    public $vid_e;
    public $code_tu;
    public $code_ptu;
    public $potr_act;
    public $potr_react;
    public $potr_act_src;
    public $potr_react_src;
    public $potr_gen;
    public $tg_r;
    public $tg_rp;
    public $ps;
    public $pg;
    public $p1;
    public $p2;
    public $p3;
    public $value;
    public $id_client;
    public $id_pclient;
    public $date;
    public $name_kl;
    public $name_cnt;
    public $name_area;
    public $itog;
    public $name_tp;

    public static function tableName()
    {
        return 'area_prop';
    }


    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'potr_act' => 'Споживання актив',
            'potr_react' => 'Споживання реактив',
            'potr_gen' => 'Споживання генер.',
            'name' => 'Лічильник точки обліку',
            'name_cnt' => 'Лічильник точки обліку',
            'tg_r' => 'tg розрах.',
            'tg_rp' => 'tg застос.',
            'ktr' => 'Коеф трансф.',
            'hour_month' => 'Години роботи',
            'id_client' => 'Код споживача',
            'code_tu' => 'Код точки',
            'name_kl' => 'Споживач',
            'name_tp' => 'ТП',
            'name_area' => 'Площадка',
            'pwr' => 'Потужність,кВт',
        ];
    }

    public function rules()
    {
        return [

            [['name','potr_act','koef_tr','code_tu','id_client','potr_react','potr_gen',
                'tg_r','eerm','hour_month','tg_rp','hour_month','ktr','vid_e','date',
                'id_pclient','potr_react_src','potr_act_src','code_ptu','value',
                'name_kl','name_cnt','itog','name_tp'], 'safe'],

        ];
    }

    public function calc($params,$sql)
    {
        $query = reactiv::findBySql($sql);
        $query->sql = $sql;

        $dataProvider = new ActiveDataProvider([
            'query' => $query,

        ]);
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }
        return $dataProvider;
    }

    public function calc_sub($params,$sql)
    {
        $query = reactiv::findBySql($sql);
        $query->sql = $sql;

        $dataProvider = new ActiveDataProvider([
            'query' => $query,

        ]);
        if (!($this->load($params) && $this->validate())) {
            $mas = $dataProvider->getModels();
            //debug($mas);
            $k=count($mas);
            for($i=0;$i<$k;$i++){
                $p_act = $mas[$i]['potr_act'];
                $p_react = $mas[$i]['potr_react'];
                $c_code_ptu = $mas[$i]['code_ptu'];
                $c_code_tu = $mas[$i]['code_tu'];
                $pcl = $mas[$i]['id_pclient'];
                for($j=0;$j<$k;$j++){
                    if($i==$j) continue;
                    if($mas[$j]['id_client']==$pcl && $mas[$j]['code_tu']==$c_code_ptu){
                        $mas[$j]['potr_act']=$mas[$j]['potr_act_src']-$p_act;
                        $mas[$j]['potr_react']=$mas[$j]['potr_react_src']-$p_react;
                    }

                }
            }
            debug($mas);
            return $mas;
        }
        //return $dataProvider;
    }


    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public static function getDb()
    {
        return Yii::$app->get('db');
    }

}


