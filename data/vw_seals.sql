/* Пломбы
состоит из 2х таблиц:
seals - таблица из отчетов САПа по пломбам - давал Алексей Овчинников.
seals_old - таблица из РЭСов с PostGreSQL (база abn), составлена из таблиц, извлеченных
из запроса (по каждому РЭСу):

select lic,scode,place,scat,dt_on,sernr from (
select *,case when nn>1 then trim(scode)||'_'||nn else trim(scode) end as plomb_num_t from (
select *,row_number() over(partition by scat,scode) as nn from (
select distinct cl.code as lic,a.id_paccnt,a.plomb_num as scode,b.place_plomb as place,coalesce(sp.short_name,'СЕЙФ-ПАКЕТ') as scat,a.id_type,a.dt_on,a.id,
                'I' as status,'3' as color,
                matotv.tab_nom_utmas as UTMAS,
                matotv.tab_nom_reper as REPER,
                substring(replace(a.dt_on::varchar, '-',''),1,8) as DPURCH,
                substring(replace(a.dt_on::varchar, '-',''),1,8) as dissue,
                substring(replace(a.dt_on::varchar, '-',''),1,8) as dinst,
                w.num_meter as sernr,d.matnr as matnr,const.ver,w.id_type_meter
                from clm_plomb_tbl a
                left join 
               -- (select id_paccnt,num_meter,max(id_type_meter) as id_type_meter,max(work_period) as work_period from clm_meterpoint_tbl group by id_paccnt,num_meter) w
                (select a.* from clm_meterpoint_tbl a
		left join clm_meter_zone_h b on a.id=b.id_meter where b.dt_e is null) w
                on w.id_paccnt=a.id_paccnt
                left join eqi_meter_tbl f on w.id_type_meter=f.id
                left join sap_plomb_place b on
                a.id_place=b.idcek::integer
                left join plomb_type c on
                a.id_type=c.id
                left join (select distinct id as id,sap_meter_id from sap_meter) s on s.id::integer=w.id_type_meter
                left join (select distinct sap_meter_id,sap_meter_name,group_schet from sap_device22 where sap_meter_id<>'') sd on s.sap_meter_id=sd.sap_meter_id
                -- left join sap_equi d on
                inner join sap_equi d on
                trim(w.num_meter)=trim(d.sernr) and upper(trim(d.matnr))=upper(trim(sd.sap_meter_name))
                inner join sap_const const on 1=1
                left join sap_plomb_name sp on sp.id_cek::integer=a.id_type
                left join clm_paccnt_tbl cl on cl.id=a.id_paccnt
                inner join seals_matotv matotv on 1=1 and matotv.res=2
                where dt_off is null and length(a.plomb_num) <= 15 
		         and cl.archive=0 
		        -- and w.num_meter='10682627'
		        -- and
                ) g
                ) gg
                ) ggg

В виде vw_seаls учтено, что если нет данных из отчетов (таблица seals), тогда
данные берутся со старой системы (с базы abn - таблица seals_old)
Для актуальности данных необходимо периодически таблицу seals обновлять.

 */

create view vw_seals as
select * from (
SELECT 1 as vid,lic,code,place,category,date_install,sn,fio_otv,date_off,fio_off,status,date_del FROM seals 
union ALL
select 2 as vid,lic,scode as code,place,
scat as category,dt_on as date_install,sernr as sn,'' as fio_otv,
    '' as date_off,'' as fio_off,'' as status,'' as date_del from seals_old 
where lic not in (select lic from seals)    
) q 
