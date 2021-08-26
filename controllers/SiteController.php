<?php

namespace app\controllers;

use app\models\Calc;
use app\models\Createproposal;
use app\models\Diary;
use app\models\Edit_photo;
use app\models\Plan1;
use app\models\photo_task;
use app\models\spr_foto;
use app\models\bsob;
use SQLite3;
use app\models\Image;
use app\models\phones_sap_search;
use app\models\Power_outages;
use app\models\off_site;
use app\models\PoweroutagesForm;
use app\models\View_photo;
use app\models\data_cc;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\helpers\Url;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use app\models\ContactForm;
use app\models\spr_towns;
use app\models\transitvalue;
use app\models\requestsearch;
use app\models\tofile;
use app\models\forExcel;
use app\models\info;
use app\models\ccon_soap;
use app\models\inputperiod;
use app\models\data_person;
use app\models\trz;
use app\models\err_trans;
use app\models\data_askoe;
use app\models\data_fotofix;    // Для поиска фото счетчиков
use app\models\fotofix;    // Для поиска фото счетчиков
use app\models\bfoto;
use app\models\docs;
use app\models\User;
use app\models\spr_client_adr;
use app\models\f_dn;
use app\models\f_dn1;
use app\models\f_zv1;
use app\models\f_vg1;
use app\models\f_ap1;
use app\models\f_in1;
use app\models\f_pv1;
use app\models\f_gv1;
use app\models\f_krg1;
use app\models\f_zv;
use app\models\f_vg;
use app\models\f_pv;
use app\models\f_gv;
use app\models\f_krg;
use app\models\f_in;
use app\models\f_ap;
use yii\web\UploadedFile;

class SiteController extends Controller
{  /**
 * 
 * @return type
 *
 */

    //public $defaultAction = 'index';
    public $face=0;

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        if ($this->action->id == 'abnlegal')
        {
           // $this->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);

    }

    
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    //  Происходит при запуске сайта
    public function actionIndex()
    {
        $model = new Spr_client_adr();
        if ($model->load(Yii::$app->request->post()))
        {
            return $this->redirect([ 'cekfind','town' => $model->town,'street' => $model->street,
                'house' => $model->house,'korp' => $model->korp]);
        }
        else {

            return $this->render('iscek', [
                'model' => $model
            ]);
        }

    }

