<?php

namespace app\controllers;
//namespace yii\base;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\InputDataForm;
use app\models\Calc;
use app\models\spr_res;
use app\models\spr_const;
use app\models\vspr_res_koord;
use app\models\spr_res_koord;
use app\models\data_con;
use app\models\spr_uslug;
use app\models\spr_towns;
use app\models\spr_client_adr;
use app\models\spr_client_other;
use app\models\spr_transp;
use app\models\sprtransp;
use app\models\client;
use app\models\klient;
use app\models\find_cl;
use app\models\area;
use app\models\status_con;
use app\models\requerstsearch;

class SpravController extends Controller
{
   public $spr='0';
    
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

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ]

        ];
    }


// Справочник услуг
    public function actionSprav_uslug()
    {
        $model = new spr_uslug();
        $model = $model::find()->all();
        $dataProvider = new ActiveDataProvider([
            'query' => spr_uslug::find(),
        ]);
        $dataProvider->pagination->route = '/sprav/sprav_uslug';
        $dataProvider->sort->route = '/sprav/sprav_uslug';

        return $this->render('sprav_uslug', [
            'model' => $model,'dataProvider' => $dataProvider
        ]);
    }
    // Справочник РЭСов
    public function actionSprav_res()
    {
        $model = new spr_res();
        $model = $model::find()->all();
        $dataProvider = new ActiveDataProvider([
         'query' => spr_res::find(),
        ]); 
        $dataProvider->pagination->route = '/sprav/sprav_res';
        $dataProvider->sort->route = '/sprav/sprav_res';
        
            return $this->render('sprav_res', [
                'model' => $model,'dataProvider' => $dataProvider
            ]);
    }
    
    // Справочник ответственных лиц по РЄСам
    public function actionSprav_spr_res_koord()
    {
        $model = new vspr_res_koord();
        $model = $model::find()->all();
        $dataProvider = new ActiveDataProvider([
         'query' => vspr_res_koord::find(),
        ]); 
        $dataProvider->pagination->route = '/sprav/sprav_spr_res_koord';
        $dataProvider->sort->route = '/sprav/sprav_spr_res_koord';
        
            return $this->render('sprav_spr_res_koord', [
                'model' => $model,'dataProvider' => $dataProvider
            ]);
    }
    
    // Справочник ставок на присоединение
    public function actionSprav_data_con()
    {
        $model = new data_con();
        $searchModel = new data_con();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model = $model::find()->orderBy(['power_stage' => SORT_ASC])
                ->orderBy(['rank' => SORT_DESC])->orderBy(['town' => SORT_DESC])->all();
       
            return $this->render('sprav_data_con', [
                'model' => $searchModel,'dataProvider' => $dataProvider,'searchModel' => $searchModel,
            ]);
    }

    // Справочник транспорта
    public function actionSprav_transp()
    {
        $searchModel = new spr_transp();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            return $this->render('sprav_transp', [
                'model' => $searchModel,'dataProvider' => $dataProvider,'searchModel' => $searchModel,
            ]);
    }

    // Справочник статусов заявки
    public function actionStatus_con()
    {
        $searchModel = new Status_con();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('status_con', [
            'model' => $searchModel,'dataProvider' => $dataProvider,'searchModel' => $searchModel,
        ]);
    }

    // Справочник констант
    public function actionSprav_const()
    {
        $searchModel = new spr_const();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('spr_const', [
            'model' => $searchModel,'dataProvider' => $dataProvider,'searchModel' => $searchModel,
        ]);
    }


    //  Происходит после нажатия на кнопку поиска в справочнике потребителей
    public function actionFind_cl($sql='0')
    {
        if($sql=='0') {
            $model = new Find_cl();
            if ($model->load(Yii::$app->request->post())) {

                $searchModel = new area();
                // Создание поискового sql выражения
                $where = ' 1=1 ';

                if ($model->re==true) {
                    $where .= ' and w.re=' . $model->re;
                }
                if (!empty($model->id_client)) {
                    $where .= ' and a.id_client=' . $model->id_client;
                }
                if (!empty($model->lic_sch))
                    $where .= ' and a.lic_sch like ' . "'%".$model->lic_sch."%'";
                if (!empty($model->short_cl))
                    $where .= ' and lower(a.name_s) like ' . "'%".mb_strtolower($model->short_cl,"UTF-8")."%'";
                if (!empty($model->name_cl))
                    $where .= ' and lower(a.name_f) like ' . "'%".mb_strtolower($model->name_cl,"UTF-8")."%'";
                if (!empty($model->num_cnt))
                    $where .= ' and a.num_cnt like ' . "'%".$model->num_cnt."%'";
                if (!empty($model->date_cnt))
                    $where .= ' and a.date_cnt=' . "'".$model->date_cnt."'";
                if (!empty($model->tel))
                    $where .= ' and (a.tel like ' . "'%".$model->tel."%'" .' or a.tel_work like ' . "'%".$model->tel."%')" ;
                if (!empty($model->adr_old))
                    $where .= ' and (lower(a.adr_old) like ' . "'%".mb_strtolower($model->adr_old,"UTF-8")."%'" .
                        ' or lower(a.addr) like ' . "'%".mb_strtolower($model->adr_old,"UTF-8")."%')" ;

                if (!empty($model->eis))
                    $where .= ' and r.num_eqp like ' . "'%".$model->eis."%'";

                if ((!empty($model->zpower) || trim($model->zpower) === '0') && !empty($model->power)) {
                    $sign = f_sign($model->zpower);
                    $where .= ' and w.power' . $sign . $model->power;
                }
                if (empty($model->zpower) && !empty($model->power)) {
                    $sign = '=';
                    $where .= ' and w.power' . $sign . $model->power;
                }
                if ((!empty($model->zeerm) || trim($model->zeerm) === '0') && !empty($model->eerm)) {
                    $sign = f_sign($model->zeerm);
                    $where .= ' and w.eerm' . $sign . $model->eerm;
                }
                if (empty($model->zeerm) && !empty($model->eerm)) {
                    $sign = '=';
                    $where .= ' and w.eerm' . $sign . $model->eerm;
                }
                if ((!empty($model->zhour_month) || trim($model->zhour_month) === '0') && !empty($model->hour_month)) {
                    $sign = f_sign($model->zhour_month);
                    $where .= ' and w.hour_month' . $sign . $model->hour_month;
                }
                if (empty($model->zhour_month) && !empty($model->hour_month)) {
                    $sign = '=';
                    $where .= ' and w.hour_month' . $sign . $model->hour_month;
                }
                if ((!empty($model->zkoef_tr) || trim($model->zkoef_tr) === '0') && !empty($model->koef_tr)) {
                    $sign = f_sign($model->zkoef_tr);
                    $where .= ' and w.koef_tr' . $sign . $model->koef_tr;
                }
                if (empty($model->zkoef_tr) && !empty($model->koef_tr)) {
                    $sign = '=';
                    $where .= ' and w.koef_tr' . $sign . $model->koef_tr;
                }
                if ((!empty($model->zvalue_act) || trim($model->zvalue_act) === '0') && !empty($model->value_act)) {
                    $sign = f_sign($model->zvalue_act);
                    $where .= ' and e.potr_act' . $sign . $model->value_act;
                }
                if (empty($model->zvalue_act) && !empty($model->value_act)) {
                    $sign = '=';
                    $where .= ' and e.potr_act' . $sign . $model->value_act;
                }
                if ((!empty($model->zvalue_react) || trim($model->zvalue_react) === '0') && !empty($model->value_react)) {
                    $sign = f_sign($model->zvalue_react);
                    $where .= ' and e.potr_react' . $sign . $model->value_react;
                }
                if (empty($model->zvalue_react) && !empty($model->value_react)) {
                    $sign = '=';
                    $where .= ' and e.potr_react' . $sign . $model->value_react;
                }
                if ((!empty($model->zvalue_gen) || trim($model->zvalue_gen) === '0') && !empty($model->value_gen)) {
                    $sign = f_sign($model->zvalue_gen);
                    $where .= ' and e.potr_gen' . $sign . $model->value_gen;
                }
                if (empty($model->zvalue_gen) && !empty($model->value_gen)) {
                    $sign = '=';
                    $where .= ' and e.potr_gen' . $sign . $model->value_gen;
                }
                if ((!empty($model->zsub) || trim($model->zsub) === '0') && !empty($model->sub)) {
                    $sign = f_sign($model->zsub);
                    $where .= ' and b.kol' . $sign . $model->sub;
                }
                if (empty($model->zsub) && !empty($model->sub)) {
                    $sign = '=';
                    $where .= ' and b.kol' . $sign . $model->sub;
                }
                $flag_tu=0;
                if ((!empty($model->ztu) || trim($model->ztu) === '0') && !empty($model->tu)) {
                    $sign_tu = f_sign($model->ztu);
                    $flag_tu=1;
                }
                if (empty($model->ztu) && !empty($model->tu)) {
                    $sign_tu = '=';
                    $flag_tu=1;
                }

                $sql = "select distinct v.tel_work,v.num_cnt,v.date_cnt,v.client_main as id_client,v.adr_old,v.addr,v.lic_sch,v.name_s,v.name_f,v.tel,v.tel_work,v.email,
v.flg as flag_budjet,v.dti as dt_indicat,v.edrpou,count(v.code_tu) as kol_tu,v.kol from
(select a.*,c.*,b.kol,e.potr_act,e.potr_react,e.potr_gen,w.*,r.num_eqp as eis,a.flag_budjet as flg,a.dt_indicat as dti  from vw_client a
left join
(Select tr.id_client,count(*) as kol
                from eqm_tree_tbl tr
                left join eqm_eqp_tree_tbl AS tt on tr.id=tt.id_tree
                JOIN eqm_equipment_tbl AS eq ON (tt.code_eqp=eq.id)
                JOIN (eqi_device_kinds_tbl AS dk JOIN eqi_device_kinds_prop_tbl AS dkp ON (dk.id=dkp.type_eqp)) ON (eq.type_eqp=dk.id)
                left join eqm_borders_tbl as b on (b.code_eqp=eq.id) 
                left join clm_client_tbl as cl on (cl.id=b.id_clientb) 
                WHERE  b.id_clientb is not null and b.id_clientb<>tr.id_client
                group by tr.id_client) b
                 on a.id_client=b.id_client 
left join clm_statecl_tbl c on
a.id_client=c.id_client 
left join 
(select z.id_client,sum(potr_act) as potr_act,sum(potr_react) as potr_react,sum(potr_gen) as potr_gen from
(select h.*,case when h.vid_e=1 then case when u.value_diff is null then u.value else value_diff end end as potr_act,
case when h.vid_e=2 then case when u.value_diff is null then u.value else value_diff end end as potr_react,
case when h.vid_e=3 then case when u.value_diff is null then u.value else value_diff end end as potr_gen
from
(select max(a1.date) as date,a1.id_client,a1.vid_e 
from legal_indic a1
group by 2,3) h
join legal_indic u on
u.id_client=h.id_client and u.date=h.date and u.vid_e=h.vid_e) z 
--where z.id_client=12768
group by z.id_client) e on
e.id_client=a.id_client
left join get_datainput(a.id_client) w on
w.client_main=a.id_client
left join 
eqm_equipment_tbl r on w.code_tu=r.id where " . $where ;

                $sql.= ') as v
                group by v.client_main,v.lic_sch,v.name_s,v.name_f,v.tel,v.edrpou,v.kol,
                v.adr_old,v.addr,v.tel_work,v.email,v.flg,v.dti,v.num_cnt,v.date_cnt,v.tel_work';

                if($flag_tu==1) {
                    $sql .= ' having count(v.code_tu)' . $sign_tu . $model->tu;
                }
               // debug($flag_tu);
//                debug($sql);
//                return;

                $data = area::findBySql($sql)->all();
                $kol = count($data);
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $sql);
                $dataProvider->pagination = false;

                return $this->render('sprav_сlient', [
                    'model' => $searchModel,'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel,'q' => $kol
                ]);
            } else {

                return $this->render('inputfind_cl', [
                    'model' => $model
                ]);
            }

        }
        else{
            // Если передается параметр $sql
            $data = tovar::findBySql($sql)->all();
            $searchModel = new tovar();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $sql);
            $kol = count($data);

            $session = Yii::$app->session;
            $session->open();
            $session->set('view', 1);

            return $this->render('ost', ['model' => $data,
                'dataProvider' => $dataProvider, 'searchModel' => $searchModel, 'kol' => $kol, 'sql' => $sql]);
        }
    }


    // Справочник потребителей
    public function actionSprav_client()
    {
        $searchModel = new Client();
        $query = client::find()->all();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination = false;
//        debug($dataProvider);
//        return;
        $kol = $dataProvider->query->count();
        return $this->render('sprav_сlient', [
            'model' => $searchModel,'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,'q' => $kol
        ]);
    }
    