    //  Происходит при переключении версии сайта (Обычная и для слабовидящих)
    public function actionSwitch()
    {
        if (Yii::$app->session->has('switch')) {
            if(Yii::$app->session->get('switch')==1) 
                Yii::$app->session->set('switch', 0);
            else
                Yii::$app->session->set('switch', 1);
        }
        else  
        {
            $session = Yii::$app->session;
            $session->open();
            $session->set('switch', 1);
        }
        
        //return $this->goBack();
        if (\Yii::$app->request->referrer) {
            return $this->redirect(Yii::$app->request->referrer);
         } 
         else 
             {
            return $this->goBack();
         }
              
    }
// Поиск принадлежности к сети ЦЕК (происходит при нажатии на кн. OK)
    public function actionCekfind($town,$street,$house,$korp)
    {
        $b=100;
        $k1=mb_strtolower($korp,'UTF-8');
        $k2=mb_strtoupper($korp,'UTF-8');
        $a = mb_strpos($town, '.',0,'UTF-8');
        if (mb_substr($town,0,3,'UTF-8')=='смт') $a=3;
        $b = mb_strpos($town, ',',0,'UTF-8');
        $y=mb_strlen($town,'UTF-8');
        if($b>0)
            $town=trim(mb_substr($town,$a+1,$b-$a-1,'UTF-8'));
        else
            $town=trim(mb_substr($town,$a+1,$y-($a+1),'UTF-8'));


        $street=trim($street);
        $a = mb_strpos($street, '.',0,'UTF-8');
        $y=mb_strlen($street,'UTF-8');

        if($a>0)
            $street=trim(mb_substr($street,$a+1,$y-($a+1),'UTF-8'));

        $flag=0;
        $jj=0;
        $fnd=0;


        for($i=1;$i<9;$i++) {
            switch ($i) {
                case 1:

                    if(!is_null($house) and !empty($house)) {
                        if (is_null($korp) || empty($korp))
                            $sql = "select a.id,'Дніпровські РЕМ' as res,b.tel as tel,
                      vw.town,vw.street,vw.house,vw.korp,vw.flat from clm_paccnt_tbl a
                      left join vw_address vw on vw.id=a.id
                       inner join a_tel_tbl b on b.id_res=".f_accord($i).
                                " where trim(town)=$$$town$$ and trim(street)=$$$street$$
                        and trim(house)='$house' and korp is null";
                        else
                            $sql = " select a.id,'Дніпровські РЕМ' as res,b.tel as tel,
                  vw.town,vw.street,vw.house,vw.korp,vw.flat from clm_paccnt_tbl a
                  left join vw_address vw on vw.id=a.id
                  inner join a_tel_tbl b on b.id_res=".f_accord($i).
                                " where trim(town)=$$$town$$ and trim(street)=$$$street$$
                  and trim(house)='$house' and korp is not null and 
                  (trim(korp)=trim('$k1') or trim(korp)=trim('$k2'))";

                    }
                    else
                    {
                        if(!is_null($street) and !empty($street))
                            $sql = "select distinct 'Дніпровські РЕМ'::character varying as res,b.tel as tel,
                      vw.town,vw.street,vw.house,vw.korp,regexp_replace(house, '[^0-9]', '', 'g')::int as ihouse
                      from clm_paccnt_tbl a
                      left join vw_address vw on vw.id=a.id
                      inner join a_tel_tbl b on b.id_res=".f_accord($i).
                                " where trim(town)=$$$town$$ and trim(street)=$$$street$$
                      order by 7,6 Desc";
                        else
                            $sql = "select distinct 'Дніпровські РЕМ'::character varying as res,b.tel as tel,
                          vw.town,vw.street,vw.house,vw.korp,regexp_replace(house, '[^0-9]', '', 'g')::int as ihouse
                          from clm_paccnt_tbl a
                          left join vw_address vw on vw.id=a.id
                          inner join a_tel_tbl b on b.id_res=".f_accord($i).
                                " where trim(town)=$$$town$$
                          order by 4,7,6 Desc";
                        $flag=2;
                    }

                    $model = f_dn::findBySql($sql)->all();


                    if($flag==2) {
                        if (isset($model[0]->res)) {
                            $k = count($model);
                            for($j=0;$j<$k;$j++){

                                $data[$jj]['res']=$model[$j]['res'];
                                $data[$jj]['tel']=$model[$j]['tel'];
                                $data[$jj]['town']=$model[$j]['town'];
                                $data[$jj]['street']=$model[$j]['street'];
                                $data[$jj]['house']=$model[$j]['house'];
                                $data[$jj]['korp']=$model[$j]['korp'];
                                $jj++;
                            }
                            $fnd=1;
                            continue 2;
                        }
                        else
                        {
                            $flag=0;
                            $is = '';
                            break;
                        }
                    }

                    if (isset($model[0]->res)) {
                        $is = $model[0]->res;
                        $flag=1;
                        break;
                    }
                    else
                        $is = '';
                    break;

                case 2:
                    if(!is_null($house) and !empty($house)) {
                        if (is_null($korp) || empty($korp))
                            $sql = "select a.id,'Жовтоводські РЕМ' as res,b.tel as tel,
                      vw.town,vw.street,vw.house,vw.korp,vw.flat from clm_paccnt_tbl a
                      left join vw_address vw on vw.id=a.id
                       inner join a_tel_tbl b on b.id_res=".f_accord($i).
                                " where trim(town)=$$$town$$ and trim(street)=$$$street$$
                        and trim(house)='$house' and korp is null";
                        else
                            $sql = " select a.id,'Жовтоводські РЕМ' as res,b.tel as tel,
                  vw.town,vw.street,vw.house,vw.korp,vw.flat from clm_paccnt_tbl a
                  left join vw_address vw on vw.id=a.id
                  inner join a_tel_tbl b on b.id_res=".f_accord($i).
                                " where trim(town)=$$$town$$ and trim(street)=$$$street$$
                  and trim(house)='$house' and korp is not null and 
                  (trim(korp)=trim('$k1') or trim(korp)=trim('$k2'))";

                    }
                    else
                    {
                        if(!is_null($street) and !empty($street))
                            $sql = "select distinct 'Жовтоводські РЕМ'::character varying as res,b.tel as tel,
                      vw.town,vw.street,vw.house,vw.korp,regexp_replace(house, '[^0-9]', '', 'g')::int as ihouse
                      from clm_paccnt_tbl a
                      left join vw_address vw on vw.id=a.id
                      inner join a_tel_tbl b on b.id_res=".f_accord($i).
                                " where trim(town)=$$$town$$ and trim(street)=$$$street$$
                      order by 7,6 Desc";
                        else
                            $sql = "select distinct 'Жовтоводські РЕМ'::character varying as res,b.tel as tel,
                          vw.town,vw.street,vw.house,vw.korp,regexp_replace(house, '[^0-9]', '', 'g')::int as ihouse
                          from clm_paccnt_tbl a
                          left join vw_address vw on vw.id=a.id
                          inner join a_tel_tbl b on b.id_res=".f_accord($i).
                                " where trim(town)=$$$town$$
                          order by 4,7,6 Desc";
                        $flag=2;
                    }

                    $model = f_zv::findBySql($sql)->all();
                    if($flag==2) {
                        if (isset($model[0]->res)) {
                            $k = count($model);
                            for($j=0;$j<$k;$j++){

                                $data[$jj]['res']=$model[$j]['res'];
                                $data[$jj]['tel']=$model[$j]['tel'];
                                $data[$jj]['town']=$model[$j]['town'];
                                $data[$jj]['street']=$model[$j]['street'];
                                $data[$jj]['house']=$model[$j]['house'];
                                $data[$jj]['korp']=$model[$j]['korp'];
                                $jj++;
                            }
                            $fnd=1;
                            continue 2;
                        }
                        else
                        {
                            $flag=0;
                            $is = '';
                            break;
                        }
                    }


                    if (isset($model[0]->res)) {
                        $is = $model[0]->res;
                        $flag=1;
                        break;
                    }
                    else
                        $is = '';
                    break;
                case 3:

                    if(!is_null($house) and !empty($house)) {
                        if (is_null($korp) || empty($korp))
                            $sql = "select a.id,'Вільногірські РЕМ' as res,b.tel as tel,
                      vw.town,vw.street,vw.house,vw.korp,vw.flat from clm_paccnt_tbl a
                      left join vw_address vw on vw.id=a.id
                       inner join a_tel_tbl b on b.id_res=".f_accord($i).
                                " where trim(town)=$$$town$$ and trim(street)=$$$street$$
                        and trim(house)='$house' and korp is null";
                        else
                            $sql = " select a.id,'Вільногірські РЕМ' as res,b.tel as tel,
                  vw.town,vw.street,vw.house,vw.korp,vw.flat from clm_paccnt_tbl a
                  left join vw_address vw on vw.id=a.id
                  inner join a_tel_tbl b on b.id_res=".f_accord($i).
                                " where trim(town)=$$$town$$ and trim(street)=$$$street$$
                  and trim(house)='$house' and korp is not null and 
                  (trim(korp)=trim('$k1') or trim(korp)=trim('$k2'))";

                    }
                    else
                    {
                        if(!is_null($street) and !empty($street))
                            $sql = "select distinct 'Вільногірські РЕМ'::character varying as res,b.tel as tel,
                      vw.town,vw.street,vw.house,vw.korp,regexp_replace(house, '[^0-9]', '', 'g')::int as ihouse
                      from clm_paccnt_tbl a
                      left join vw_address vw on vw.id=a.id
                      inner join a_tel_tbl b on b.id_res=".f_accord($i).
                                " where trim(town)=$$$town$$ and trim(street)=$$$street$$
                      order by 7,6 asc";
                        else
                            $sql = "select distinct 'Вільногірські РЕМ'::character varying as res,b.tel as tel,
                          vw.town,vw.street,vw.house,vw.korp,regexp_replace(house, '[^0-9]', '', 'g')::int as ihouse
                          from clm_paccnt_tbl a
                          left join vw_address vw on vw.id=a.id
                          inner join a_tel_tbl b on b.id_res=".f_accord($i).
                                " where trim(town)=$$$town$$
                          order by 4,7,6 asc";
                        $flag=2;
                    }

                    $model = f_vg::findBySql($sql)->all();
                    if($flag==2) {
                        $searchModel = new f_vg();
                        if (isset($model[0]->res)) {
                            $k = count($model);
                            for($j=0;$j<$k;$j++){

                                $data[$jj]['res']=$model[$j]['res'];
                                $data[$jj]['tel']=$model[$j]['tel'];
                                $data[$jj]['town']=$model[$j]['town'];
                                $data[$jj]['street']=$model[$j]['street'];
                                $data[$jj]['house']=$model[$j]['house'];
                                $data[$jj]['korp']=$model[$j]['korp'];
                                $jj++;
                            }
                            $fnd=1;
                            continue 2;
                        }
                        else
                        {
                            $flag=0;
                            $is = '';
                            break;
                        }
                    }

                    if (isset($model[0]->res)) {
                        $is = $model[0]->res;
                        $flag=1;
                        break;
                    }
                    else
                        $is = '';
                    break;
                case 4:

                    if(!is_null($house) and !empty($house)) {
                        if (is_null($korp) || empty($korp))
                            $sql = "select a.id,'Павлоградські РЕМ' as res,b.tel as tel,
                      vw.town,vw.street,vw.house,vw.korp,vw.flat from clm_paccnt_tbl a
                      left join vw_address vw on vw.id=a.id
                       inner join a_tel_tbl b on b.id_res=".f_accord($i).
                                " where trim(town)=$$$town$$ and trim(street)=$$$street$$
                        and trim(house)='$house' and korp is null";
                        else
                            $sql = " select a.id,'Павлоградські РЕМ' as res,b.tel as tel,
                  vw.town,vw.street,vw.house,vw.korp,vw.flat from clm_paccnt_tbl a
                  left join vw_address vw on vw.id=a.id
                  inner join a_tel_tbl b on b.id_res=".f_accord($i).
                                " where trim(town)=$$$town$$ and trim(street)=$$$street$$
                  and trim(house)='$house' and korp is not null and 
                  (trim(korp)=trim('$k1') or trim(korp)=trim('$k2'))";

                    }
                    else
                    {
                        if(!is_null($street) and !empty($street))
                            $sql = "select distinct 'Павлоградські РЕМ'::character varying as res,b.tel as tel,
                      vw.town,vw.street,vw.house,vw.korp,regexp_replace(house, '[^0-9]', '', 'g')::int as ihouse
                      from clm_paccnt_tbl a
                      left join vw_address vw on vw.id=a.id
                      inner join a_tel_tbl b on b.id_res=".f_accord($i).
                                " where trim(town)=$$$town$$ and trim(street)=$$$street$$
                      order by 7,6 asc";
                        else
                            $sql = "select distinct 'Павлоградські РЕМ'::character varying as res,b.tel as tel,
                          vw.town,vw.street,vw.house,vw.korp,regexp_replace(house, '[^0-9]', '', 'g')::int as ihouse
                          from clm_paccnt_tbl a
                          left join vw_address vw on vw.id=a.id
                          inner join a_tel_tbl b on b.id_res=".f_accord($i).
                                " where trim(town)=$$$town$$
                          order by 4,7,6 asc";
                        $flag=2;
                    }

                    $model = f_pv::findBySql($sql)->all();

                    if($flag==2) {
                        $searchModel = new f_pv();
                        if (isset($model[0]->res)) {
                            $k = count($model);
                            for($j=0;$j<$k;$j++){

                                $data[$jj]['res']=$model[$j]['res'];
                                $data[$jj]['tel']=$model[$j]['tel'];
                                $data[$jj]['town']=$model[$j]['town'];
                                $data[$jj]['street']=$model[$j]['street'];
                                $data[$jj]['house']=$model[$j]['house'];
                                $data[$jj]['korp']=$model[$j]['korp'];
                                $jj++;
                            }
                            $fnd=1;
                            continue 2;
                        }
                        else
                        {
                            $flag=0;
                            $is = '';
                            break;
                        }
                    }

                    if (isset($model[0]->res)) {
                        $is = $model[0]->res;
                        $flag=1;
                        break;
                    }
                    else
                        $is = '';
                    break;
                case 5:

                    if(!is_null($house) and !empty($house)) {
                        if (is_null($korp) || empty($korp))
                            $sql = "select a.id,'Гвардійські РЕМ' as res,b.tel as tel,
                      vw.town,vw.street,vw.house,vw.korp,vw.flat from clm_paccnt_tbl a
                      left join vw_address vw on vw.id=a.id
                       inner join a_tel_tbl b on b.id_res=".f_accord($i).
                                " where trim(town)=$$$town$$ and trim(street)=$$$street$$
                        and trim(house)='$house' and korp is null";
                        else
                            $sql = " select a.id,'Гвардійські РЕМ' as res,b.tel as tel,
                  vw.town,vw.street,vw.house,vw.korp,vw.flat from clm_paccnt_tbl a
                  left join vw_address vw on vw.id=a.id
                  inner join a_tel_tbl b on b.id_res=".f_accord($i).
                                " where trim(town)=$$$town$$ and trim(street)=$$$street$$
                  and trim(house)='$house' and korp is not null and 
                  (trim(korp)=trim('$k1') or trim(korp)=trim('$k2'))";

                    }
                    else
                    {
                        if(!is_null($street) and !empty($street))
                            $sql = "select distinct 'Гвардійські РЕМ'::character varying as res,b.tel as tel,
                      vw.town,vw.street,vw.house,vw.korp,regexp_replace(house, '[^0-9]', '', 'g')::int as ihouse
                      from clm_paccnt_tbl a
                      left join vw_address vw on vw.id=a.id
                      inner join a_tel_tbl b on b.id_res=".f_accord($i).
                                " where trim(town)=$$$town$$ and trim(street)=$$$street$$
                      order by 7,6 asc";
                        else
                            $sql = "select distinct 'Гвардійські РЕМ'::character varying as res,b.tel as tel,
                          vw.town,vw.street,vw.house,vw.korp,regexp_replace(house, '[^0-9]', '', 'g')::int as ihouse
                          from clm_paccnt_tbl a
                          left join vw_address vw on vw.id=a.id
                          inner join a_tel_tbl b on b.id_res=".f_accord($i).
                                " where trim(town)=$$$town$$
                          order by 4,7,6 asc";
                        $flag=2;
                    }


                    $model = f_gv::findBySql($sql)->all();

                    if($flag==2) {
                        $searchModel = new f_gv();
                        if (isset($model[0]->res)) {
                            $k = count($model);
                            for($j=0;$j<$k;$j++){

                                $data[$jj]['res']=$model[$j]['res'];
                                $data[$jj]['tel']=$model[$j]['tel'];
                                $data[$jj]['town']=$model[$j]['town'];
                                $data[$jj]['street']=$model[$j]['street'];
                                $data[$jj]['house']=$model[$j]['house'];
                                $data[$jj]['korp']=$model[$j]['korp'];
                                $jj++;
                            }
                            $fnd=1;
                            continue 2;
                        }
                        else
                        {
                            $flag=0;
                            $is = '';
                            break;
                        }
                    }

                    if (isset($model[0]->res)) {
                        $is = $model[0]->res;
                        $flag=1;
                        break;
                    }
                    else
                        $is = '';
                    break;
                case 6:

                    if(!is_null($house) and !empty($house)) {
                        if (is_null($korp) || empty($korp))
                            $sql = "select a.id,'Криворізькі РЕМ' as res,b.tel as tel,
                      vw.town,vw.street,vw.house,vw.korp,vw.flat from clm_paccnt_tbl a
                      left join vw_address vw on vw.id=a.id
                       inner join a_tel_tbl b on b.id_res=".f_accord($i).
                                " where trim(town)=$$$town$$ and trim(street)=$$$street$$
                        and trim(house)='$house' and korp is null";
                        else
                            $sql = " select a.id,'Криворізькі РЕМ' as res,b.tel as tel,
                  vw.town,vw.street,vw.house,vw.korp,vw.flat from clm_paccnt_tbl a
                  left join vw_address vw on vw.id=a.id
                  inner join a_tel_tbl b on b.id_res=".f_accord($i).
                                " where trim(town)=$$$town$$ and trim(street)=$$$street$$
                  and trim(house)='$house' and korp is not null and 
                  (trim(korp)=trim('$k1') or trim(korp)=trim('$k2'))";

                    }
                    else
                    {
                        if(!is_null($street) and !empty($street))
                            $sql = "select distinct 'Криворізькі РЕМ'::character varying as res,b.tel as tel,
                      vw.town,vw.street,vw.house,vw.korp,regexp_replace(house, '[^0-9]', '', 'g')::int as ihouse
                      from clm_paccnt_tbl a
                      left join vw_address vw on vw.id=a.id
                      inner join a_tel_tbl b on b.id_res=".f_accord($i).
                                " where trim(town)=$$$town$$ and trim(street)=$$$street$$
                      order by 7,6 asc";
                        else
                            $sql = "select distinct 'Криворізькі РЕМ'::character varying as res,b.tel as tel,
                          vw.town,vw.street,vw.house,vw.korp,regexp_replace(house, '[^0-9]', '', 'g')::int as ihouse
                          from clm_paccnt_tbl a
                          left join vw_address vw on vw.id=a.id
                          inner join a_tel_tbl b on b.id_res=".f_accord($i).
                                " where trim(town)=$$$town$$
                          order by 4,7,6 asc";
                        $flag=2;
                    }


                    $model = f_krg::findBySql($sql)->all();

                    if($flag==2) {
                        $searchModel = new f_krg();
                        if (isset($model[0]->res)) {
                            $k = count($model);
                            for($j=0;$j<$k;$j++){

                                $data[$jj]['res']=$model[$j]['res'];
                                $data[$jj]['tel']=$model[$j]['tel'];
                                $data[$jj]['town']=$model[$j]['town'];
                                $data[$jj]['street']=$model[$j]['street'];
                                $data[$jj]['house']=$model[$j]['house'];
                                $data[$jj]['korp']=$model[$j]['korp'];
                                $jj++;
                            }
                            $fnd=1;
                           continue 2;
                        }
                        else
                        {
                            $flag=0;
                            $is = '';
                            break;
                        }
                    }

                    if (isset($model[0]->res)) {
                        $is = $model[0]->res;
                        $flag=1;
                        break;
                    }
                    else
                        $is = '';
                    break;
                case 7:

                    if(!is_null($house) and !empty($house)) {
                        if (is_null($korp) || empty($korp))
                            $sql = "select a.id,'Інгулецькі РЕМ' as res,b.tel as tel,
                      vw.town,vw.street,vw.house,vw.korp,vw.flat from clm_paccnt_tbl a
                      left join vw_address vw on vw.id=a.id
                       inner join a_tel_tbl b on b.id_res=".f_accord($i).
                                " where trim(town)=$$$town$$ and trim(street)=$$$street$$
                        and trim(house)='$house' and korp is null";
                        else
                            $sql = " select a.id,'Інгулецькі РЕМ' as res,b.tel as tel,
                  vw.town,vw.street,vw.house,vw.korp,vw.flat from clm_paccnt_tbl a
                  left join vw_address vw on vw.id=a.id
                  inner join a_tel_tbl b on b.id_res=".f_accord($i).
                                " where trim(town)=$$$town$$ and trim(street)=$$$street$$
                  and trim(house)='$house' and korp is not null and 
                  (trim(korp)=trim('$k1') or trim(korp)=trim('$k2'))";

                    }
                    else
                    {
                        if(!is_null($street) and !empty($street))
                            $sql = "select distinct 'Інгулецькі РЕМ'::character varying as res,b.tel as tel,
                      vw.town,vw.street,vw.house,vw.korp,regexp_replace(house, '[^0-9]', '', 'g')::int as ihouse
                      from clm_paccnt_tbl a
                      left join vw_address vw on vw.id=a.id
                      inner join a_tel_tbl b on b.id_res=".f_accord($i).
                                " where trim(town)=$$$town$$ and trim(street)=$$$street$$
                      order by 7,6 asc";
                        else
                            $sql = "select distinct 'Інгулецькі РЕМ'::character varying as res,b.tel as tel,
                          vw.town,vw.street,vw.house,vw.korp,regexp_replace(house, '[^0-9]', '', 'g')::int as ihouse
                          from clm_paccnt_tbl a
                          left join vw_address vw on vw.id=a.id
                          inner join a_tel_tbl b on b.id_res=".f_accord($i).
                                " where trim(town)=$$$town$$
                          order by 4,7,6 asc";
                        $flag=2;
                    }

                    $model = f_in::findBySql($sql)->all();

                    if($flag==2) {
                        $searchModel = new f_in();
                        if (isset($model[0]->res)) {
                            $k = count($model);
                            for($j=0;$j<$k;$j++){

                                $data[$jj]['res']=$model[$j]['res'];
                                $data[$jj]['tel']=$model[$j]['tel'];
                                $data[$jj]['town']=$model[$j]['town'];
                                $data[$jj]['street']=$model[$j]['street'];
                                $data[$jj]['house']=$model[$j]['house'];
                                $data[$jj]['korp']=$model[$j]['korp'];
                                $jj++;
                            }
                            $fnd=1;
                            continue 2;
                        }
                        else
                        {
                            $flag=0;
                            $is = '';
                            break;
                        }
                    }

                    if (isset($model[0]->res)) {
                        $is = $model[0]->res;
                        $flag=1;
                        break;
                    }
                    else
                        $is = '';
                    break;
                case 8:

                    if(!is_null($house) and !empty($house)) {
                        if (is_null($korp) || empty($korp))
                            $sql = "select a.id,'Апостолівські РЕМ' as res,b.tel as tel,
                      vw.town,vw.street,vw.house,vw.korp,vw.flat from clm_paccnt_tbl a
                      left join vw_address vw on vw.id=a.id
                       inner join a_tel_tbl b on b.id_res=".f_accord($i).
                                " where trim(town)=$$$town$$ and trim(street)=$$$street$$
                        and trim(house)='$house' and korp is null";
                        else
                            $sql = " select a.id,'Апостолівські РЕМ' as res,b.tel as tel,
                  vw.town,vw.street,vw.house,vw.korp,vw.flat from clm_paccnt_tbl a
                  left join vw_address vw on vw.id=a.id
                  inner join a_tel_tbl b on b.id_res=".f_accord($i).
                                " where trim(town)=$$$town$$ and trim(street)=$$$street$$
                  and trim(house)='$house' and korp is not null and 
                  (trim(korp)=trim('$k1') or trim(korp)=trim('$k2'))";

                    }
                    else
                    {
                        if(!is_null($street) and !empty($street))
                            $sql = "select distinct 'Апостолівські РЕМ'::character varying as res,b.tel as tel,
                      vw.town,vw.street,vw.house,vw.korp,regexp_replace(house, '[^0-9]', '', 'g')::int as ihouse
                      from clm_paccnt_tbl a
                      left join vw_address vw on vw.id=a.id
                      inner join a_tel_tbl b on b.id_res=".f_accord($i).
                                " where trim(town)=$$$town$$ and trim(street)=$$$street$$
                      order by 7,6 asc";
                        else
                            $sql = "select distinct 'Апостолівські РЕМ'::character varying as res,b.tel as tel,
                          vw.town,vw.street,vw.house,vw.korp,regexp_replace(house, '[^0-9]', '', 'g')::int as ihouse
                          from clm_paccnt_tbl a
                          left join vw_address vw on vw.id=a.id
                          inner join a_tel_tbl b on b.id_res=".f_accord($i).
                                " where trim(town)=$$$town$$
                          order by 4,7,6 asc";
                        $flag=2;
                    }

                    $model = f_ap::findBySql($sql)->all();

                    if($flag==2) {
                        $searchModel = new f_ap();
                        if (isset($model[0]->res)) {
                            $k = count($model);
                            for($j=0;$j<$k;$j++){

                                $data[$jj]['res']=$model[$j]['res'];
                                $data[$jj]['tel']=$model[$j]['tel'];
                                $data[$jj]['town']=$model[$j]['town'];
                                $data[$jj]['street']=$model[$j]['street'];
                                $data[$jj]['house']=$model[$j]['house'];
                                $data[$jj]['korp']=$model[$j]['korp'];
                                $jj++;
                            }
                            $fnd=1;
                            continue 2;
                        }
                        else
                        {
                            $flag=0;
                            $is = '';
                            break;
                        }
                    }

                    if (isset($model[0]->res)) {
                        $is = $model[0]->res;
                        $flag=1;
                        break;
                    }
                    else
                        $is = '';
                    break;

            }

//        $model = f_dn::findBySql($sql,[':town'=>$town,
//            ':street'=>$street,':house'=>$house])->all();

            if ($flag>0)
                break;

        }

        if ($fnd==1) {
            //$dataProvider = $searchModel->search(Yii::$app->request->queryParams, $sql);
            $dataProvider = new ArrayDataProvider([
                'allModels' => $data,
//                'sort' => [
//                    'attributes' => ['id', 'username', 'email'],
//                ],

            ]);
            $dataProvider->pagination = false;
        }

//        debug($dataProvider);
//        return;

        if($fnd==0)
            return $this->render('resultFind', ['model' => $model,
                'is' => $is]);
        else
            return $this->render('resultFindGrid', ['model' => $model,
                'dataProvider' => $dataProvider
            ]);

    }

    // Подгрузка кол-ва зон счетчика в зависимости от лицевого счета
    public function actionGet_zones($lic)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        if (Yii::$app->request->isAjax) {
            $hSoap = 'http://erppr3.esf.ext:8000/sap/bc/srt/wsdl/flv_10002A101AD1/bndg_url/sap/bc/srt/scs/sap/zint_ws_source_mr_interact?sap-client=100'; // Prod
//            $hSoap='http://erpqs1.esf.ext:8000/sap/bc/srt/wsdl/flv_10002A101AD1/bndg_url/sap/bc/srt/scs/sap/zint_ws_source_mr_interact?sap-client=100';
//        $hSoap='http://erppr2.esf.ext:8000/sap/bc/srt/wsdl/flv_10002A1011D1/bndg_url/sap/bc/srt/scs/sap/zint_ws_upl_mrdata?sap-client=100';
            $lSoap='WEBFRGATE_CK'; /*логін*/
            $pSoap='sjgi5n27'; /*пароль*/
//        $eic_post = '62Z1899153225220';
            $dherelo = 5;
            $op_post = mb_substr($lic,0,9,"UTF-8");
            $i_letter = mb_substr($lic,9,3,"UTF-8");
            $i_letter = mb_strtoupper($i_letter,"UTF-8");
            if(empty($op_post)) {
                $cur[0] = -1;
                return ['success' => true, 'cur' => $cur];
            }
            $res = 'CK0101';
            $adapter = new ccon_soap($hSoap,$lSoap,$pSoap);
            $proc="ZintWsMrFindAccounts";
//        $proc="ZintUplMrdataInd";
            $arr=array(
                $proc=>array(
                    'IvArea'=>			$res, //якшо пошук по ОР то тут дільн нада
                    'IvCheckPeriod'=>	'',
                    'IvCompany'=>		'CK',
//                'IvEic'=>			$eic_post, //eic
                    'IvEic'=>			'', //eic
                    'IvMrData'=>		'',
                    'IvPhone'=>			'',  //tel
                    'IvSrccode'=>		'05', //джерело
                    'IvVkona'=>			$op_post ,//OP
//                'IvVkona'=>			'' ,//OP
                ),
            );

            $result=objectToArray($adapter->soap_blina($arr[$proc],$proc));
//            debug($result);
            if(count($result['EtAccounts'])==0) {
                $cur[0] = 0;
                return ['success' => true, 'cur' => $cur];
            }

            if(isset($result['EtAccounts']['item'])) {
                $a_account = $result['EtAccounts']['item']['Vkona'];
                $address = $result['EtAccounts']['item']['Address'];
                $eic = $result['EtAccounts']['item']['Eic'];
                $anlg = $result['EtAccounts']['item']['Anlage'];
                $fio = $result['EtAccounts']['item']['Fio'];
            }


            //////SOAP інфа про ту --------------------------------
            $proc2="ZintWsMrGetDeviceByanlage";
            $arr2=array(
                $proc2=>array(
                    'IvAnlage'=>		$anlg,
                    'IvMrDate'=>		Date('Y-m-d'),
                ),
            );
            $result2=objectToArray($adapter->soap_blina($arr2[$proc2],$proc2));
//           debug($result2);
//           return;
            $zones = $result2['EvZones'];
            $sernr = $result2['EvSernr'];
            if($zones==1) {
                $val1 = $result2['EtScales']['item']['MrvalPrev'];
                $val21 = 0;
                $val22 = 0;
                $val31 = 0;
                $val32 = 0;
                $val33 = 0;
            }
            if($zones==2) {
                $val21 = $result2['EtScales']['item'][0]['MrvalPrev'];
                $val22 = $result2['EtScales']['item'][1]['MrvalPrev'];
                $val1 = 0;
                $val31 = 0;
                $val32 = 0;
                $val33 = 0;
            }
            if($zones==3) {
                $val31 = $result2['EtScales']['item'][0]['MrvalPrev'];
                $val32 = $result2['EtScales']['item'][1]['MrvalPrev'];
                $val33 = $result2['EtScales']['item'][2]['MrvalPrev'];
                $val1 = 0;
                $val21 = 0;
                $val22 = 0;
            }
            $cur[0] = $zones;
            $cur[1] = $sernr;
            $cur[2] = $address;
            $cur[3] = $val1;
            $cur[4] = $val21;
            $cur[5] = $val22;
            $cur[6] = $val31;
            $cur[7] = $val32;
            $cur[8] = $val33;
            $cur[9] = $fio;
            $fio_mas = explode(" ", $fio);
            $init='';
            foreach ($fio_mas as $v) {
                $init.=mb_substr($v,0,1,"UTF-8");
            }
//            $cur[10] = $init;
            if($init == $i_letter) $cur[9] = 1;
            else $cur[9] = 0;
//            $zones . ' ' . $sernr . ' ' . $address
            return ['success' => true, 'cur' => $cur];

        }
    }

    // Подгрузка населенных пунктов - происходит при наборе первых букв
    public function actionGet_search_town($name)
    {

        Yii::$app->response->format = Response::FORMAT_JSON;
                
        $name1 = mb_strtolower($name,"UTF-8");
        $name2 = mb_strtoupper($name,"UTF-8");
        if (Yii::$app->request->isAjax) {
            $sql = 'select min(id) as id,district,town from spr_towns where town like '.'"'.$name1.'%"'.
                    ' and length('.'"'.$name1.'")>3'.' group by district,town order by town,district';
//             debug($sql);
//             return;

             $cur = spr_towns::findBySql($sql)->all();

            return ['success' => true, 'cur' => $cur];

        }
    }

    // Подгрузка населенных пунктов - происходит при наборе первых букв
    public function actionGet_search_town2($name)
    {

        Yii::$app->response->format = Response::FORMAT_JSON;

        $name1 = mb_strtolower($name,"UTF-8");
        $name2 = mb_strtoupper($name,"UTF-8");
        if (Yii::$app->request->isAjax) {
            $sql = 'select min(id) as id,town from addr_sap where town like '.'"'.$name1.'%"'.
                ' and length('.'"'.$name1.'")>3'.' group by town order by town';
//             debug($sql);
//             return $sql;

            $cur = spr_towns::findBySql($sql)->all();

            return ['success' => true, 'cur' => $cur];

        }
    }

    public function actionPower_outages()
    {
        $model = new Power_outages();
        $model->begin_date = date("Y-m-d");
        $model->end_date = $model->begin_date ;

//        if (!empty($model->end_date))
//            debug($model->end_date);
//
//        debug($model->type);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
//            debug($model->begin_date);
//            debug($model->end_date);
            $sql = "SELECT descr, case WHEN encode like '%Днепропетровский РЭС%' then 'Дніпропетровські РЕМ' 
WHEN encode like '%Павлоградский%' then 'Павлоградські РЕМ'
WHEN encode like '%Желтоводский РЭС%' then 'Жовтоводські РЕМ'
WHEN encode like '%Ингулецкий РЭС%' then 'Інгулецька дільниця'
WHEN encode like '%Апостоловский РЭС%' then 'Апостолівська дільниця'
WHEN encode like '%Криворожский РЭС%' then 'Криворізькі РЕМ'
WHEN encode like '%Гвардейский  РЭС%' then 'Гвардійська дільниця'
WHEN encode like '%Вольногорский РЭС%' then 'Вільногірські РЕМ' else ' ' END as encode,
accbegin_date as date_begin,addresses,enobject,dtcreate,
case WHEN acctypeid = 1 then 'Планові' else 'Аварійні' END as type_otkl,
case WHEN acctypeid = 1 then planend_date else factend_date END as date_end,
case when (issubmit=1 and factend_date is null) or (issubmit=0 and factend_date is null) then 'Активна' 
                when (issubmit=1 and factend_date is not null) then 'Закрита' 
                when (factend_date is not null and issubmit=0) then 'Скасована' end as status
FROM cc_crash
where 1 = 1";
            if (!empty($model->begin_date)) {
                $sql = $sql . ' and cast(accbegin_date as date) >=' . "'" . $model->begin_date . "'";
            }
            if (!empty($model->end_date)) {
//                if($model->type==2)
//                    $sql = $sql . ' and cast(factend_date as date) <=' . "'" . $model->end_date . "'";
//                if($model->type==1)
//                    $sql = $sql . ' and cast(planend_date as date) <=' . "'" . $model->end_date . "'";
                $sql = $sql . ' and cast(planend_date as date) <=' . "'" . $model->end_date . "'";
            }

            if (!empty($model->type)) {
                if ($model->type != 3)
                    $sql = $sql . ' and acctypeid =' . "'" . $model->type . "'";
            }
            if (!empty($model->pidrozdil)) {
                if ($model->pidrozdil == 1)
                    $res = 'Днепропетровский РЭС';
                if ($model->pidrozdil == 2)
                    $res = 'Вольногорский РЭС';
                if ($model->pidrozdil == 3)
                    $res = 'Павлоградский  РЭС';
                if ($model->pidrozdil == 4)
                    $res = 'Гвардейский  РЭС';
                if ($model->pidrozdil == 5)
                    $res = 'Желтоводский РЭС';
                if ($model->pidrozdil == 6)
                    $res = 'Криворожский РЭС';
                if ($model->pidrozdil == 7)
                    $res = 'Апостоловский РЭС';
                if ($model->pidrozdil == 8)
                    $res = 'Ингулецкий РЭС';
                $sql = $sql . ' and encode =' . "'" . $res . "'";
            }
            $sql = $sql . ' ORDER BY 3';

//            debug($sql);
//            return;

            $data = Off_site::findbysql($sql)->asArray()
                ->all();
//            debug($data);
//            return;
            return $this->render('result_power_outage', compact('data'));
        } else {
            return $this->render('power_outages', compact('model'));
        }
    }

    // Подгрузка типов фотографий - происходит при выборе события в программе фотофиксации счетчиков
    public function actionGettypephoto($id) {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (Yii::$app->request->isAjax) {
            $sql = "select '0 ' as names union
                        SELECT concat(id,' ',names) as names FROM spr_foto WHERE sob_id=:id";
            $tfoto = spr_foto::findBySql($sql, [':id' => $id])->all();
            return ['success' => true, 'tfoto' => $tfoto];
        }
        return ['oh no' => 'you are not allowed :('];
    }

    // Фотофіксація лічильників
    public function actionPhoto_counter()
    { $this->view->title = 'Фотофіксація лічильників';
        return $this->render('photo_counter');
    }

    // Завантаження фото з телефону (Фотофіксація лічильників)
    public function actionUpload2server()
    {
//        mb_internal_encoding("UTF-8");
//        $str = file_get_contents('db.json');
//        $json = json_decode($str, true);
//        debug($json);
//        $mysqli = new mysqli($json['host'], $json['username'], $json['password'], $json['dbname']);
//        if ($mysqli->connect_error) {
//            die('Ошибка подключения (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
//        }
//        $mysqli->set_charset('utf8');
//        if ($json['SQLite_db'] === " ") { //Для отладки на локальном сервере должна быть указана база в db.json
            $json['SQLite_db'] = $_FILES["file"]["tmp_name"]; // на реальном сервере база загружается
//            $json['SQLite_db'] = 'calc1.png';

            //$json['SQLite_db'] = __DIR__.'\\upload\\foto.db';
//        }
        $db = new SQLite3($json['SQLite_db']);
        $arhiv_file_name = "";
        $results = $db->query(
            "SELECT date, LS, potrebitel, adres, sob_id, obg_id, res_id, user_id, foto 
        FROM Fotodata 
        ORDER BY date, ls, sob_id, user_id");

        debug($results);
        return;

        // Запись в быт
        $bsob = $mysqli->prepare(
            "INSERT INTO bsob (sob_id, res_id, LS, potrebitel, adres, dates, `user_id`)
        VALUES (?, ?, ?, ?, ?, ?, ?)"
        );
        $bfoto = $mysqli->prepare(
            "INSERT INTO bfoto (sob_id, `user_id`, bsob_id, foto_id, f1)
        VALUES (?, ?, ?, ?, ?)"
        );
        if ($results) {
            if ($row = $results->fetchArray()) {// Первая запись
                $date = $row['date'];
                $LS = $row['LS'];
                $sob_id = $row['sob_id'];
                $user_id = $row['user_id'];
                bsob($row, $bsob);
                $insert_id = $mysqli->insert_id;
                bfoto($row, $bfoto, $insert_id);
                $arhiv_file_name = substr($row['date'], 6, 4).substr($row['date'], 0, 2).substr($row['date'], 3, 2).
                    "_res{$row['res_id']}_user{$row['user_id']}_fotob";
            }
            while ($row = $results->fetchArray()) {
                if ($date == $row['date'] && $LS == $row['LS'] && $sob_id == $row['sob_id'] && $user_id == $row['user_id']) {
                    bfoto($row, $bfoto, $insert_id);
                } else {
                    $date = $row['date'];
                    $LS = $row['LS'];
                    $sob_id = $row['sob_id'];
                    $user_id = $row['user_id'];
                    bsob($row, $bsob);
                    $insert_id = $mysqli->insert_id;
                    bfoto($row, $bfoto, $insert_id);
                }
            }
            //$bsob->close();
            //$bfoto->close();
        }




    }


    // Ведомости для программы auto
    public function actionAuto()
    { $this->view->title = 'Звіти [auto]';
        return $this->render('auto');
    }

    //  Происходит при формировании отчета по  заявкам [auto]
    public function actionAutoviewz()
    {
        $model = new InputPeriod();
        if ($model->load(Yii::$app->request->post()))
        {
            return $this->redirect([ 'viewz_auto',
                'date1' => $model->date1,
                'date2' => $model->date2,
                'nomer' => $model->nomer]);
        }
        else {
            $role=0;
            return $this->render('inputperiod', [
                'model' => $model,'role' => $role
            ]);
        }
    }

    //  Происходит при просмотре фотографий счетчиков
    public function actionPhoto_counter_view()
    {
        $model = new Data_fotofix();
        if ($model->load(Yii::$app->request->post()))
        {
            // Обновление пустых полей eic
            $sql = 'select LS as ls,id from bsob where eic is null or eic="" and substr(LS,1,1)="0"';
            $bsob = bsob::findBySql($sql)->asarray()->all();
            if(count($bsob)>0){
                foreach ($bsob as $v) {
                    $acc = $v['ls'];
                    $id = $v['id'];
                    $sql = "select a.accountid,a.pib,a.account,a.eic,a.sapid,b.counter,b.sn,b.zonity,
                                y.zdate,y.zone0,y.zone1,y.zone2,y.zone3
                                from accounts a
                                left join counter b on a.accountid=b.accountid
                                left join 
                                (select j.accountid,j.zdate,j.zone0,j.zone1,j.zone2,j.zone3,j.zonity from counterdgn j inner join 
                                (select accountid,max(zdate) as zdate from counterdgn 
                                group by accountid) f on 
                                j.accountid=f.accountid and j.zdate=f.zdate) y
                                on a.accountid=y.accountid
                                where a.account='$acc'";
//                    debug($sql);
                    $data = data_cc::findBySql($sql)->asarray()->one();
                    $eic = $data['eic'];
                    $sapid = $data['sapid'];
                    $counter=$data['counter'];
                    $sn=$data['sn'];
                    $zonity=$data['zonity'];
                    $zone0=$data['zone0'];
                    $zone1=$data['zone1'];
                    $zone2=$data['zone2'];
                    $zone3=$data['zone3'];
                    $zdate=$data['zdate'];
                    if (empty($zone0)) $zone0='null';
                    if (empty($zone1)) $zone1='null';
                    if (empty($zone2)) $zone2='null';
                    if (empty($zone3)) $zone3='null';
                    if (empty($zonity)) $zonity=1;
//                    debug($data);
//                    return;
                    $sql = "update bsob 
                    set eic='$eic',counter='$counter',sn='$sn',sapid=$sapid,zdate='$zdate',
                    zonity=$zonity,zone0=$zone0,zone1=$zone1,zone2=$zone2,zone3=$zone3
                    where id=$id
                    ";
                    Yii::$app->db_mysql_site10->createCommand($sql)->execute();
                }
            }
            return $this->redirect([ 'view_fotofix',
                'date1' => $model->date1,
                'date2' => $model->date2,
                'fio' => $model->fio,
                'lic' => $model->lic,
                'rem' => $model->res,
                'event' => $model->event,
                'type_image' => $model->type_image,
                'town' => $model->town,
                'street' => $model->street,
                'house' => $model->house,
                'sapid' => $model->sapid,
                'sn' => $model->sn,
                'eic' => $model->eic,
                'tp' => $model->tp,
                'counter' => $model->counter,
                'exist_seal' => $model->exist_seal,
                'n_seal' => $model->n_seal,
                ]);
        }
        else {
            $role=0;
            return $this->render('data_fotofix', [
                'model' => $model
            ]);
        }
    }

    //  Происходит при передаче показаний счетчика
//    из формы показаний
    public function actionTransitvalue()
    {
        $model = new Data_person();
        $this->face = 1;

        if ($model->load(Yii::$app->request->post())) {

            $sql='select * from transitvalue where trim(code)='."'".trim($model->lic) . "'" .
                ' and dat_ind='."'". date("Y-m-d") ."'";

            $check = transitvalue::findBySql($sql)->asarray()->all();
            if(count($check)==0)
                $server = new transitvalue();
            else
                $server = transitvalue::findBySql($sql)->one();
            $o = $model->lic;
            $cnt = $model->cnt;
            $z = $model->zones;

            $server->dat_ind = date("Y-m-d");
            $server->code = $model->lic;
            $server->value_1 = $model->val1;
            $server->value_21 = $model->val21;
            $server->value_22 = $model->val22;
            $server->value_31 = $model->val31;
            $server->value_32 = $model->val32;
            $server->value_33 = $model->val33;
            $server->tel = $model->tel;

//            debug($model->valp21);
//            debug($model->valp22);
//            return;

            if(!$server->save(false))
            {
                var_dump($server);
                return;
            }
            // Запись показаний в САП
            $lSoap_s= 'CKSOAPMETER';
            $pSoap_s= 'aTmy9Z<faLNcJ))gTJMwYut(#eJ)NSlcY[2%Meo/';
//            $hSoap_s = 'http://erpqs1.esf.ext:8000/sap/bc/srt/wsdl/flv_10002A101AD1/bndg_url/sap/bc/srt/scs/sap/zint_ws_upl_mrdata?sap-client=100';  // quality
            $hSoap_s = 'http://erppr3.esf.ext:8000/sap/bc/srt/wsdl/flv_10002A1011D1/bndg_url/sap/bc/srt/scs/sap/zint_ws_upl_mrdata?sap-client=100'; // prod
            $client = new \SoapClient(
                "$hSoap_s",
                array('login' => "$lSoap_s",
                    'password' => "$pSoap_s",
                    'trace' => 1)
            );
            $curdate = date('Y-m-d');
            $curtime = date("Hi");
            $bukrs = 'CK01';
            // Однозонный счетчик
            $flag = 0;
            if($z==1) {
                if ($model->val1 < $model->valp1)
                    $flag = 1;
                else {
                    $params = array(
                        'Srccode' => '04',
                        'Bukrs' => $bukrs,
                        'Consdata' => array('item' => array(
                            'Eic' => "",
                            'Account' => "$o",
                            'Date' => $curdate,
                            'DateDb' => $curdate,
                            'TimeDb' => $curtime,
                            'Mrdata' => array(
                                'item' => array(
                                    array('Id' => '121',
                                        'Zon' => '11',
                                        'Device' => $cnt,
                                        'Data' => $model->val1,
                                        'Zwkenn' => ''
                                    )
                                )
                            )
                        )
                        )
                    );
                }
            }

            if($z==2) {
                if (($model->val21 < $model->valp21) || ($model->val22 < $model->valp22))
                    $flag = 1;
                else {
                    $params = array(
                        'Srccode' => '04',
                        'Bukrs' => $bukrs,
                        'Consdata' => array('item' => array(
                            'Eic' => "",
                            'Account' => "$o",
                            'Date' => $curdate,
                            'DateDb' => $curdate,
                            'TimeDb' => $curtime,
                            'Mrdata' => array(
                                'item' => array(
                                    array('Id' => '121',
                                        'Zon' => '21',
                                        'Device' => $cnt,
                                        'Data' => $model->val21,
                                        'Zwkenn' => ''
                                    ),
                                    array('Id' => '122',
                                        'Zon' => '22',
                                        'Device' => $cnt,
                                        'Data' => $model->val22,
                                        'Zwkenn' => ''
                                    ),
                                    array('Id' => '100',
                                        'Zon' => '11',
                                        'Device' => $cnt,
                                        'Data' =>  $model->val21+$model->val22,
                                        'Zwkenn' => ''
                                    )
                                )
                            )
                        )
                        )
                    );
                }
            }

//            debug($flag);
//            return;

            if($z==3) {
                if (($model->val31 < $model->valp31) ||
                    ($model->val32 < $model->valp32) ||
                    ($model->val33 < $model->valp33))
                    $flag = 1;
                else {
                    $params = array(
                        'Srccode' => '04',
                        'Bukrs' => $bukrs,
                        'Consdata' => array('item' => array(
                            'Eic' => "",
                            'Account' => "$o",
                            'Date' => $curdate,
                            'DateDb' => $curdate,
                            'TimeDb' => $curtime,
                            'Mrdata' => array(
                                'item' => array(
                                    array('Id' => '300',
                                        'Zon' => '31',
                                        'Device' => $cnt,
                                        'Data' => $model->val31,
                                        'Zwkenn' => ''
                                    ),
                                    array('Id' => '100',
                                        'Zon' => '32',
                                        'Device' => $cnt,
                                        'Data' => $model->val32,
                                        'Zwkenn' => ''
                                    ),
                                    array('Id' => '200',
                                        'Zon' => '33',
                                        'Device' => $cnt,
                                        'Data' => $model->val33,
                                        'Zwkenn' => ''
                                    ),
                                    array('Id' => '400',
                                        'Zon' => '11',
                                        'Device' => $cnt,
                                        'Data' =>  $model->val31+$model->val32+$model->val33,
                                        'Zwkenn' => ''
                                    )

                                )
                            )
                        )
                        )
                    );
                }
            }

            if($flag==0) {
                $result = $client->__soapCall('ZintUplMrdataInd', array($params));
//                      debug($params);
//                      debug($result);
//                      return;

                if ($z == 1)
                    $done = $result->Retdata->item->Retcode;
                else
                    $done = $result->Retdata->item[0]->Retcode;
                $msg = "Показники по особовому рахунку $o передано ";
            }
            else {
                $msg = "Показники по особовому рахунку $o не передано, попередні показники більші ніж введені.";
             }

//            $done = $result->Retdata->item->Retcode;
//            debug($done);
//            debug($model->val1);
//            return;

            // Сообщение о завершении записи показаний
            $model = new info();
            $model->title =  $msg;
            $model->info1 = "";
            $model->style1 = "d15";
            $model->style2 = "info-text";
            $model->style_title = "d9";

            return $this->render('about', [
                'model' => $model]);

        }
        else {
            $role=0;
            return $this->render('data_person', [
                'model' => $model,
            ]);
        }
    }

    //  Происходит при закачке данных с АСКОЕ в САП
    public function actionAskoe2sap()
    {
        $model = new Data_askoe();
        if ($model->load(Yii::$app->request->post()))
        {
            return $this->redirect([ 'smart2sap',
                'res' => $model->res,
                'code' => $model->code]);
        }
        else {
            $role=0;
            return $this->render('data_askoe', [
                'model' => $model,
            ]);
        }
    }

    //  Передача данных с АСКОЕ в САП
    public function actionSmart2sap($res,$code=''){
        // Данные подключения для приема показаний
        $hIPsap="192.168.1.7"; //1.7 - качество
        // Это качество
        $hSoap='http://erpqs1.esf.ext:8000/sap/bc/srt/wsdl/flv_10002A101AD1/bndg_url/sap/bc/srt/scs/sap/zint_ws_source_mr_interact?sap-client=100';
        $lSoap='WEBFRGATE_CK'; /*логін*/
        $pSoap='sjgi5n27'; /*пароль*/

        // Данные подключения для передачи показаний
        $lSoap_s= 'CKSOAPMETER';
        $pSoap_s= 'aTmy9Z<faLNcJ))gTJMwYut(#eJ)NSlcY[2%Meo/';
        // Это качество
        $hSoap_s = 'http://erpqs1.esf.ext:8000/sap/bc/srt/wsdl/flv_10002A101AD1/bndg_url/sap/bc/srt/scs/sap/zint_ws_upl_mrdata?sap-client=100';
        $op_post = '011030775';   // 1 zone
        switch ($res){
            case 1:
                $res_cek = 'CK0101';
                break;
            case 2:
                $res_cek = 'CK0102';
                break;
            case 3:
                $res_cek = 'CK0107';
                break;
            case 4:
                $res_cek = 'CK0104';
                break;
        }
        // Формируем название таблицы
        $_table = date('Ym');
        $_table = 'energysum_' . $_table;
//        debug($_table);
//        return;
//        normal_acc
        $res_con = substr($res_cek,5,1);
        $adapter = new ccon_soap($hSoap,$lSoap,$pSoap);
        if (empty($code))
        $sql = " select * from ( 
           select meterid,date,recorddate,ownername,owneraccount,lic,sum(coalesce(val09,0)) as val09,sum(coalesce(val10,0)) as val10 from
            (select *,case when tzid=1 then round(value,0) end as val09,case when tzid=2 then round(value,0) end as val10 from (
            select d.*,case when owneraccount is null then code else owneraccount end as lic from
            (select aa.*,bb.ownername,normal_acc(bb.owneraccount) as owneraccount,''::char(9) as code,bb.serialnumber,bb.name from
            (select a.* from $_table a join
            (select meterid,max(date) as date from $_table a --where meterid=14861
            group by meterid) b 
            on a.meterid=b.meterid and a.date=b.date
            order by 1,4
            ) aa
            left join meter bb on aa.meterid=bb.id
  --         left join sn2code cc on bb.serialnumber=cc.num_meter and bb.owneraccount is null and cc.exact=1
            where 
            aa.tzid in (1,2)
            order by 1,4
            ) d
            ) v
            ) w
            group by meterid,date,recorddate,ownername,owneraccount,lic
            ) f 
            where substr(lic,2,1)='$res_con'
            ";
        else
            $sql = "select * from ( 
 select meterid,date,recorddate,ownername,owneraccount,lic,sum(coalesce(val09,0)) as val09,sum(coalesce(val10,0)) as val10 from
(select *,case when tzid=1 then round(value,0) end as val09,case when tzid=2 then round(value,0) end as val10 from (
select d.*,case when owneraccount is null then code else owneraccount end as lic from
            (select aa.*,bb.ownername,normal_acc(bb.owneraccount) as owneraccount,''::char(9) as code,bb.serialnumber,bb.name from
            (select a.* from $_table a join
            (select meterid,max(date) as date from $_table a --where meterid=14861
            group by meterid) b 
            on a.meterid=b.meterid and a.date=b.date
            order by 1,4
            ) aa
            left join meter bb on aa.meterid=bb.id
          --  left join sn2code cc on bb.serialnumber=cc.num_meter and bb.owneraccount is null and cc.exact=1
            where 
            aa.tzid in (1,2)
            order by 1,4
            ) d
            ) v
            ) w
            group by meterid,date,recorddate,ownername,owneraccount,lic
            ) f 
            where substr(lic,2,1)='$res_con' and lic = '$code'";