//    Удаление записей из справочника
    public function actionDelete($id,$mod)
    {   // $id  id записи
        // $mod - название модели
        if($mod=='spr_res')
        $model = spr_res::findOne($id);
        if($mod=='sprtransp')
        $model = sprtransp::findOne($id);
        if($mod=='spr_const')
        $model = spr_const::findOne($id);
        if($mod=='sprklient') {
            $model = Klient::find()->where('id=:id',[':id'=>$id])->one();

            if(!empty($model->id_adr)) {
                $model1 = Spr_client_adr::find()->where('id_adr=:id', [':id' => $model->id_adr])->one();
                $model1->delete();
            }
//            $model2 = Spr_client_other::find()->where('id_client=:id', [':id' => $model->id_client])->one();
//            if(!empty($model2)) $model2->delete();
            $model->delete();
        }
        if($mod=='status_con')
            $model = status_con::findOne($id);
        if($mod=='spr_res_koord')
            $model = spr_res_koord::findOne($id);

        if($mod<>'sprklient')
            $model->delete();
        
        if($mod=='spr_res')
        return $this->redirect(['sprav/sprav_res']);
        if($mod=='sprtransp')
        return $this->redirect(['sprav/sprav_transp']);
        if($mod=='spr_const')
        return $this->redirect(['sprav/sprav_const']);
        if($mod=='sprklient')
            return $this->redirect(['sprav/sprav_client']);
        if($mod=='status_con')
            return $this->redirect(['sprav/status_con']);
        if($mod=='spr_res_koord')
            return $this->redirect(['sprav/sprav_spr_res_koord']);

    }

//    Обновление записей из справочника
    public function actionUpdate($id,$mod)
    {
        // $id  id записи
        // $mod - название модели
        if($mod=='spr_res')
        $model = spr_res::findOne($id);
        if($mod=='sprtransp')
        $model = sprtransp::findOne($id);
        if($mod=='spr_const')
        $model = spr_const::findOne($id);
        if($mod=='sprklient')
            $model = Client::find()->where('id=:id',[':id'=>$id])->one();
        if($mod=='status_con')
            $model = status_con::findOne($id);
        if($mod=='spr_res_koord')
            $model = spr_res_koord::findOne($id);

        if ($model->load(Yii::$app->request->post()))
        {

            if($mod=='sprklient') {
                $model1 = Klient::find()->where('id=:id', [':id' => $id])->one();
                $model1->edrpou = $model->edrpou;
                $model1->name_f = $model->name_f;
                $model1->name_s = $model->name_s;
                $model1->lic_sch = $model->lic_sch;
                $model1->add_name = $model->add_name;
                $model1->idk_work = $model->idk_work;
                $model1->id_state = $model->id_state;


                if (empty($model->id_adr)) {
                    $model2 = new Spr_client_adr();
                    $model2->id_town = $model->id_street;
                } else {
                    $model2 = Spr_client_adr::find()->where('id_adr=:id', [':id' => $model->id_adr])->one();
                    //$model->id_street=$id_town;
                }

                $model2->town = $model->town;
                $model2->house = $model->house;
                $model2->korp = $model->korp;
                $model2->flat = $model->flat;
                $model2->id_street = $model->id_street;
                $model2->id_adr = $model->id_client;
                //$model2->id_town = $model->id_street;
                $model2->id_town = $model->id_town;
                $model1->id_adr = $model->id_client;

                $model3 = Spr_client_other::find()->where('id_client=:id', [':id' => $model->id_client])->one();
                if (empty($model3))
                    $model3 = new Spr_client_other();

                $model3->e_mail = $model->email;
                $model3->doc_dat = $model->date_cnt;
                $model3->phone = $model->tel;
                $model3->flag_budjet = $model->flag_budjet;
                $model3->dt_start = $model->dt_start;
                $model3->dt_indicat = $model->dt_indicat;
                $model3->id_client = $model->id_client;
//            debug($model->dt_indicat);
//            return;

                if (!$model1->save()) {
                    $model1->validate();
                    print_r($model1->getErrors());
                    return;
                }

                if (!$model2->save()) {
                    $model2->validate();
                    print_r($model2->getErrors());
                    return;
                }

                if (!$model3->save()) {
                    $model3->validate();
                    print_r($model3->getErrors());
                    return;
                }
            }
            else
                if (!$model->save()) {
                    $model->validate();
                    print_r($model->getErrors());
                    return;
                }

            if($mod=='spr_res')
                return $this->redirect(['sprav/sprav_res']);
            if($mod=='sprtransp')
                return $this->redirect(['sprav/sprav_transp']);
            if($mod=='spr_const')
                return $this->redirect(['sprav/sprav_const']);
            if($mod=='sprklient')
                return $this->redirect(['sprav/sprav_client']);
            if($mod=='status_con')
                return $this->redirect(['sprav/status_con']);
            if($mod=='spr_res_koord')
                return $this->redirect(['sprav/sprav_spr_res_koord']);
            
        } else {
            if($mod=='spr_res')
            return $this->render('update_res', [
                'model' => $model,

            ]);
            if($mod=='spr_data_con')
            return $this->render('update_data_con', [
                'model' => $model,

            ]);
            if($mod=='sprtransp')
            return $this->render('update_transp', [
                'model' => $model,

            ]);
            if($mod=='sprklient')
                return $this->render('update_klient', [
                    'model' => $model,

                ]);

            if($mod=='spr_const')
                return $this->render('update_spr_const', [
                    'model' => $model,

                ]);
            if($mod=='spr_res_koord')
                return $this->render('update_spr_res_koord', [
                    'model' => $model,

                ]);
        }
    }