//        debug($sql);
//        return;
        $date1 = strtotime('-5 days');
        $date1 = date('Y-m-d', $date1);
        $sql1 = $sql . ' and date<=' . "'" . $date1 . "'";
        $data1 = \Yii::$app->db_askoe_real->createCommand($sql1)->queryAll();
        // Удаляем таблицу непереданных показаний
        $z = 'DELETE from err_trans';
//        $data_z = \Yii::$app->db_askoe_test->createCommand($z)->queryAll();
        $data_z = \Yii::$app->db_askoe_real->createCommand($z)->queryAll();
        foreach ($data1 as $v) {
            $lic1 = $v['lic'];
            $ownername1=$v['ownername'];
            $val091 = $v['val09'];
            $val101 = $v['val10'];
            $date1 = $v['date'];
            $z = "INSERT INTO err_trans(lic,err,ownername,val09,val10,date,status) VALUES('$lic1',0,
                    '$ownername1',$val091,$val101,'$date1','Передано - старі показники')";
            $data_z = \Yii::$app->db_askoe_real->createCommand($z)->queryAll();
        }

          // Массив всех необходимых данных для передачи показаний
//        $data = \Yii::$app->db_askoe_test->createCommand($sql)->queryAll();
        $data = \Yii::$app->db_askoe_real->createCommand($sql)->queryAll();

//        debug($sql);
//        debug($data);
//        return;

        $q_data=count($data);
//        return;
        $i=0;
        foreach ($data as $v) {
            $i++;
            $op_post = trim($v['lic']);
            // Берем  лиц. счет после символа:  '/'
            $pos = find_str($op_post,'/');
            if($pos<>-1) {
                $op_post = substr($op_post,$pos);
            }
            $name = $v['ownername'];
            $name = str_replace("'", '`', $name);
            $val9 = $v['val09'];
            $val10 = $v['val10'];
            $curdate = substr($v['date'], 0, 10);

            $proc = "ZintWsMrFindAccounts";
            $arr = array(
                $proc => array(
                    'IvArea' => $res_cek,//якшо пошук по ОР то тут дільн нада
                    'IvCheckPeriod' => '',
                    'IvCompany' => 'CK',
                    'IvEic' => '', //eic
                    'IvMrData' => '',
                    'IvPhone' => '',  //tel
                    'IvSrccode' => '05', //джерело
                    'IvVkona' => $op_post,//OP
                ),
            );

            $result = objectToArray($adapter->soap_blina($arr[$proc], $proc));
//        debug($result);
//        return;

            if (isset($result['EtAccounts']['item'])) {
                $a_account = $result['EtAccounts']['item']['Vkona'];
                $address = $result['EtAccounts']['item']['Address'];
                $eic = $result['EtAccounts']['item']['Eic'];
                $anlg = $result['EtAccounts']['item']['Anlage'];
                $fio = $result['EtAccounts']['item']['Fio'];
            }
//        debug($a_account);
//        debug($address);
//        debug($eic);
//        debug($fio);
//        return;

            //////SOAP інфа про ту --------------------------------
            $proc2 = "ZintWsMrGetDeviceByanlage";
            $arr2 = array(
                $proc2 => array(
                    'IvAnlage' => $anlg,
                    'IvMrDate' => Date('Y-m-d'),
                ),
            );
            $result2 = objectToArray($adapter->soap_blina($arr2[$proc2], $proc2));

            if (isset($result2['EvZones'])) {
                $typ_li4 = $result2['EvBauform'];
                $counterSN = $result2['EvSernr'];
                $zonna = $result2['EvZones'];
                $EvEqunr = $result2['EvEqunr'];
                $EvFactor = $result2['EvFactor'];
                $zonnG = '';
            }

//            debug($result2);
//            debug($zonna);
//        return;

            $cls = '';
            $a_zG = 0;
            $client = new \SoapClient(
                "$hSoap_s",
                array('login' => "$lSoap_s",
                    'password' => "$pSoap_s",
                    'trace' => 1)
            );

            $arrG = array(
                'Id' => '400',
                'Zon' => '40',
                'Device' => $counterSN,
                'Data' => $a_zG,
                'Zwkenn' => ''
            );

//            $curdate = date("Y-m-d");
            $curtime = date("Hi");
            $bukrs = 'CK01';

            if (1 == 2) // Общая зона
            {
//                if (!empty($val0)) {
//                    $zonna = 1;
                $a_z1 = $val9 + $val10;
                $params_c = array(
                    'Srccode' => '11',
                    'Bukrs' => $bukrs,
                    'Consdata' => array('item' => array(
                        'Eic' => "",
                        'Account' => "$a_account",
                        'Date' => $curdate,
                        'DateDb' => $curdate,
                        'TimeDb' => $curtime,
                        'Mrdata' => array(
                            'item' => array(
                                array('Id' => '999',
                                    'Zon' => '11',
                                    'Device' => $counterSN,
                                    'Data' => $a_z1,
                                    'Zwkenn' => ''
                                )
                            )
                        )
                    )

                    )
                );
            }


            if (!empty($val9) || !empty($val10)) {
                $zonna = 2;
                $params = array(
                    'Srccode' => '11',
                    'Bukrs' => $bukrs,
                    'Consdata' => array('item' => array(
                        'Eic' => '',
                        'Account' => $a_account,
                        'Date' => $curdate,
                        'DateDb' => $curdate,
                        'TimeDb' => $curtime,
                        'Mrdata' => array('item' =>
                            array(
                                array('Id' => '121',
                                    'Zon' => '21',
                                    'Device' => $counterSN,
                                    'Data' => $val9,
                                    'Zwkenn' => ''
                                ),
                                array('Id' => '122',
                                    'Zon' => '22',
                                    'Device' => $counterSN,
                                    'Data' => $val10,
                                    'Zwkenn' => ''
                                ),
                                array('Id' => '100',
                                    'Zon' => '11',
                                    'Device' => $counterSN,
                                    'Data' =>  $val9+$val10,
                                    'Zwkenn' => ''
                                )
                            )
                        )
                    )
                    )
                );
            }

            if (1 == 2) // Исключаем 3х-зонные счетчики
            {
                if (!empty($val6) || !empty($val7) || !empty($val8)) {
                    $zonna = 3;
                    $a_z3 = $val8;
                    $a_z1 = $val7;
                    $a_z2 = $val6;
                    $params = array(
                        'Srccode' => '01',
                        'Bukrs' => $bukrs,
                        'Consdata' => array('item' => array(
                            'Eic' => '',
                            'Account' => $a_account,
                            'Date' => $curdate,
                            'DateDb' => $curdate,
                            'TimeDb' => $curtime,
                            'Mrdata' => array('item' =>
                                array(
                                    array('Id' => '300',
                                        'Zon' => '31',
                                        'Device' => $counterSN,
                                        'Data' => $a_z3,
                                        'Zwkenn' => ''
                                    ),
                                    array('Id' => '200',
                                        'Zon' => '33',
                                        'Device' => $counterSN,
                                        'Data' => $a_z2,
                                        'Zwkenn' => ''
                                    ),
                                    array('Id' => '100',
                                        'Zon' => '32',
                                        'Device' => $counterSN,
                                        'Data' => $a_z1,
                                        'Zwkenn' => ''
                                    )
                                )
                            )
                        )
                        )
                    );
                }
            }

            try {
                $result = $client->__soapCall('ZintUplMrdataInd', array($params));
//                 debug($result);
//                 return;

//                if(isset($_POST['a_zG'])) @$done = $result->Retdata->item[0]->Retcode[0];
//                else
                if ($zonna == 1) {
                    if (is_object($result->Retdata->item))
                        $done = $result->Retdata->item->Retcode;
                    else
                        $done = '0';
                } else {
                    if (is_object($result->Retdata->item[0]))
                        $done = $result->Retdata->item[0]->Retcode;
                    else
                        $done = '0';
                }

                if ($done == '1') {
//                    echo "Ваші показники внесено!";
//                    echo "<br>";
                    $cls = 'okok';
//                    $z="INSERT INTO err_trans(lic,err,ownername,val09,val10) VALUES('$op_post',0,'$name',$val9,$val10)";
//                    $data_z = \Yii::$app->db_askoe_test->createCommand($z)->queryAll();
                } else {
                    $cls = 'error';
//                    echo "<br>";
//                    echo "Показники не внесено по ".$op_post;
//                    echo "<br>";
                    $z = "INSERT INTO err_trans(lic,err,ownername,val09,val10,date,status) VALUES('$op_post',1,
                            '$name',$val9,$val10,'$curdate','Непередано')";
                    $data_z = \Yii::$app->db_askoe_real->createCommand($z)->queryAll();
                }
            } catch (SoapFault $e) {
                echo $e;
            }