//    Срабатывает при нажатии кнопки добавления РЭСа
     public function actionCreateres()
    {
        
        $model = new spr_res();
       
        if ($model->load(Yii::$app->request->post()))
        {  
                       
            if($model->save(false)) //var_dump($model->getErrors());
               return $this->redirect(['sprav/sprav_res']);
           
        } else {
           
            return $this->render('update_res', [
                'model' => $model]);
        }
    }

    //    Срабатывает при нажатии кнопки добавления статуса заявки
    public function actionCreatestatus_con()
    {
        $model = new status_con();

        if ($model->load(Yii::$app->request->post()))
        {
            if($model->save(false)) //var_dump($model->getErrors());
                return $this->redirect(['sprav/status_con']);
        } else {

            return $this->render('update_status_con', [
                'model' => $model]);
        }
    }

    //    Срабатывает при нажатии кнопки добавления в справ. транспорта
    public function actionCreatetransp()
    {
        
        $model = new sprtransp();
       
        if ($model->load(Yii::$app->request->post()))
        {  
            if($model->save(false))
               return $this->redirect(['sprav/sprav_transp']);
        } else {
           
            return $this->render('update_transp', [
                'model' => $model]);
        }
    }
    
    //    Срабатывает при нажатии кнопки добавления в справ. отв. лиц
    public function actionCreatekoord()
    {
        
        $model = new spr_res_koord();
       
        if ($model->load(Yii::$app->request->post()))
        {  
            if($model->save(false))
               return $this->redirect(['sprav/sprav_spr_res_koord']);
        } else {
           
            return $this->render('update_spr_res_koord', [
                'model' => $model]);
        }
    }

    //    Срабатывает при нажатии кнопки добавления в справ. работ
    public function actionCreatedata_con()
    {
        $model = new spr_work();
        if ($model->load(Yii::$app->request->post()))
        {  
            if($model->save(false))
               return $this->redirect(['sprav/sprav_data_con']);
           
        } else {
           
            return $this->render('update_data_con', [
                'model' => $model]);
        }
    }

    //    Срабатывает при нажатии кнопки добавления в справ. констант
    public function actionCreateconstant()
    {
        $model = new spr_const();
        if ($model->load(Yii::$app->request->post()))
        {
            if($model->save(false))
                return $this->redirect(['sprav/sprav_const']);

        } else {

            return $this->render('update_spr_const', [
                'model' => $model]);
        }
    }

    //    Срабатывает при нажатии кнопки добавления в справ. потребителей
    public function actionCreateclient()
    {
        $model = new Client();
        if ($model->load(Yii::$app->request->post()))
        {   $sql = 'select max(id_client) as id_client from spr_client';
            $max = klient::findBySql($sql)->one();
            $max = $max->id_client+1;
            $model1 = new klient();
            $model1->edrpou = $model->edrpou;
            $model1->name_f = $model->name_f;
            $model1->name_s = $model->name_s;
            $model1->lic_sch = $model->lic_sch;
            $model1->add_name = $model->add_name;
            $model1->idk_work = $model->idk_work;
            $model1->id_state = $model->id_state;
            $model1->id_client = $max;
            $model1->id_adr = $max;

            $model2 = new Spr_client_adr();

            $model2->id_town = $model->id_street;
            $model2->town = $model->town;
            $model2->house = $model->house;
            $model2->korp = $model->korp;
            $model2->flat = $model->flat;
            $model2->id_street = $model->id_street;
            $model2->id_adr = $max;
            $model2->id_town = $model->id_town;

            $model3 = new Spr_client_other();

            $model3->e_mail = $model->email;
            $model3->doc_dat = $model->date_cnt;
            $model3->phone = $model->tel;
            $model3->flag_budjet = $model->flag_budjet;
            $model3->dt_start = $model->dt_start;
            $model3->dt_indicat = $model->dt_indicat;
            $model3->id_client = $max;

            if($model1->save(false)) {
                if(!$model2->save())
                {  $model2->validate();
                    print_r($model2->getErrors());
                    return;
                }

                if(!$model3->save())
                {  $model3->validate();
                    print_r($model3->getErrors());
                    return;
                }
                return $this->redirect(['sprav/sprav_client']);
            }
        } else {
            return $this->render('update_klient', [
                'model' => $model]);
        }
    }

    // Подгрузка населенных пунктов - происходит при наборе первых букв
    public function actionGet_search_town($name)
    {

        Yii::$app->response->format = Response::FORMAT_JSON;

        $c = mb_substr($name,0,1,"UTF-8");
        $code = ord($c);
        if($code<128) $name=recode_c(strtolower($name));

        $name1=ucfirst_ru($name);
        //$name1 = mb_strtolower($name,"UTF-8");
        $name2 = mb_strtoupper($name,"UTF-8");
        if (Yii::$app->request->isAjax) {
            $sql = 'select min(id) as id,trim(district) as district,trim(town) as town from spr_towns where (town like '."$$%".$name1."%$$".
                ' or town_ru like '."$$%".$name1."%$$)".' and length('."$$".$name1."$$)>2".' group by district,town order by town,district';
            $cur = spr_towns::findBySql($sql)->all();

            return ['success' => true, 'cur' => $cur];

        }
    }

    // Подгрузка населенных пунктов - происходит при наборе первых букв
    public function actionGet_search_town1($name)
    {

        Yii::$app->response->format = Response::FORMAT_JSON;

        $c = mb_substr($name,0,1,"UTF-8");
        $code = ord($c);
        if($code<128) $name=recode_c(strtolower($name));

        $name1=ucfirst_ru($name);
        //$name1 = mb_strtolower($name,"UTF-8");
        $name2 = mb_strtoupper($name,"UTF-8");
        if (Yii::$app->request->isAjax) {
            $sql = 'select min(id) as id,trim(town) as town from addr_sap where town like '."$$%".$name1."%$$".
               ' and length('."$$".$name1."$$)>2".' group by town order by town';
            $cur = spr_towns::findBySql($sql)->all();

            return ['success' => true, 'cur' => $cur];

        }
    }

    // Подгрузка улиц - происходит при наборе первых букв
    public function actionGet_search_street($name,$str)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $c = mb_substr($name,0,1,"UTF-8");
        $code = ord($c);
        if($code<128) $name=recode_c(strtolower($name));

        $name1 = mb_strtolower(trim($name),"UTF-8");
        $name1 = ucfirst_ru(trim($name));
        $n = strpos($str, ',');
        if($n>0)
            $town=substr($str,0,$n);
        else
            $town=$str;
        $n1 = strpos($str, 'р-н');
        if($n1>0)
            $district=trim(substr($str,$n+1,($n1-$n-1)));
        else
            $district='';
        if (Yii::$app->request->isAjax) {
            $sql = 'select min(id) as id,trim(street) as street from spr_towns where street like '."'%".$name1."%'".
                ' and length('."$$".$name1."$$)>2".' and town='."$$".$town."$$".
                ' and district='."$$".$district."$$".
                ' group by street order by street';
            //var_dump($sql);
            $cur = spr_towns::findBySql($sql)->all();

            return ['success' => true, 'cur' => $cur];

        }
    }

    // Подгрузка улиц - происходит при наборе первых букв
    public function actionGet_search_street1($name,$str)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $c = mb_substr($name,0,1,"UTF-8");
        $code = ord($c);
        if($code<128) $name=recode_c(strtolower($name));

        $name1 = mb_strtolower(trim($name),"UTF-8");
        $name1 = ucfirst_ru(trim($name));
        $n = strpos($str, ',');
        if($n>0)
            $town=substr($str,0,$n);
        else
            $town=$str;
        $n1 = strpos($str, 'р-н');
        if($n1>0)
            $district=trim(substr($str,$n+1,($n1-$n-1)));
        else
            $district='';
        if (Yii::$app->request->isAjax) {
            $sql = 'select min(id) as id,trim(street) as street from addr_sap where street like '."'%".$name1."%'".
                ' and length('."$$".$name1."$$)>2".' and town like '."$$".'%'.$town.'%'."$$".
                ' group by street order by street';
            //var_dump($sql);

//            return $sql;

            $cur = spr_towns::findBySql($sql)->all();

            return ['success' => true, 'cur' => $cur];

        }
    }




}