//            $result_с = $client->__soapCall('ZintUplMrdataInd', array($params_с));
//            if (is_object($result_с->Retdata->item))
//                $done_c = $result_с->Retdata->item->Retcode;
//            debug('done_c='.$done_c);
        }

        if($i==$q_data) {
//            echo "Всі $i показники передано";

            $searchModel = new err_trans();
            $err = err_trans::find()->orderBy('err')->all();
            if(count($err)>0) {
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $sql);
                $dataProvider->pagination = false;

                return $this->render('err_trans', ['model' => $err,
                    'dataProvider' => $dataProvider]);
            }
            else{
                $model = new info();
                $model->title =  "Всі показники передано";
                $model->info1 = "Всього переданих показників: $i";
                $model->style1 = "d15";
                $model->style2 = "info-text";
                $model->style_title = "d9";

                return $this->render('about', [
                    'model' => $model]);
            }
        }
        else
//            echo "Передача зупинилась на $i - му показнику";
        $model = new info();
        $model->title = "Передача зупинилась на $i - му показнику";
        $model->info1 = "";
        $model->style1 = "d15";
        $model->style2 = "info-text";
        $model->style_title = "d9";

        return $this->render('about', [
            'model' => $model]);

        // --------------------------------------------
    }

    // Просмотр задублированных заявок для программы auto (поиск)
    public function actionAutodouble_f()
    {
        $model = new InputPeriod();
        if ($model->load(Yii::$app->request->post()))
        {
            return $this->redirect([ 'autodoublez',
                'date1' => $model->date1,
                'date2' => $model->date2,
               ]);
        }
        else {
            $role=1;
            return $this->render('inputperiod', [
                'model' => $model,'role' => $role
            ]);
        }
    }


    // Формирование отчета по  заявкам [auto]
    public function actionViewz_auto($date1,$date2,$nomer)
    {
                $sql = "SELECT *,replace(replace(name_user_res,'</br><FONT color=\"blue\";>',''),'</FONT></br>',' ') AS user_name FROM vw_tzr    
                WHERE  trzDdate>='$date1' and trzDdate<='$date2'
                 ";

//        order by trzDdate

        if(!empty($nomer)){
            $sql=$sql . ' and GOS_NOM like '."'%$nomer%'";
        }
        $sql=$sql . 'order by trzDdate,MODEL,cel ';

        $searchModel = new trz();
        $viewz = trz::findBySql($sql)->all();

//        debug($viewz);
//        return;

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$sql);
        $dataProvider->pagination = false;
        $date1 = date("d.m.Y", strtotime($date1));
        $date2 = date("d.m.Y", strtotime($date2));

        return $this->render('result_viewz', ['model' => $viewz,
            'dataProvider' => $dataProvider, 'date1' => $date1,
            'date2' => $date2, 'sql' => $sql]);
    }


    // Удаление фото счетчика
    public function actionDel_img($id,$file_path)
    {

            $data = bfoto::find()->where(['id'=>$id])->one();
            $data->delete();

        // Удаление файла фото
        unlink('photo/'. $file_path);
//        return $this->redirect([ 'view_photo']);
    }


    // Просмотр отдельного фото счетчика
    public function actionDetail_photo($id,$file_path,$num)
    {
        $data = fotofix::find()->where(['id'=>$id])->one();
        $img = $file_path;
        $ls = $data->ls;
        $date  = $data->dates;
        $fio  = $data->potrebitel;
        $adres = $data->adres;
        $id_res = $data->id_res;
//            debug($img);
//            return;
        // Определение показаний с САПа
        $hSoap = 'http://erppr3.esf.ext:8000/sap/bc/srt/wsdl/flv_10002A101AD1/bndg_url/sap/bc/srt/scs/sap/zint_ws_source_mr_interact?sap-client=100'; // Prod
        $lSoap = 'WEBFRGATE_CK'; /*логін*/
        $pSoap = 'sjgi5n27'; /*пароль*/

        // Данные подключения для передачи показаний
        $adapter = new ccon_soap($hSoap, $lSoap, $pSoap);
//        $sql = "select * from indications where src='05'"; // and zon<>'11'"; // and dt='2021-05-05'  order by dt";

            $bo2 = 'CK010' . $id_res/100;

            $proc = "ZintWsMrFindAccounts";
            $arr = array(
                $proc => array(
                    'IvArea' => $bo2,//якшо пошук по ОР то тут дільн нада
                    'IvCheckPeriod' => '',
                    'IvCompany' => 'CK',
                    'IvEic' => '', //eic
                    'IvMrData' => '',
                    'IvPhone' => '',  //tel
                    'IvSrccode' => '05', //джерело
                    'IvVkona' => $ls  //OP
                ),
            );

            $result = objectToArray($adapter->soap_blina($arr[$proc], $proc));

            $flag=0;
            if (isset($result['EtAccounts']['item']['Vkona'])) {
                $a_account = $result['EtAccounts']['item']['Vkona'];
                $address = $result['EtAccounts']['item']['Address'];
                $eic = $result['EtAccounts']['item']['Eic'];
                $anlg = $result['EtAccounts']['item']['Anlage'];
                $fio = $result['EtAccounts']['item']['Fio'];
            }
            else
            {
                $flag=1;
            }
//        debug($a_account);
//        debug($address);
//        debug($eic);
//        debug($fio);

            //////SOAP інфа про ту --------------------------------
            $proc2 = "ZintWsMrGetDeviceByanlage";
            $arr2 = array(
                $proc2 => array(
                    'IvAnlage' => $anlg,
                    'IvMrDate' => Date('Y-m-d'),
                ),
            );
            $result2 = objectToArray($adapter->soap_blina($arr2[$proc2], $proc2));
//debug($result2);
//return;

            if (isset($result2['EvZones'])) {
                $typ_li4 = $result2['EvBauform'];
                $counterSN = $result2['EvSernr'];
                $zonna = $result2['EvZones'];
                $EvEqunr = $result2['EvEqunr'];
                $EvFactor = $result2['EvFactor'];
                $EvMaxmr = $result2['EvMaxmr'];
                $single_zone = 1;  // Признак однозонного счетчика
                $MrvalPrev1=0;
                $MrvalPrev2=0;
                $MrvalPrev3=0;

                if (isset($result2['EtScales']['item'][0]['MrvalPrev'])) {
                    $single_zone = 0;  // Не однозонный счетчик
                    $MrvalPrev = 0;
                    $MrdatPrev = '';
                    $Zwart = '';
                }
                if (isset($result2['EtScales']['item']))
                    $y = count($result2['EtScales']['item']);


                if ($single_zone == 1) {
                    $MrvalPrev = $result2['EtScales']['item']['MrvalPrev'];
                    $MrdatPrev = $result2['EtScales']['item']['MrdatPrev'];
                    $Zwart = $result2['EtScales']['item']['Zwart'];
                    $total_all = $MrvalPrev;
                }
                if ($y == 2)  // 2 zones
                {
                    $MrvalPrev1 = $result2['EtScales']['item'][0]['MrvalPrev'];
                    $MrdatPrev1 = $result2['EtScales']['item'][0]['MrdatPrev'];
                    $MrvalPrev2 = $result2['EtScales']['item'][1]['MrvalPrev'];
                    $MrdatPrev2 = $result2['EtScales']['item'][1]['MrdatPrev'];
                    $total_all = $MrvalPrev1+$MrvalPrev2;
                    $MrdatPrev=$MrdatPrev1;
                }
                if ($y == 3)  // 3 zones
                {
                    $MrvalPrev1 = $result2['EtScales']['item'][0]['MrvalPrev'];
                    $MrdatPrev1 = $result2['EtScales']['item'][0]['MrdatPrev'];
                    $MrvalPrev2 = $result2['EtScales']['item'][1]['MrvalPrev'];
                    $MrdatPrev2 = $result2['EtScales']['item'][1]['MrdatPrev'];
                    $MrvalPrev3 = $result2['EtScales']['item'][2]['MrvalPrev'];
                    $MrdatPrev3 = $result2['EtScales']['item'][2]['MrdatPrev'];
                    $total_all = $MrvalPrev1+$MrvalPrev2+$MrvalPrev3;
                    $MrdatPrev=$MrdatPrev1;
                }
            }

            $mas[0] = $counterSN;
            $mas[1] = $zonna; // Кол-во зон
            $mas[2] =  $total_all;  // Общая зона
            $mas[3] =  $MrvalPrev1; // День для 2х зонных и Пік для 3х зонных
            $mas[4] =  $MrvalPrev2;  // Ночь для 2х зонных и Напівпік для 3х зонных
            $mas[5] =  $MrvalPrev3;  // Ночь для 3х зонных
            $mas[6] =  $MrdatPrev; // Дата показаний

//            debug($mas);
//            return;
        // Получаем данные по пломбам
        $sql = "select * from vw_seals where lic='$ls'";
        $seals = fotofix::findBySql($sql)->asarray()->all();
//        debug($seals);
//        return;

            return $this->render('detail_photo', ['img' => $img,'ls'=>$ls,
            'date'=>$date,'fio'=>$fio,'id' => $id,'adres' => $adres,'file_path'=> $img,
                'num'=>$num,'mas'=>$mas,'seals'=>$seals]);

    }

    // Просмотр фото счетчиков
    public function actionView_fotofix($date1,$date2,$fio,$lic,$rem,$event,$type_image,
                                       $town,$street,$house,$sapid,$sn,$eic,$tp,$counter,$exist_seal,$n_seal)
    {
        // Создание поискового sql выражения
        $where = ' WHERE 1=1';
        if (!empty($n_seal)) {
            $where.=' and trim(n_seal) like '."'%".trim($n_seal)."%'";
        }
        if ($exist_seal==1) {
            $where.=' and exists(select * from vw_seals where lic=vw_fotofix.ls)';
        }
        if (!empty($lic)) {
            $where.=' and trim(ls) like '."'%".trim($lic)."%'";
        }
        if (!empty($fio)) {
            $where.=' and trim(potrebitel) like '."'%".trim($fio)."%'";
        }
        if ($rem<>0) {
            $where.=' and id_res='.$rem;
        }
        if (!empty($event)) {
            $where.=' and id_event='.$event;
        }
        if (!empty($type_image)) {
            $where.=' and id_typeimage='.$type_image;
        }
        if (!empty($date1)) {
            $where.=" and dates>='$date1'";
        }
        if (!empty($date2)) {
            $where.=" and dates<='$date2'";
        }
        if (!empty($town)) {
            // Извлечение чистого названия населенного пункта из строки
            $p=find_str_ru($town,' ');
            $y=mb_strlen($town,'UTF-8');
            $town = mb_substr($town,$p,$y,'UTF-8');
            $p1=find_str_ru($town,',');

            if(!empty($p1)) {
                $town = mb_substr($town,0,$p1,'UTF-8');
            }
            $where.=' and adres like '."'%".trim($town)."%'";
        }
        if (!empty($street)) {
            // Извлечение чистого названия улицы из строки
            $p=find_str_ru($street,' ');
            $y=mb_strlen($street,'UTF-8');
            $street = mb_substr($street,$p,$y,'UTF-8');
            $p1=find_str_ru($street,',');
            if(!empty($p1)) {
                $street = mb_substr($street,0,$p1,'UTF-8');
            }
            $where.=' and adres like '.'"%'.trim($street).'%"';
        }
        if (!empty($house)) {
            $where.=' and adres like '.'"%'.trim($house).'%"';
        }
        if (!empty($sn)) {
            $where.=' and sn like '.'"%'.trim($sn).'%"';
        }
        if (!empty($eic)) {
            $where.=' and eic like '.'"%'.trim($eic).'%"';
        }
        if (!empty($tp)) {
            $where.=' and tp like '.'"%'.trim($tp).'%"';
        }
        if (!empty($counter)) {
            $where.=' and counter like '.'"%'.trim($counter).'%"';
        }
        if (!empty($sapid)) {
            $where.=' and convert(sapid ,char(20)) like '.'"%'.trim($sapid).'%"';
        }
        $sql='SELECT * FROM vw_fotofix'.$where.' ORDER BY dates DESC';

        $sql='SELECT
        (@row_number:=@row_number + 1) AS num, vw_fotofix.*
        FROM
         vw_fotofix,(SELECT @row_number:=0) AS t'.$where.' ORDER BY dates DESC';

//        debug($sql);
//        return;

        $searchModel = new fotofix();
        $viewf = fotofix::findBySql($sql)->all();

//        debug($viewf);
//        return;

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$sql);
        $dataProvider->pagination = false;
        $date1 = date("d.m.Y", strtotime($date1));
        $date2 = date("d.m.Y", strtotime($date2));

        return $this->render('result_viewf', ['model' => $viewf,
            'dataProvider' => $dataProvider, 'sql' => $sql]);
    }

    public function actionGdata($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (Yii::$app->request->isAjax) {
            $sql = "select id_event,nazv_sob,count(*) as kol from vw_fotofix
                        where ls in
                        (SELECT distinct ls FROM vw_fotofix WHERE id=$id)
                        group by 1,2";
            $cur = fotofix::findBySql($sql)->asarray()->all();
            return ['success' => true, 'cur' => $cur];
        }
    }

    public function actionGdata_d($id,$id_event)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (Yii::$app->request->isAjax) {
            $sql = "select f1,dates from vw_fotofix
                        where ls in
                        (SELECT distinct ls FROM vw_fotofix WHERE id=$id) and id_event=$id_event
                       ";
            $cur = fotofix::findBySql($sql)->asarray()->all();
            return ['success' => true, 'cur' => $cur];
        }
    }

    // Импорт данных для фотофиксации
    public function actionImp_photo_data(){
        $model = new Photo_task();
        if ($model->load(Yii::$app->request->post())) {
            $model->file = UploadedFile::getInstance($model,'file');;
            if($model->file) {
                $model->upload('file');
            }
            $file = $model->file->name;
//            $file = 'task.xml';
            $s = file_get_contents($file);
            $p = xml_parser_create();
            xml_parse_into_struct($p, $s, $vals, $index);
            xml_parser_free($p);
            $y = count($vals);
//            debug($vals);
//            return;
            $lock = 0;
            $ready = 0;
            $j = 0;
            for ($i = 0; $i < $y; $i++) {
                $cur = trim($vals[$i]['tag']);
                $mode = trim($vals[$i]['type']);
                if (isset($vals[$i]['value']))
                    $value = trim($vals[$i]['value']);
                else
                    $value = '';
                if ($cur == 'TABLE') $lock = 1;
                if ($cur == 'ROW' && $mode == 'open' && $lock == 1) $ready = 1;
                if ($cur == 'DATA' && $ready == 1 && !empty($value)) {
                    $mas[$j] = $value;
                    $j++;
                }
                if ($cur == 'CELL' && $mode == 'close' && $lock == 1) $ready = 0;
                if ($lock == 1 && $mode == 'complete') $lock = 0;
            }
            // Преобразуем массив $mas в удобный для использования

            $y = count($mas);
            $j = 0;
            $output = [];
            $k = 0;
            $start = 0;
            for ($i = 0; $i < $y; $i++) {
                $v = trim($mas[$i]);
                if (mb_substr($v, 0, 1, 'UTF-8') == '0' && mb_strlen($v, 'UTF-8') == 9) {
                    $j = $mas[$i - 1];
                    $output[$j]['lic'] = $v;
                    if (isset($mas[$i + 1]))
                        $output[$j]['fio'] = $mas[$i + 1];
                    if (isset($mas[$i + 2]))
                        $output[$j]['adr'] = $mas[$i + 2];
                    if (isset($mas[$i + 3]))
                        $output[$j]['cnt'] = $mas[$i + 3];
                    if (isset($mas[$i + 4]))
                        $output[$j]['val'] = $mas[$i + 4];
                    if (isset($mas[$i + 5]))
                        $output[$j]['date'] = $mas[$i + 5];
                    if (isset($mas[$i + 6])) {
                        if (mb_substr($mas[$i + 6], 0, 4, 'UTF-8') == 'зона') $output[$j]['zone'] = $mas[$i + 6];
                        else
                            $output[$j]['zone'] = '';
                        $k = 1;
                    } else {
                        $k = 0;
                    }

                    if ($k == 1)
                        $i = $i + 6;
                    else
                        $i = $i + 5;
                }
            }

//        debug($output);
//        return;
        // Узнаем РЭС
        $res_q = substr($output[1]['lic'],1,1)*100;

            // Формируем строку из списка лицевых счетов для запроса в WHERE
            $s = '';
            $i = 0;
            foreach ($output as $v) {
                $s = $s . "'" . $v['lic'] . "',";
                $lic[$i] = $v['lic'];
                $i++;
            }
            $s = substr($s, 0, -1);
//        Составляем запрос для выборки из кол-центра
            $sql = "select a.*,e.resparentid as res,e.xcity,g.stype,c.street,b.house_no,b.corpus,d.htype from accounts a
                    left join house b on a.houseid=b.houseid
                    left join street c on a.streetid=c.streetid
                    left join housetype d on b.htypeid=d.htypeid
                    left join xcity e on c.koid=e.kocode::int
                    left join stype g on c.stypeid=g.stypeid
                    WHERE a.account in ($s)";

            $data = \Yii::$app->db_pg_call_center->createCommand($sql)->queryAll();

            // Формируем базу SQLite
            $db = new SQLite3("LS.db");
//        return;
            $sql = "DELETE FROM LSTable";
            $result = $db->exec($sql);
            $sql = "DELETE FROM region";
            $result = $db->exec($sql);
            $sql = "DELETE FROM prom";
            $result = $db->exec($sql);
            $sql = "DELETE FROM street";
            $result = $db->exec($sql);
            $sql = "DELETE FROM tochki_uchota";
            $result = $db->exec($sql);
//        return;
// Заполняем таблицу LSTable
            foreach ($data as $v) {
                $res = trim($v['res']);
                $pib = str_replace("'", '`', $v['pib']);
                $adr = trim(str_replace("'", '`', $v['xcity'])) . ' ' . trim(str_replace("'", '`', $v['stype'])) . ' ' .
                    trim(str_replace("'", '`', $v['street'])) . ' ' . trim($v['house_no']) . ' ' . trim($v['corpus']) . ' ' . trim($v['flat']);
                $region_id = $res;
                $ls = trim($v['account']);
                if (!empty($v['corpus']))
                    $home = trim($v['house_no']) . ' ' . trim($v['corpus']);
                else
                    $home = trim($v['house_no']);

                $street_id = trim($v['streetid']);

                $flat = trim($v['flat']);
                if (empty($flat))
                    $flat = '';

                $sql = "INSERT INTO LSTable (res,ls,name,adres,region_id,street_id,home,flat) VALUES ($res, '$ls','$pib','$adr',
                                                            $region_id,$street_id,'$home','$flat')";
//            debug($sql);
//            return;
                $result = $db->exec($sql);

            }
            // Заполняем таблицу street
            $sql = "select coalesce(e.resparentid,100) as res_id,a.streetid as id,b.stype as types,
                    a.street as names,upper(a.street) as name_up from street a 
                    left join stype b on a.stypeid=b.stypeid
                    left join xcity e on a.koid=e.kocode::int";
            $data = \Yii::$app->db_pg_call_center->createCommand($sql)->queryAll();
            foreach ($data as $v) {
                $names = str_replace("'", '`', $v['names']);
                $name_up = str_replace("'", '`', $v['name_up']);
                $res_id = $v['res_id'];
                $id = $v['id'];
                $types = trim($v['types']);
                $sql = "INSERT INTO street (res_id,id,types,names,name_up) VALUES ($res_id, $id,'$types',
                                                           '$names','$name_up')";
//            debug($sql);
//            return;
                $result = $db->exec($sql);
//            return;

            }

// Заполняем таблицу region
            $sql = "INSERT INTO region (res_id,id,names) VALUES (100, 100,'Дніпро')";
            $result = $db->exec($sql);
            $sql = "INSERT INTO region (res_id,id,names) VALUES (200, 200 ,'Жовті Води')";
            $result = $db->exec($sql);
            $sql = "INSERT INTO region (res_id,id,names) VALUES (300, 300 , 'Вільногірськ')";
            $result = $db->exec($sql);
            $sql = "INSERT INTO region (res_id,id,names) VALUES (400, 400, 'Павлоград')";
            $result = $db->exec($sql);
            $sql = "INSERT INTO region (res_id,id,names) VALUES (500, 500, 'Кривий Ріг')";
            $result = $db->exec($sql);
            $sql = "INSERT INTO region (res_id,id,names) VALUES (600, 600, 'Апостолово')";
            $result = $db->exec($sql);
            $sql = "INSERT INTO region (res_id,id,names) VALUES (700, 700, 'Гвардійське')";
            $result = $db->exec($sql);
            $sql = "INSERT INTO region (res_id,id,names) VALUES (800, 800, 'Інгулець')";
            $result = $db->exec($sql);
            // Копируем базу в папку РЭСа
            copy('LS.db','./data/'.$res_q.'/LS.db');
//            debug('Базу сформовано');
            $model = new info();
            $model->title = 'Увага!';
            $model->info1 = "Базу для завдання контролера для фотофіксації лічильників сформовано.";
            $model->style1 = "d15";
            $model->style2 = "info-text";
            $model->style_title = "d9";

            return $this->render('about', [
                'model' => $model]);
        }
    else {
            return $this->render('upload_file_photo', [
                'model' => $model,
            ]);
        }
    }

    // Просмотр задублированных заявок для программы auto
    public function actionAutodoublez($date1,$date2)
    {
//        $model = new trz();
//        $sql = "select a.* from trz a";

            $sql = "select a.*,b.kol from vw_tzr a
                        left join 
                        (SELECT trzDdate,gos_nom,model,count(*) as kol  FROM vw_tzr
                        group by 1,2,3
                        having count(*)>1) b on a.trzDdate=b.trzDdate and a.gos_nom=b.gos_nom
                        where concat(cast(a.trzddate as char(10)),a.gos_nom) in(
                        select concat(cast(trzddate as char(10)),gos_nom) from (
                        SELECT trzDdate,gos_nom,model,count(*) as kol  FROM vw_tzr
                        group by 1,2,3
                        having count(*)>1
                        ) q)
                        and  a.trzDdate>='$date1' and a.trzDdate<='$date2'
                        order by trzddate desc,gos_nom";

            $data = trz::findbysql($sql)
                ->all();

//            debug($sql);
//            return;

        $searchModel = new trz();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $sql);
//            debug($sql);
//            return;
        $dataProvider->pagination = false;
        $date1 = date("d.m.Y", strtotime($date1));
        $date2 = date("d.m.Y", strtotime($date2));

            return $this->render('double_z',
                ['model' => $searchModel,'dataProvider' => $dataProvider,'searchModel' => $searchModel,
                    'date1' => $date1,
                    'date2' => $date2,
                    'sql' => $sql]);

    }


    // Сброс в Excel дублей заявок [auto]
    public function actionAutodouble2excel()
    {
        $sql=Yii::$app->request->post('data');
        $model = trz::findBySql($sql)->asarray()->all();
        $dataProvider = new ActiveDataProvider([
            'query' => trz::findBySql($sql),
            'pagination' => [
                'pageSize' => 500,
            ],
        ]);

        $cols = [
            'trzDdate' => 'Дата заявки',
//            'MODEL' => 'Модель',
//            'GOS_NOM' => 'Державний №',
            'cel' => 'Мета виїзду',
            'marshrut' => 'Маршрут',
            'marshrut_km' => 'Відстань, км',
            'note' => 'Примітка',
            'note_res' => 'Примітка РЕМ',
            'kol' => 'Кількість заявок',
        ];

        // Формирование массива названий колонок
        $list='';  // Список полей для сброса в Excel
        $h=[];
        $i=0;

        $j=0;
        $col_e=[];
        foreach($model[0] as $k=>$v){
            $col="'".$k."'";
            $col_e[$j]=$k;
            $j++;
            if(in_array(trim($k), array_keys($cols), true)){
                $h[$i]['col']=$col;
                $i++;
            }
        }

        $k1='Дублі заявок';
        //  -----------------------------------------------------------------------------

//             Сброс в Excel

        // ----------------------------------------------------------------------------------------------

        $newQuery = clone $dataProvider->query;
        $models = $newQuery->all();
        \moonland\phpexcel\Excel::widget([
            'models' => $models,
            'mode' => 'export', //default value as 'export'
            'format' => 'Excel2007',
            'hap' => $k1,    //cтрока шапки таблицы
            'data_model' => 1,
//            'columns' => $h,
//            'columns' => $col_e,
            'columns' => [ 'trzDdate','MODEL','GOS_NOM','cel','marshrut','marshrut_km','note_res','note','sogl','kol'],
            'headers' => [ 'trzDdate' => 'Дата заявки','MODEL' => 'Модель','GOS_NOM' => 'Державний №','cel' => 'Мета виїзду','marshrut'=> 'Маршрут',
                'marshrut_km' => 'Відстань, км', 'note_res' => 'Примітка РЕМ',
                'note' => 'Примітка',  'sogl' => "Погодження логіст.",'kol' => 'Кількість заявок'],
//            'headers' => $cols
        ]);
        return;
    }

    // Сброс в Excel отчета по заявкам [auto]
    public function actionAutoviewz2excel()
    {
        $sql=Yii::$app->request->post('data');
        $model = trz::findBySql($sql)->asarray()->all();
        $dataProvider = new ActiveDataProvider([
            'query' => trz::findBySql($sql),
            'pagination' => [
                'pageSize' => 500,
            ],
        ]);

        $cols = [
            'trzDdate' => 'Дата заявки',
//            'MODEL' => 'Модель',
//            'GOS_NOM' => 'Державний №',
            'cel' => 'Мета виїзду',
            'marshrut' => 'Маршрут',
            'marshrut_km' => 'Відстань, км',
            'note' => 'Примітка',
            'note_res' => 'Примітка РЕМ',
            'kol' => 'Кількість заявок',
        ];

        // Формирование массива названий колонок
        $list='';  // Список полей для сброса в Excel
        $h=[];
        $i=0;

        $j=0;
        $col_e=[];
        foreach($model[0] as $k=>$v){
            $col="'".$k."'";
            $col_e[$j]=$k;
            $j++;
            if(in_array(trim($k), array_keys($cols), true)){
                $h[$i]['col']=$col;
                $i++;
            }
        }

        $k1='Звіт по заявкам';
        //  -----------------------------------------------------------------------------

//             Сброс в Excel

        // ----------------------------------------------------------------------------------------------

        $newQuery = clone $dataProvider->query;
        $models = $newQuery->all();
        \moonland\phpexcel\Excel::widget([
            'models' => $models,
            'mode' => 'export', //default value as 'export'
            'format' => 'Excel2007',
            'hap' => $k1,    //cтрока шапки таблицы
            'data_model' => 1,
//            'columns' => $h,
//            'columns' => $col_e,
            'columns' => [  'trzDdate',
                'name_pzay',
                'sogl',
                'name_res_ts',

                'FIO',
                'user_name',
                'cel',
                'MODEL',
                'GOS_NOM',
                'marshrut',
                'name_char',
                'name_gsm_o',
                'note',
                'note_res',
                'marshrut_km',],

            'headers' => [ 'trzDdate' => 'Дата заявки','name_pzay' => 'Тип заявки',
                'sogl' => 'Погоджено логіст.',
                'name_res_ts' => 'Погоджено РЕМ','FIO' => 'Подано',
                'user_name' => "Погоджено",'cel' => 'Мета виїзду', 'MODEL' => 'Модель',
                'GOS_NOM' => 'Державний №','marshrut'=> 'Маршрут',
                'name_char' => 'Вид ТЗ',
                'name_gsm_o' => 'Вид палива',
                'note' => 'Примітка',
                'note_res' => 'Примітка РЕМ',
                'marshrut_km' => 'Відстань, км'],
//            'headers' => $cols
        ]);
        return;
    }


    // Подгрузка улиц - происходит при наборе первых букв
    public function actionGet_search_street($name,$str)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $name1 = mb_strtolower($name,"UTF-8");
        $name2 = mb_strtoupper($name,"UTF-8");
        $n = strpos($str, ',');
        $town=substr($str,0,$n);
        $n1 = strpos($str, 'р-н');
        $district=trim(substr($str,$n+1,($n1-$n-1)));
        if (Yii::$app->request->isAjax) {
            $sql = 'select min(id) as id,street from spr_towns where street like '.'"%'.$name1.'%"'.
                    ' and length('.'"'.$name1.'")>3'.' and town='.'"'.$town.'"'.
                    ' and district='.'"'.$district.'"'.
                    ' group by street order by street';
             $cur = spr_towns::findBySql($sql)->all();

            return ['success' => true, 'cur' => $cur];

        }
    }


//    Страница о программе
    public function actionAbout()
    {
        $model = new info();
        $model->title = 'Звіти';
        $model->info1 = "Тут будуть наповнюватись різні звіти. Пункт на стадії розробки";
        $model->style1 = "d15";
        $model->style2 = "info-text";
        $model->style_title = "d9";

        return $this->render('about', [
            'model' => $model]);
    }

   // Добавление новых пользователей
    public function actionAddAdmin() {
        $model = User::find()->where(['username' => 'main'])->one();
        if (empty($model)) {
            $user = new User();
            $user->username = 'main';
            $user->email = 'sivtsov@cek.dp.ua';
            $user->setPassword('dlj[yjdtybt');
            $user->generateAuthKey();
            if ($user->save()) {
                echo 'good';
            }
        }
    }

// Выход пользователя
    public function actionLogout()
    {
        Yii::$app->user->logout();
       // return $this->goHome();
        Yii::$app->response->redirect(Url::to('/abnlegal/cek'));
    }
}
