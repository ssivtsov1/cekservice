Счетчики

Select eq.id,tt.name,tt.code_eqp,tt.code_eqp_e as code_eqp_p ,tt.name,eq.type_eqp,eq.num_eqp,tt.line_no, dkp.id_icon,cl.name,dk.*,
it.type,it.zones,it.carry,w.client
From eqm_eqp_tree_tbl AS tt 
JOIN eqm_equipment_tbl AS eq ON (tt.code_eqp=eq.id) 
JOIN (eqi_device_kinds_tbl AS dk JOIN eqi_device_kinds_prop_tbl AS dkp ON (dk.id=dkp.type_eqp)) ON (eq.type_eqp=dk.id)
 left join eqm_borders_tbl as b on (b.code_eqp=eq.id) left join clm_client_tbl as cl on (cl.id=b.id_clientb)
 left join eqm_meter_tbl as q on q.code_eqp= tt.code_eqp
 join eqi_meter_tbl AS it on q.id_type_eqp=it.id
 left JOIN eqm_compens_station_inst_tbl AS cs ON (eq.id=cs.code_eqp_inst)
 left join (
 select cs.code_eqp,eq.id, eq.name_eqp,c.short_name as client
from eqm_equipment_tbl AS eq JOIN eqm_compens_station_inst_tbl AS cs ON (eq.id=cs.code_eqp_inst)
join eqi_device_kinds_tbl as dk on (eq.type_eqp = dk.id)
left join eqm_area_tbl as a on (a.code_eqp = eq.id)
left join clm_client_tbl as c on (c.id = a.id_client)) as w on
w.code_eqp=tt.code_eqp
 --left join eqm_area_tbl as pl on (pl.code_eqp = eq.id)
  WHERE id_tree in
  (select id_tree from eqm_eqp_tree_tbl a
  join eqm_equipment_tbl b on a.code_eqp=b.id
  left join eqm_borders_tbl as c on 
  (c.code_eqp=b.id)
  left join clm_client_tbl as cl on
  (cl.id=c.id_clientb)
  JOIN (eqi_device_kinds_tbl AS dk LEFT JOIN eqi_device_kinds_prop_tbl AS dkp ON (dkp.type_eqp=dk.id)) ON (b.type_eqp=dk.id)
  where cl.id = 10796 and lvl=1)
  
   and coalesce(cl.book,-1)=-1 --and dk.id = 1
  Order By tt.lvl,tt.line_no;



Все оборудование
Select eq.id,tt.name,tt.code_eqp,tt.code_eqp_e as code_eqp_p ,tt.name,eq.type_eqp,eq.num_eqp,tt.line_no, dkp.id_icon,cl.name,dk.*,
it.type,it.zones,it.carry
From eqm_eqp_tree_tbl AS tt 
JOIN eqm_equipment_tbl AS eq ON (tt.code_eqp=eq.id) 
JOIN (eqi_device_kinds_tbl AS dk JOIN eqi_device_kinds_prop_tbl AS dkp ON (dk.id=dkp.type_eqp)) ON (eq.type_eqp=dk.id)
 left join eqm_borders_tbl as b on (b.code_eqp=eq.id) left join clm_client_tbl as cl on (cl.id=b.id_clientb)
 left join eqm_meter_tbl as q on q.code_eqp= tt.code_eqp
 left join eqi_meter_tbl AS it on q.id_type_eqp=it.id
 
  WHERE id_tree in
  (select id_tree from eqm_eqp_tree_tbl a
  join eqm_equipment_tbl b on a.code_eqp=b.id
  left join eqm_borders_tbl as c on 
  (c.code_eqp=b.id)
  left join clm_client_tbl as cl on
  (cl.id=c.id_clientb)
  JOIN (eqi_device_kinds_tbl AS dk LEFT JOIN eqi_device_kinds_prop_tbl AS dkp ON (dkp.type_eqp=dk.id)) ON (b.type_eqp=dk.id)
  where cl.id = 10796 and lvl=1)
  
   and coalesce(cl.book,-1)=-1 --and dk.id = 1




Select eq.id,tt.name,tt.code_eqp,tt.code_eqp_e as code_eqp_p ,tt.name,eq.type_eqp,eq.num_eqp,tt.line_no, dkp.id_icon,cl.name,dk.*,
it.type,it.zones,it.carry,w.client,ktr.koef_tr,tu.d as eerm,tu.wtm as hour_month,tu.code_eqp as code_tu 
From eqm_eqp_tree_tbl AS tt 
JOIN eqm_equipment_tbl AS eq ON (tt.code_eqp=eq.id) 
JOIN (eqi_device_kinds_tbl AS dk JOIN eqi_device_kinds_prop_tbl AS dkp ON (dk.id=dkp.type_eqp)) ON (eq.type_eqp=dk.id)
 left join eqm_borders_tbl as b on (b.code_eqp=eq.id) left join clm_client_tbl as cl on (cl.id=b.id_clientb)
 left join eqm_meter_tbl as q on q.code_eqp= tt.code_eqp
 join eqi_meter_tbl AS it on q.id_type_eqp=it.id
 left JOIN eqm_compens_station_inst_tbl AS cs ON (eq.id=cs.code_eqp_inst)
 left join (
 select cs.code_eqp,eq.id, eq.name_eqp,c.short_name as client
from eqm_equipment_tbl AS eq JOIN eqm_compens_station_inst_tbl AS cs ON (eq.id=cs.code_eqp_inst)
join eqi_device_kinds_tbl as dk on (eq.type_eqp = dk.id)
left join eqm_area_tbl as a on (a.code_eqp = eq.id)
left join clm_client_tbl as c on (c.id = a.id_client)) as w on
w.code_eqp=tt.code_eqp
 --left join eqm_area_tbl as pl on (pl.code_eqp = eq.id)

left join 

(select code_eqp_up as code_eqp,max(koef_tr) as koef_tr,min(type) as type from
(select n2.code_eqp as code_eqp_up,n1.code_eqp,n1.k_tr*n2.k_tr as koef_tr,1 as type from
(Select eq.id,tt.name,tt.code_eqp,tt.code_eqp_e as code_eqp_p ,tt.name,eq.type_eqp,
case when y.voltage_nom is not null then y.voltage_nom/y.voltage2_nom else y.amperage_nom/y.amperage2_nom end ::integer as k_tr 
From eqm_eqp_tree_tbl AS tt 
JOIN eqm_equipment_tbl AS eq ON (tt.code_eqp=eq.id) 
JOIN (eqi_device_kinds_tbl AS dk JOIN eqi_device_kinds_prop_tbl AS dkp ON (dk.id=dkp.type_eqp)) ON (eq.type_eqp=dk.id)
 left join eqm_borders_tbl as b on (b.code_eqp=eq.id) left join clm_client_tbl as cl on (cl.id=b.id_clientb)
 left join eqm_meter_tbl as q on q.code_eqp= tt.code_eqp
 left join eqi_meter_tbl AS it on q.id_type_eqp=it.id
 left join 
 (select * from eqm_compensator_i_tbl AS dt JOIN eqi_compensator_i_tbl AS it ON(dt.id_type_eqp=it.id)) as y on
  y.code_eqp= tt.code_eqp 
  WHERE id_tree in
  (select id_tree from eqm_eqp_tree_tbl a
  join eqm_equipment_tbl b on a.code_eqp=b.id
  left join eqm_borders_tbl as c on 
  (c.code_eqp=b.id)
  left join clm_client_tbl as cl on
  (cl.id=c.id_clientb)
  JOIN (eqi_device_kinds_tbl AS dk LEFT JOIN eqi_device_kinds_prop_tbl AS dkp ON (dkp.type_eqp=dk.id)) ON (b.type_eqp=dk.id)
  where cl.id = 10687 and lvl=1)
     and coalesce(cl.book,-1)=-1 and eq.type_eqp=10) as n1
     join 
  (Select eq.id,tt.name,tt.code_eqp,tt.code_eqp_e as code_eqp_p ,tt.name,eq.type_eqp,
case when y.voltage_nom is not null then y.voltage_nom/y.voltage2_nom else y.amperage_nom/y.amperage2_nom end ::integer as k_tr 
From eqm_eqp_tree_tbl AS tt 
JOIN eqm_equipment_tbl AS eq ON (tt.code_eqp=eq.id) 
JOIN (eqi_device_kinds_tbl AS dk JOIN eqi_device_kinds_prop_tbl AS dkp ON (dk.id=dkp.type_eqp)) ON (eq.type_eqp=dk.id)
 left join eqm_borders_tbl as b on (b.code_eqp=eq.id) left join clm_client_tbl as cl on (cl.id=b.id_clientb)
 left join eqm_meter_tbl as q on q.code_eqp= tt.code_eqp
 left join eqi_meter_tbl AS it on q.id_type_eqp=it.id
 left join 
 (select * from eqm_compensator_i_tbl AS dt JOIN eqi_compensator_i_tbl AS it ON(dt.id_type_eqp=it.id)) as y on
  y.code_eqp= tt.code_eqp 
  WHERE id_tree in
  (select id_tree from eqm_eqp_tree_tbl a
  join eqm_equipment_tbl b on a.code_eqp=b.id
  left join eqm_borders_tbl as c on 
  (c.code_eqp=b.id)
  left join clm_client_tbl as cl on
  (cl.id=c.id_clientb)
  JOIN (eqi_device_kinds_tbl AS dk LEFT JOIN eqi_device_kinds_prop_tbl AS dkp ON (dkp.type_eqp=dk.id)) ON (b.type_eqp=dk.id)
  where cl.id = 10687 and lvl=1)
     and coalesce(cl.book,-1)=-1 and eq.type_eqp=10) as n2 on
     n1.code_eqp=n2.code_eqp_p   
     UNION
    Select tt.code_eqp as code_eqp_up,tt.code_eqp_e as code_eqp ,
case when y.voltage_nom is not null then y.voltage_nom/y.voltage2_nom else y.amperage_nom/y.amperage2_nom end ::integer as k_tr,2 as type 
From eqm_eqp_tree_tbl AS tt 
JOIN eqm_equipment_tbl AS eq ON (tt.code_eqp=eq.id) 
JOIN (eqi_device_kinds_tbl AS dk JOIN eqi_device_kinds_prop_tbl AS dkp ON (dk.id=dkp.type_eqp)) ON (eq.type_eqp=dk.id)
 left join eqm_borders_tbl as b on (b.code_eqp=eq.id) left join clm_client_tbl as cl on (cl.id=b.id_clientb)
 left join eqm_meter_tbl as q on q.code_eqp= tt.code_eqp
 left join eqi_meter_tbl AS it on q.id_type_eqp=it.id
 left join 
 (select * from eqm_compensator_i_tbl AS dt JOIN eqi_compensator_i_tbl AS it ON(dt.id_type_eqp=it.id)) as y on
  y.code_eqp= tt.code_eqp 
  WHERE id_tree in
  (select id_tree from eqm_eqp_tree_tbl a
  join eqm_equipment_tbl b on a.code_eqp=b.id
  left join eqm_borders_tbl as c on 
  (c.code_eqp=b.id)
  left join clm_client_tbl as cl on
  (cl.id=c.id_clientb)
  JOIN (eqi_device_kinds_tbl AS dk LEFT JOIN eqi_device_kinds_prop_tbl AS dkp ON (dkp.type_eqp=dk.id)) ON (b.type_eqp=dk.id)
  where cl.id = 10687 and lvl=1)
     and coalesce(cl.book,-1)=-1 and eq.type_eqp=10) as res 
     group by 1) as ktr on
     ktr.code_eqp=tt.code_eqp_e
   
 left join eqm_point_tbl tu on 
 tu.code_eqp = (
 Select eq.id
From eqm_eqp_tree_tbl AS tt 
JOIN eqm_equipment_tbl AS eq ON (tt.code_eqp=eq.id) 
JOIN (eqi_device_kinds_tbl AS dk JOIN eqi_device_kinds_prop_tbl AS dkp ON (dk.id=dkp.type_eqp)) ON (eq.type_eqp=dk.id)
 left join eqm_borders_tbl as b on (b.code_eqp=eq.id) left join clm_client_tbl as cl on (cl.id=b.id_clientb)
 left join eqm_meter_tbl as q on q.code_eqp= tt.code_eqp
 left join eqi_meter_tbl AS it on q.id_type_eqp=it.id
 
  WHERE id_tree in
  (select id_tree from eqm_eqp_tree_tbl a
  join eqm_equipment_tbl b on a.code_eqp=b.id
  left join eqm_borders_tbl as c on 
  (c.code_eqp=b.id)
  left join clm_client_tbl as cl on
  (cl.id=c.id_clientb)
  JOIN (eqi_device_kinds_tbl AS dk LEFT JOIN eqi_device_kinds_prop_tbl AS dkp ON (dkp.type_eqp=dk.id)) ON (b.type_eqp=dk.id)
  where cl.id = 10687 and lvl=1)
  and dk.id=12
   )
 
  WHERE id_tree in
  (select id_tree from eqm_eqp_tree_tbl a
  join eqm_equipment_tbl b on a.code_eqp=b.id
  left join eqm_borders_tbl as c on 
  (c.code_eqp=b.id)
  left join clm_client_tbl as cl on
  (cl.id=c.id_clientb)
  JOIN (eqi_device_kinds_tbl AS dk LEFT JOIN eqi_device_kinds_prop_tbl AS dkp ON (dkp.type_eqp=dk.id)) ON (b.type_eqp=dk.id)
  where cl.id = 10687 and lvl=1)
   and coalesce(cl.book,-1)=-1 --and dk.id = 1
  Order By tt.lvl,tt.line_no;   




CREATE OR REPLACE FUNCTION public.get_tu(
        integer,integer)
  RETURNS integer AS
$BODY$
  declare
   pcod Alias for $1;
   pcl Alias for $2;
   rcod  integer;
   t integer;
   t=1;
  begin

Select tt.code_eqp into rcod
From eqm_eqp_tree_tbl AS tt 
JOIN eqm_equipment_tbl AS eq ON (tt.code_eqp=eq.id) 
JOIN (eqi_device_kinds_tbl AS dk JOIN eqi_device_kinds_prop_tbl AS dkp ON (dk.id=dkp.type_eqp)) ON (eq.type_eqp=dk.id)
 WHERE id_tree in
  (select id_tree from eqm_eqp_tree_tbl a
  join eqm_equipment_tbl b on a.code_eqp=b.id
  left join eqm_borders_tbl as c on 
  (c.code_eqp=b.id)
  left join clm_client_tbl as cl on
  (cl.id=c.id_clientb)
  JOIN (eqi_device_kinds_tbl AS dk LEFT JOIN eqi_device_kinds_prop_tbl AS dkp ON (dkp.type_eqp=dk.id)) ON (b.type_eqp=dk.id)
  where cl.id = pcl and lvl=1) and dk=12

  if rcod=$1 then
	return rcod;
  endif;
 
  if rcod<>$1 then
	rcod = 0;
	t=1;
	LOOP
	Select tt.code_eqp into rcod
	From eqm_eqp_tree_tbl AS tt 
	JOIN eqm_equipment_tbl AS eq ON (tt.code_eqp=eq.id) 
	JOIN (eqi_device_kinds_tbl AS dk JOIN eqi_device_kinds_prop_tbl AS dkp ON (dk.id=dkp.type_eqp)) ON (eq.type_eqp=dk.id)
	 WHERE id_tree in
	  (select id_tree from eqm_eqp_tree_tbl a
	  join eqm_equipment_tbl b on a.code_eqp=b.id
	  left join eqm_borders_tbl as c on 
	  (c.code_eqp=b.id)
	  left join clm_client_tbl as cl on
	  (cl.id=c.id_clientb)
	  JOIN (eqi_device_kinds_tbl AS dk LEFT JOIN eqi_device_kinds_prop_tbl AS dkp ON (dkp.type_eqp=dk.id)) ON (b.type_eqp=dk.id)
	  where cl.id = $2 and lvl=1); 
	-- здесь производятся вычисления
		IF rcod=$1 THEN
			EXIT;  -- выход из цикла
		END IF;
	END LOOP;
   end if;		
	
  
  return  rcod;
  end;
  $BODY$
  LANGUAGE plpgsql STABLE
  COST 100;


----- Эксперимент----

select x1.code_eqp as code1,x2.code_eqp as code2,x3.code_eqp as code3,x4.code_eqp as code4,x5.code_eqp as code5,
x1.id as id_1,x2.id as id_2,x3.id as id_3,x4.id as id_4,x5.id as id_5 from
(Select tt.code_eqp,tt.code_eqp_e,dk.id 
From eqm_eqp_tree_tbl AS tt 
JOIN eqm_equipment_tbl AS eq ON (tt.code_eqp=eq.id) 
JOIN (eqi_device_kinds_tbl AS dk JOIN eqi_device_kinds_prop_tbl AS dkp ON (dk.id=dkp.type_eqp)) ON (eq.type_eqp=dk.id)
 WHERE id_tree in
  (select id_tree from eqm_eqp_tree_tbl a
  join eqm_equipment_tbl b on a.code_eqp=b.id
  left join eqm_borders_tbl as c on 
  (c.code_eqp=b.id)
  left join clm_client_tbl as cl on
  (cl.id=c.id_clientb)
  JOIN (eqi_device_kinds_tbl AS dk LEFT JOIN eqi_device_kinds_prop_tbl AS dkp ON (dkp.type_eqp=dk.id)) ON (b.type_eqp=dk.id)
  where cl.id = 10796 and lvl=1)) as x1
  join 
  (Select tt.code_eqp,tt.code_eqp_e,dk.id 
From eqm_eqp_tree_tbl AS tt 
JOIN eqm_equipment_tbl AS eq ON (tt.code_eqp=eq.id) 
JOIN (eqi_device_kinds_tbl AS dk JOIN eqi_device_kinds_prop_tbl AS dkp ON (dk.id=dkp.type_eqp)) ON (eq.type_eqp=dk.id)
 WHERE id_tree in
  (select id_tree from eqm_eqp_tree_tbl a
  join eqm_equipment_tbl b on a.code_eqp=b.id
  left join eqm_borders_tbl as c on 
  (c.code_eqp=b.id)
  left join clm_client_tbl as cl on
  (cl.id=c.id_clientb)
  JOIN (eqi_device_kinds_tbl AS dk LEFT JOIN eqi_device_kinds_prop_tbl AS dkp ON (dkp.type_eqp=dk.id)) ON (b.type_eqp=dk.id)
  where cl.id = 10796 and lvl=1)) as x2
  on x1.code_eqp=x2.code_eqp_e
  join 
  (Select tt.code_eqp,tt.code_eqp_e,dk.id 
From eqm_eqp_tree_tbl AS tt 
JOIN eqm_equipment_tbl AS eq ON (tt.code_eqp=eq.id) 
JOIN (eqi_device_kinds_tbl AS dk JOIN eqi_device_kinds_prop_tbl AS dkp ON (dk.id=dkp.type_eqp)) ON (eq.type_eqp=dk.id)
 WHERE id_tree in
  (select id_tree from eqm_eqp_tree_tbl a
  join eqm_equipment_tbl b on a.code_eqp=b.id
  left join eqm_borders_tbl as c on 
  (c.code_eqp=b.id)
  left join clm_client_tbl as cl on
  (cl.id=c.id_clientb)
  JOIN (eqi_device_kinds_tbl AS dk LEFT JOIN eqi_device_kinds_prop_tbl AS dkp ON (dkp.type_eqp=dk.id)) ON (b.type_eqp=dk.id)
  where cl.id = 10796 and lvl=1)) as x3
  on x2.code_eqp=x3.code_eqp_e
  join 
  (Select tt.code_eqp,tt.code_eqp_e,dk.id 
From eqm_eqp_tree_tbl AS tt 
JOIN eqm_equipment_tbl AS eq ON (tt.code_eqp=eq.id) 
JOIN (eqi_device_kinds_tbl AS dk JOIN eqi_device_kinds_prop_tbl AS dkp ON (dk.id=dkp.type_eqp)) ON (eq.type_eqp=dk.id)
 WHERE id_tree in
  (select id_tree from eqm_eqp_tree_tbl a
  join eqm_equipment_tbl b on a.code_eqp=b.id
  left join eqm_borders_tbl as c on 
  (c.code_eqp=b.id)
  left join clm_client_tbl as cl on
  (cl.id=c.id_clientb)
  JOIN (eqi_device_kinds_tbl AS dk LEFT JOIN eqi_device_kinds_prop_tbl AS dkp ON (dkp.type_eqp=dk.id)) ON (b.type_eqp=dk.id)
  where cl.id = 10796 and lvl=1)) as x4
  on x3.code_eqp=x4.code_eqp_e
  join 
  (Select tt.code_eqp,tt.code_eqp_e,dk.id 
From eqm_eqp_tree_tbl AS tt 
JOIN eqm_equipment_tbl AS eq ON (tt.code_eqp=eq.id) 
JOIN (eqi_device_kinds_tbl AS dk JOIN eqi_device_kinds_prop_tbl AS dkp ON (dk.id=dkp.type_eqp)) ON (eq.type_eqp=dk.id)
 WHERE id_tree in
  (select id_tree from eqm_eqp_tree_tbl a
  join eqm_equipment_tbl b on a.code_eqp=b.id
  left join eqm_borders_tbl as c on 
  (c.code_eqp=b.id)
  left join clm_client_tbl as cl on
  (cl.id=c.id_clientb)
  left JOIN (eqi_device_kinds_tbl AS dk LEFT JOIN eqi_device_kinds_prop_tbl AS dkp ON (dkp.type_eqp=dk.id)) ON (b.type_eqp=dk.id)
  where cl.id = 10796 and lvl=1)) as x5
  on x4.code_eqp=x5.code_eqp_e



--27.11.18

select a.*,b.value,b.value_diff,b.date,b.id_client from get_datainput(10327) a
                left join get_indic(10327,106057,1) b on
                a.code_eqp=b.code_eqp and b.id_client=10327 and b.code_eqp=106057
                where a.code_eqp=106057

select * from clm_client_tbl where name like '%освіта%'
select * from spr_client where name_s like '%освіта%'


--04.12.18
--Рассчет реактива:

CREATE OR REPLACE FUNCTION public.get_calc_reactiv(IN id_cl integer)
  RETURNS TABLE(eerm numeric, hour_month integer, pwr numeric, name character varying, code_tu integer, code_eqp integer, potr_act numeric, potr_react numeric, potr_gen numeric, tg_r numeric, tg_rp numeric, all_potr_react numeric, all_potr_gen numeric, ps numeric, pg numeric, all_ps numeric, all_pg numeric, p1 numeric, p2 numeric, p3 numeric) AS
$BODY$
Declare 
t numeric(14,5);
tg_norm numeric(14,2);

Begin

select value into t from spr_const where name_s='T';
select value into tg_norm from spr_const where name_s='Tg_norm';

RETURN QUERY
select *,(src7.p1+src7.p2) as p3
from 
-- Получаем p3
(select *,sum(case when src6.ps is null then 0 else src6.all_ps end + case when src6.all_pg is null then 0 else src6.all_pg end) OVER (PARTITION BY src6.code_tu) as p1,
ROUND(coalesce(src6.all_ps,0)*power((src6.tg_rp-0.25),2),2) AS p2
from
-- Получаем p1 и p2
(select *,case when ((src5.all_potr_react>999.99 or src5.all_potr_gen>999.99) and src5.pwr>16) then ROUND(src5.potr_react*src5.eerm*t,2)::numeric(14,2) else 0 end as ps,
case when ((src5.potr_react>999.99 or src5.potr_gen>999.99) and src5.pwr>16) then ROUND(src5.potr_gen*src5.eerm*t,2)::numeric(14,2) else 0 end as pg,
sum(case when ((src5.all_potr_react>999.99 or src5.all_potr_gen>999.99) and src5.pwr>16) then ROUND(src5.potr_react*src5.eerm*t,2)::numeric(14,2) else 0 end) OVER (PARTITION BY src5.code_tu) as all_ps,
sum(case when ((src5.potr_react>999.99 or src5.potr_gen>999.99) and src5.pwr>16) then ROUND(src5.potr_gen*src5.eerm*t,2)::numeric(14,2) else 0 end) OVER (PARTITION BY src5.code_tu) as all_pg
from
-- Получаем данные ps и pg
(select a.eerm,a.hour_month,a.power as pwr,a.name,src4.*,
sum(src4.potr_react) OVER (PARTITION BY src4.code_tu) as all_potr_react,
sum(src4.potr_gen) OVER (PARTITION BY src4.code_tu) as all_potr_gen
from get_datainput(id_cl) a
left join 
(select *,case when src3.tg_r>2 then 2 else src3.tg_r end as tg_rp
from
-- Получаем применяемый тангенс
(select *,case when src2.potr_act>0 then ROUND(src2.potr_react/src2.potr_act,2) else tg_norm end AS tg_r
from
-- Показания по видам энергии
(select src1.code_tu,src1.code_eqp,
sum(case when src1.vid_e=1 then src1.potr end) as potr_act,
sum(case when src1.vid_e=2 then src1.potr end) as potr_react,
sum(case when src1.vid_e=3 then src1.potr end) as potr_gen
from
-- Последние показания по потребителю
(select max(a.date) as date,a.code_tu,a.code_eqp,a.vid_e,case when a.value_diff is null and a.value>0 then a.value else value_diff end as potr 
from legal_indic a
where a.id_client=id_cl
group by 2,3,4,5) as src1
group by 1,2) as src2) as src3) as src4 on
a.code_tu=src4.code_tu) as src5) 
as src6)
as src7;

end;
$BODY$
  LANGUAGE plpgsql VOLATILE STRICT
  COST 100
  ROWS 1000;
ALTER FUNCTION public.get_calc_reactiv(integer)
  OWNER TO postgres;


----------------------------------------------------

Перенос записей в справочник клиентов

insert into spr_client(lic_sch,name_s,name_f,edrpou,id_client,adr_old,add_name,email,idk_work,id_state)
select c.code,c.short_name,c.name,c.code_okpo,c.id,a.full_adr,c.add_name,c.email,c.idk_work,c.id_state
from clm_client_tbl c left join 
adv_address_tbl a
on c.id_addres=a.id
----------------------------------------------------------
Заполнение таблицы area_prop

insert into area_prop(code_eqp,type_eqp)
select id as code_eqp,1 as type_eqp from eqm_equipment_tbl where type_eqp=12 

-----------------------------------------------------------------


-- Function: public.get_datainput(integer)

-- DROP FUNCTION public.get_datainput(integer);

CREATE OR REPLACE FUNCTION public.get_datainput(IN id_cl integer)
  RETURNS TABLE(id integer, name character varying, code_eqp integer, num_eqp character varying, type character varying, zones integer, carry integer, client character varying, koef_tr integer, eerm numeric, hour_month integer, code_tu integer, power numeric, nm character varying, re integer, gen integer, code_area integer, name_area character varying, client_main integer, client_sub integer, sub integer) AS
$BODY$
select res1.id,name,res1.code_eqp,res1.num_eqp,type,zones,carry,client,koef_tr,
case when eerm is null then tu1.d::dec else eerm end as eerm,
case when hour_month is null then tu1.wtm else hour_month end as hour_month,
code_tu,res1.power,nm,re,gen,
area.code_eqp_inst as code_area,eq2.name_eqp as name_area,$1 as client_main,u.id_client as client_sub,
case when u.id_client<>$1 then 1 else 0 end as sub 
from
(
select id,name,res.code_eqp,num_eqp,type,zones,carry,client,koef_tr,eerm,hour_month,
case when code_tu is not null then code_tu else tu1.code_eqp end as code_tu,
case when res.power is not null then res.power else tu1.power end as power,
nm,coalesce(kind.kind_energy/kind.kind_energy,0) as re,coalesce(kind2.kind_energy/kind2.kind_energy,0) as gen
from
(Select eq.id,tt.name,tt.code_eqp,eq.num_eqp,
it.type,it.zones,it.carry,w.client,ktr.koef_tr,tu.d::dec as eerm,tu.wtm as hour_month,
tu.code_eqp as code_tu,
tu.power,dk.name as nm
From eqm_eqp_tree_tbl AS tt 
JOIN eqm_equipment_tbl AS eq ON (tt.code_eqp=eq.id) 
JOIN (eqi_device_kinds_tbl AS dk JOIN eqi_device_kinds_prop_tbl AS dkp ON (dk.id=dkp.type_eqp)) ON (eq.type_eqp=dk.id)
 left join eqm_borders_tbl as b on (b.code_eqp=eq.id) left join clm_client_tbl as cl on (cl.id=b.id_clientb)
 left join eqm_meter_tbl as q on q.code_eqp= tt.code_eqp
 join eqi_meter_tbl AS it on q.id_type_eqp=it.id
 left JOIN eqm_compens_station_inst_tbl AS cs ON (eq.id=cs.code_eqp_inst)
 left join (
 select cs.code_eqp,eq.id, eq.name_eqp,c.short_name as client
from eqm_equipment_tbl AS eq JOIN eqm_compens_station_inst_tbl AS cs ON (eq.id=cs.code_eqp_inst)
join eqi_device_kinds_tbl as dk on (eq.type_eqp = dk.id)
left join eqm_area_tbl as a on (a.code_eqp = eq.id)
left join clm_client_tbl as c on (c.id = a.id_client)) as w on
w.code_eqp=tt.code_eqp
 --left join eqm_area_tbl as pl on (pl.code_eqp = eq.id)

left join 

(select code_eqp_up as code_eqp,max(koef_tr) as koef_tr,min(type) as type from
(select n2.code_eqp as code_eqp_up,n1.code_eqp,n1.k_tr*n2.k_tr as koef_tr,1 as type from
(Select eq.id,tt.name,tt.code_eqp,tt.code_eqp_e as code_eqp_p ,tt.name,eq.type_eqp,
case when y.voltage_nom is not null then y.voltage_nom/y.voltage2_nom else y.amperage_nom/y.amperage2_nom end ::integer as k_tr 
From eqm_eqp_tree_tbl AS tt 
JOIN eqm_equipment_tbl AS eq ON (tt.code_eqp=eq.id) 
JOIN (eqi_device_kinds_tbl AS dk JOIN eqi_device_kinds_prop_tbl AS dkp ON (dk.id=dkp.type_eqp)) ON (eq.type_eqp=dk.id)
 left join eqm_borders_tbl as b on (b.code_eqp=eq.id) left join clm_client_tbl as cl on (cl.id=b.id_clientb)
 left join eqm_meter_tbl as q on q.code_eqp= tt.code_eqp
 left join eqi_meter_tbl AS it on q.id_type_eqp=it.id
 left join 
 (select * from eqm_compensator_i_tbl AS dt JOIN eqi_compensator_i_tbl AS it ON(dt.id_type_eqp=it.id)) as y on
  y.code_eqp= tt.code_eqp 
  WHERE id_tree in
  (select id_tree from eqm_eqp_tree_tbl a
  join eqm_equipment_tbl b on a.code_eqp=b.id
  left join eqm_borders_tbl as c on 
  (c.code_eqp=b.id)
  left join clm_client_tbl as cl on
  (cl.id=c.id_clientb)
  JOIN (eqi_device_kinds_tbl AS dk LEFT JOIN eqi_device_kinds_prop_tbl AS dkp ON (dkp.type_eqp=dk.id)) ON (b.type_eqp=dk.id)
  where cl.id = id_cl and a.lvl=1)
      and eq.type_eqp=10) as n1
     join 
  (Select eq.id,tt.name,tt.code_eqp,tt.code_eqp_e as code_eqp_p ,tt.name,eq.type_eqp,
case when y.voltage_nom is not null then y.voltage_nom/y.voltage2_nom else y.amperage_nom/y.amperage2_nom end ::integer as k_tr 
From eqm_eqp_tree_tbl AS tt 
JOIN eqm_equipment_tbl AS eq ON (tt.code_eqp=eq.id) 
JOIN (eqi_device_kinds_tbl AS dk JOIN eqi_device_kinds_prop_tbl AS dkp ON (dk.id=dkp.type_eqp)) ON (eq.type_eqp=dk.id)
 left join eqm_borders_tbl as b on (b.code_eqp=eq.id) left join clm_client_tbl as cl on (cl.id=b.id_clientb)
 left join eqm_meter_tbl as q on q.code_eqp= tt.code_eqp
 left join eqi_meter_tbl AS it on q.id_type_eqp=it.id
 left join 
 (select * from eqm_compensator_i_tbl AS dt JOIN eqi_compensator_i_tbl AS it ON(dt.id_type_eqp=it.id)) as y on
  y.code_eqp= tt.code_eqp 
  WHERE id_tree in
  (select id_tree from eqm_eqp_tree_tbl a
  join eqm_equipment_tbl b on a.code_eqp=b.id
  left join eqm_borders_tbl as c on 
  (c.code_eqp=b.id)
  left join clm_client_tbl as cl on
  (cl.id=c.id_clientb)
  JOIN (eqi_device_kinds_tbl AS dk LEFT JOIN eqi_device_kinds_prop_tbl AS dkp ON (dkp.type_eqp=dk.id)) ON (b.type_eqp=dk.id)
  where cl.id = id_cl and a.lvl=1)
      and eq.type_eqp=10) as n2 on
     n1.code_eqp=n2.code_eqp_p   
     UNION
    Select tt.code_eqp as code_eqp_up,tt.code_eqp_e as code_eqp ,
case when y.voltage_nom is not null then y.voltage_nom/y.voltage2_nom else y.amperage_nom/y.amperage2_nom end ::integer as k_tr,2 as type 
From eqm_eqp_tree_tbl AS tt 
JOIN eqm_equipment_tbl AS eq ON (tt.code_eqp=eq.id) 
JOIN (eqi_device_kinds_tbl AS dk JOIN eqi_device_kinds_prop_tbl AS dkp ON (dk.id=dkp.type_eqp)) ON (eq.type_eqp=dk.id)
 left join eqm_borders_tbl as b on (b.code_eqp=eq.id) left join clm_client_tbl as cl on (cl.id=b.id_clientb)
 left join eqm_meter_tbl as q on q.code_eqp= tt.code_eqp
 left join eqi_meter_tbl AS it on q.id_type_eqp=it.id
 left join 
 (select * from eqm_compensator_i_tbl AS dt JOIN eqi_compensator_i_tbl AS it ON(dt.id_type_eqp=it.id)) as y on
  y.code_eqp= tt.code_eqp 
  WHERE id_tree in
  (select id_tree from eqm_eqp_tree_tbl a
  join eqm_equipment_tbl b on a.code_eqp=b.id
  left join eqm_borders_tbl as c on 
  (c.code_eqp=b.id)
  left join clm_client_tbl as cl on
  (cl.id=c.id_clientb)
  JOIN (eqi_device_kinds_tbl AS dk LEFT JOIN eqi_device_kinds_prop_tbl AS dkp ON (dkp.type_eqp=dk.id)) ON (b.type_eqp=dk.id)
  where cl.id = id_cl and a.lvl=1)
     and eq.type_eqp=10) as res 
     group by 1) as ktr on
     ktr.code_eqp=tt.code_eqp_e
   
 left join eqm_point_tbl tu on 
 tu.code_eqp = 
 (
 Select eq1.id
From eqm_eqp_tree_tbl AS tt 
JOIN eqm_equipment_tbl AS eq1 ON (tt.code_eqp=eq1.id) 
JOIN (eqi_device_kinds_tbl AS dk JOIN eqi_device_kinds_prop_tbl AS dkp ON (dk.id=dkp.type_eqp)) ON (eq1.type_eqp=dk.id)
 left join eqm_borders_tbl as b on (b.code_eqp=eq1.id) left join clm_client_tbl as cl on (cl.id=b.id_clientb)
 left join eqm_meter_tbl as q on q.code_eqp= tt.code_eqp
 left join eqi_meter_tbl AS it on q.id_type_eqp=it.id
 
  WHERE id_tree in
  (select id_tree from eqm_eqp_tree_tbl a
  join eqm_equipment_tbl b on a.code_eqp=b.id
  left join eqm_borders_tbl as c on 
  (c.code_eqp=b.id)
  left join clm_client_tbl as cl on
  (cl.id=c.id_clientb)
  JOIN (eqi_device_kinds_tbl AS dk LEFT JOIN eqi_device_kinds_prop_tbl AS dkp ON (dkp.type_eqp=dk.id)) ON (b.type_eqp=dk.id)
  where cl.id = id_cl and a.lvl=1)
  and dk.id=12 and --(eq1.id=get_tu(eq.id) and eq.type_eqp=1)
  (replace(eq1.name_eqp, ' ', '')=replace(eq.name_eqp, ' ', '') or strpos(eq1.name_eqp, eq.name_eqp)>0)
   )
  
  WHERE id_tree in
  (select id_tree from eqm_eqp_tree_tbl a
  join eqm_equipment_tbl b on a.code_eqp=b.id
  left join eqm_borders_tbl as c on 
  (c.code_eqp=b.id)
  left join clm_client_tbl as cl on
  (cl.id=c.id_clientb)
  JOIN (eqi_device_kinds_tbl AS dk LEFT JOIN eqi_device_kinds_prop_tbl AS dkp ON (dkp.type_eqp=dk.id)) ON (b.type_eqp=dk.id)
  where cl.id = id_cl and a.lvl=1)
   ) as res
   left join eqm_point_tbl tu1 on 
   tu1.code_eqp=get_tu(id) and res.code_tu is null
   left join eqd_meter_energy_tbl kind
   on kind.code_eqp=id and kind.kind_energy=2 
   left join eqd_meter_energy_tbl kind2
   on kind2.code_eqp=id and kind2.kind_energy=4) as res1 
   left JOIN eqm_compens_station_inst_tbl AS area ON (code_tu=area.code_eqp)
   left JOIN eqm_equipment_tbl AS eq2 ON (area.code_eqp_inst=eq2.id)
   left join eqm_point_tbl tu1 on tu1.code_eqp=code_tu and eerm is null
   left join eqm_area_tbl u on u.code_eqp=area.code_eqp_inst

$BODY$
  LANGUAGE sql VOLATILE
  COST 100
  ROWS 1000;
ALTER FUNCTION public.get_datainput(integer)
  OWNER TO postgres;


-- Узнать что есть у субабонента

select tr.id,tr.name,tr.code_eqp from eqm_tree_tbl AS tr where tr.id_client = 12996 order by name

Select tt.code_eqp,tt.code_eqp_e as code_eqp_p ,tt.name,eq.type_eqp,tt.line_no, dkp.id_icon
From eqm_eqp_tree_tbl AS tt 
JOIN eqm_equipment_tbl AS eq ON (tt.code_eqp=eq.id)
JOIN (eqi_device_kinds_tbl AS dk JOIN eqi_device_kinds_prop_tbl AS dkp ON (dk.id=dkp.type_eqp)) ON (eq.type_eqp=dk.id)
left join eqm_borders_tbl as b on (b.code_eqp=eq.id) 
left join clm_client_tbl as cl on (cl.id=b.id_clientb) 
WHERE (id_tree= 102073) 
----------------------------------

-- Применить для отображения субабонента

Select tr.id,tt.code_eqp,tt.code_eqp_e as code_eqp_p ,tt.name,eq.type_eqp,tt.line_no, b.id_clientb
from eqm_tree_tbl tr
left join eqm_eqp_tree_tbl AS tt on tr.id=tt.id_tree
JOIN eqm_equipment_tbl AS eq ON (tt.code_eqp=eq.id)
JOIN (eqi_device_kinds_tbl AS dk JOIN eqi_device_kinds_prop_tbl AS dkp ON (dk.id=dkp.type_eqp)) ON (eq.type_eqp=dk.id)
left join eqm_borders_tbl as b on (b.code_eqp=eq.id) 
left join clm_client_tbl as cl on (cl.id=b.id_clientb) 
WHERE tr.id_client = 11843 and eq.type_eqp=9 and tt.code_eqp_e is not null  

select * from get_datainput(11843)


select tr.id,tr.name,tr.code_eqp from eqm_tree_tbl AS tr where tr.id_client = 11843 order by name

select a.*,b.* from eqm_eqp_tree_tbl a
join eqm_equipment_tbl b on a.code_eqp=b.id
where a.id_tree=101380 --and b.type_eqp=2
order by 4
-----------------------------------------
select * from get_datasub(10408) order by code_eqp

--- 02.01.19 ----

select * from get_calc_reactiv_sub(10408) order by priz,id_client

select * from tab_ppp where id_tclient is not null

----03.01.19 ---------------

select * from get_calc_reactiv_sub(10408) order by priz,id_client

delete from legal_indic where value=0

select * from tab_ppp order by priz,id_client
select * from tmp_preact where priz=3  order by priz

	select a.*,
	 a.potr_act-b.potr_act,
	 a.potr_react-b.potr_react
	from  tab_ppp a left join
	(select sum(ee.potr_act) as potr_act,sum(ee.potr_react) as potr_react,ee.id_client,ee.id_pclient,ee.code_ptu
	from (select distinct potr_act,potr_react,id_client,id_pclient,code_ptu
	from tab_ppp where tab_ppp.priz=2) as ee group by ee.id_client,ee.id_pclient,ee.code_ptu) as b
	on a.id_client=b.id_pclient
	and a.code_tu=b.code_ptu 
	where a.priz=3 
	and exists(select * from tab_ppp where tab_ppp.id_tclient is not null and tab_ppp.potr_act is not null and tab_ppp.id_tclient=b.id_client)
	and a.id_pclient=10408 and a.potr_act is not null and a.id_tclient=b.id_client;

select distinct potr_act,potr_react,id_client,id_pclient,code_ptu 
	from tab_ppp where tab_ppp.priz=2 
	
select * from tab_ppp where id_pclient=10408 and priz=3 and potr_act is not null


----04.01.19 --------------

--Узнать у кого есть субпотребители
Select tr.id_client,count(*) as kol
                from eqm_tree_tbl tr
                left join eqm_eqp_tree_tbl AS tt on tr.id=tt.id_tree
                JOIN eqm_equipment_tbl AS eq ON (tt.code_eqp=eq.id)
                JOIN (eqi_device_kinds_tbl AS dk JOIN eqi_device_kinds_prop_tbl AS dkp ON (dk.id=dkp.type_eqp)) ON (eq.type_eqp=dk.id)
                left join eqm_borders_tbl as b on (b.code_eqp=eq.id) 
                left join clm_client_tbl as cl on (cl.id=b.id_clientb) 
                WHERE  b.id_clientb is not null and b.id_clientb<>tr.id_client
                group by tr.id_client
                having count(*)>0


-- применить этот запрос в новом алгоритме рассчета---
select distinct a.*,b.level from tmp_preact a
left join tmp_data_react b on a.id_client=b.id_client
where a.priz=0 or a.priz=1
order by b.level desc,a.priz,a.id_client


---- 11.01.2019 ----------------------- 
-- Исправить чтобы выдавал запрос одну строку
select v.*,case when v.vid_e=1 then v.value end as value_act,
                    case when v.vid_e=2 then v.value end as value_react,case when v.vid_e=3 then v.value end as value_gen,
                    case when v.vid_e=1 then v.value_diff end as value_diff_act,
                    case when v.vid_e=2 then v.value_diff end as value_diff_react,
                    case when v.vid_e=3 then v.value_diff end as value_diff_gen  
                    from
                    (select a.*,c.type as type_energy,13720 as id_client,b.type_eqp,q.value,q.vid_e,q.value_diff
                        from get_datainput(13720) a
                        left join area_prop b on
                        a.code_tu=b.code_eqp
                        inner join spr_area_type_eqp c on 
                        b.type_eqp=c.id 
                        left join get_indic(13720,a.code_eqp,b.type_eqp) q on
                        a.code_eqp=q.code_eqp and q.id_client=13720 --and b.code_eqp=q.code_eqp
                        join inp_e w on q.vid_e=w.id
                        ) as v
                        order by v.name_area








---- Функция get_calc_reactiv_sub 25.01.2019 (last work version)---------------------------------

-- Function: public.get_calc_reactiv_sub(integer)

-- DROP FUNCTION public.get_calc_reactiv_sub(integer);

CREATE OR REPLACE FUNCTION public.get_calc_reactiv_sub(IN id_cl integer)
  RETURNS TABLE(id_client integer, id_pclient integer, priz_re integer, priz_gen integer, potr_act integer, potr_react integer, potr_act_src integer, potr_react_src integer, tg numeric, priz integer, eerm numeric, hour_month integer, pwr numeric, code_tu integer, code_ptu integer, code_area integer, ps numeric, pg numeric, all_ps numeric, all_pg numeric, p1 numeric, p2 numeric, p3 numeric, tg_rp numeric, level integer, name_kl character varying, name_area character varying, name_cnt character varying) AS
$BODY$
#variable_conflict use_column
Declare 
t numeric(14,5);
tg_norm numeric(14,2);
r record;
r1 record;
r2 record;
r3 record;
r4 record;
r5 record;
l int;     -- Кол-во уровней
i int;     -- Счетчик уровней
pcl int;   -- Код предка
tcl int;   -- Код потребителя текущий
pcl1 int;   -- Код предка
tcl1 int;   -- Код потребителя текущий
p int;

c_potr_act int;
c_potr_react int;
c_code_tu int;
c_code_ptu int;
c_priz_re int;
c1_potr_act int;
c1_potr_react int;
c1_code_tu int;
c1_code_ptu int;
c1_priz_re int;
c1_priz int;
c_potr_act_src int;
c_potr_react_src int;

Begin
-- Рассчет реактива по субпотребителям
drop table IF EXISTS tmp_data_react;
drop table IF EXISTS tmp_preact;
create temp table tmp_preact (id_client int,
id_pclient int,id_tclient int,
priz_re int,priz_gen int,
potr_act int,potr_react int,
potr_act_src int,potr_react_src int,
tg dec,priz int,
eerm numeric, hour_month integer, pwr numeric,
code_tu int,code_ptu int,code_area int,
ps numeric,
pg numeric,
all_ps numeric,
all_pg numeric,
p1 numeric,
p2 numeric,
p3 numeric,
tg_rp numeric,
addf int
);

drop table IF EXISTS tab_ppp;
create temp table tab_ppp (id_client int,
id_pclient int,id_tclient int,
priz_re int,priz_gen int,
potr_act int,potr_react int,
potr_act_src int,potr_react_src int,
tg dec,priz int,
eerm numeric, hour_month integer, pwr numeric,
code_tu int,code_ptu int,code_area int,
ps numeric,
pg numeric,
all_ps numeric,
all_pg numeric,
p1 numeric,
p2 numeric,
p3 numeric,
tg_rp numeric,
addf int,
level int
);

drop table IF EXISTS tab_pp;
create temp table tab_pp (id_client int,
id_pclient int,id_tclient int,
priz_re int,priz_gen int,
potr_act int,potr_react int,
potr_act_src int,potr_react_src int,
tg dec,priz int,
eerm numeric, hour_month integer, pwr numeric,
code_tu int,code_ptu int,code_area int,
ps numeric,
pg numeric,
all_ps numeric,
all_pg numeric,
p1 numeric,
p2 numeric,
p3 numeric,
tg_rp numeric,
addf int,
level int
);

drop table IF EXISTS tmp_subres;
create temp table tmp_subres (id_pclient int,
potr_act int,potr_react int);

drop table IF EXISTS tmp_srcres;
create temp table tmp_srcres (id_client int,code_tu int,
code_ptu int,
potr_act int,potr_react int);


-- Узнаем значения констант, задействованных в рассчете
select value into t from spr_const where name_s='T';
select value into tg_norm from spr_const where name_s='Tg_norm';
-- Заполняем врем. таблицу данными по субпотребителям
create temp table tmp_data_react as
select * from get_datasub($1);

-- Корректировка поля предка
update tmp_data_react a
set id_pclient=$1
where a.id_pclient=a.id_client and a.id_client<>$1;

-- Узнаем количество уровней вхождения
select max(level) into l from tmp_data_react;
i=l;
while i>0 loop
	-- Получаем данные по уровню, начиная с самого последнего
	for r in
		Select distinct a.id_client,a.id_pclient  --,re,gen
		from tmp_data_react a
		WHERE a.level=i loop
	
		pcl:=r.id_pclient;  -- Код предка
		tcl=r.id_client;   -- Код потребителя

		-- Получаем всех субпотребителей предка и определяем отсутствие хотя-бы у кого-то счетчика реактивной энергии
		select a.id_client into p from tmp_data_react a
		where a.level=i and a.id_pclient=pcl and a.re=0 ;

		if tcl=12774 then
			--Raise Notice 'id_client=################### %',tcl ;
			--Raise Notice 'pcl=############# %',pcl ;	
		end if;
		
		if (pcl=tcl and tcl<>$1) IS NOT TRUE then
			--continue;
			Raise Notice 'id_client=################### %',tcl ;
			Raise Notice 'pcl=############# %',pcl ;
				
		-- Получаем таблицу предков субпотребителей с их показаниями и вычисляем по ним тангенс.
		insert into tmp_preact(id_client,id_pclient,priz_re,potr_act,potr_react,tg,priz,eerm,hour_month,pwr,code_tu,code_ptu,code_area,tg_rp)
		select pcl as id_client,src4.id_pclient,case when p is null then 1 else 0 end as priz_re,src4.potr_act,src4.potr_react,
		src4.tg,0 as priz,src4.eerm,src4.hour_month,src4.pwr,src4.code_tu1 as code_tu,src4.code_ptu,src4.code_area,src4.tg_rp1
		from 
		(select src3.*,pcl as id_pclient,case when src3.tg_r>0.8 then 0.8 else tg_r end as tg,case when src3.tg_r>2 then 2 else src3.tg_r end as tg_rp1 from
		(select *,case when src2.potr_act>0 then
		ROUND((sum(src2.potr_react) OVER (PARTITION BY src2.code_area))/case when (sum(src2.potr_act) OVER (PARTITION BY src2.code_area))<>0 then (sum(src2.potr_act) OVER (PARTITION BY src2.code_area)) else 999999999 end,2) else tg_norm end AS tg_r
		from
		-- Показания по видам энергии
		(select src1.code_area,src1.code_tu,src1.code_eqp,src1.eerm,src1.hour_month,src1.pwr,src1.code_tu1,src1.code_ptu,
		sum(case when src1.vid_e=1 then src1.potr end) as potr_act,
		sum(case when src1.vid_e=2 then src1.potr end) as potr_react,
		sum(case when src1.vid_e=3 then src1.potr end) as potr_gen
		from
		-- Последние показания по потребителю
		(select max(a.date) as date,a.code_tu,a.code_area,a.code_eqp,a.vid_e,case when a.value_diff is null then a.value else value_diff end as potr,
		b.eerm,b.hour_month,b.power as pwr,b.code_tu as code_tu1,b.code_ptu
		from legal_indic a
		inner join tmp_data_react b
		on a.id_client=b.id_client and a.code_tu=b.code_tu and a.value>0
		where a.id_client=pcl
		group by 2,3,4,5,6,7,8,9,10,11) as src1
		group by 1,2,3,4,5,6,7,8) as src2) as src3) as src4
		where not exists(select * from tmp_preact where tmp_preact.id_client=pcl);

		-- Получаем корректный код предка
		update tmp_preact a
		set id_pclient=b.id_pclient
		from tmp_data_react as b
		where a.priz=0 and a.id_client=b.id_client
		and a.code_ptu=b.code_ptu and a.code_tu=b.code_tu;

		
		
		-- Получаем всех субпотребителей предка и определяем показания реактивной энергии
		insert into tmp_preact(id_client,id_pclient,priz_re,potr_act,potr_react,eerm,hour_month,pwr,code_tu,code_ptu,code_area,tg,priz)	
		select distinct src4.*,round(src4.potr_react/case when src4.potr_act<>0 then src4.potr_act else 99999999 end,2) as tg,1 as priz
		 from
		(select src3.id_client,src3.id_pclient,99 as priz_re,src3.potr_act,case when predok.priz_re=0 then src3.potr_act*predok.tg else src3.potr_react end as potr_react,
		 src3.eerm,src3.hour_month,src3.pwr,src3.code_tu1 as code_tu,src3.code_ptu,src3.code_area from
		(select src2.*,tcl as id_client,pcl as id_pclient,case when src2.potr_act>0 then
		 ROUND((sum(src2.potr_react) OVER (PARTITION BY src2.code_area))/case when (sum(src2.potr_act) OVER (PARTITION BY src2.code_area))<>0 then (sum(src2.potr_act) OVER (PARTITION BY src2.code_area)) else 999999999 end,2) else tg_norm end AS tg_r
		from
		-- Показания по видам энергии
		(select src1.code_area,src1.code_tu,src1.code_eqp,src1.eerm,src1.hour_month,src1.pwr,src1.code_tu1,src1.code_ptu,
		sum(case when src1.vid_e=1 then src1.potr end) as potr_act,
		sum(case when src1.vid_e=2 then src1.potr end) as potr_react,
		sum(case when src1.vid_e=3 then src1.potr end) as potr_gen
		from
		-- Последние показания по потребителю
		(select max(a.date) as date,a.code_tu,a.code_area,a.code_eqp,a.vid_e,case when a.value_diff is null then a.value else value_diff end as potr,
		b.eerm,b.hour_month,b.power as pwr,b.code_tu as code_tu1,b.code_ptu  
		from legal_indic a
		inner join tmp_data_react b
		on a.id_client=b.id_client and a.id_client<>$1--and a.code_tu=b.code_tu
		where b.id_client=tcl and b.level=i and b.id_pclient=pcl --and a.value>0
		group by 2,3,4,5,6,7,8,9,10,11) as src1
		group by 1,2,3,4,5,6,7,8) as src2) as src3
		left join (select distinct * from tmp_preact where tmp_preact.priz=0) predok on
		src3.id_pclient=predok.id_client and src3.code_ptu=predok.code_tu) as src4
		where not exists(select * from tmp_preact where tmp_preact.id_client=tcl and tmp_preact.code_tu=src4.code_tu and tmp_preact.code_ptu=src4.code_ptu);

		delete from tmp_preact a where a.potr_act=0 and a.potr_react=0 and a.priz=1;
		
		--if pcl<>$1 then
		insert into tmp_preact(id_client,id_pclient,priz_re,potr_act,potr_react,eerm,hour_month,pwr,code_tu,code_ptu,code_area,tg,priz,addf)	
		select distinct src4.*,round(src4.potr_react/case when src4.potr_act<>0 then src4.potr_act else 99999999 end,2) as tg,1 as priz,1 as addf
		 from
		(select src3.id_client,src3.id_pclient,99 as priz_re,src3.potr_act,case when predok.priz_re=0 then src3.potr_act*predok.tg else src3.potr_react end as potr_react,
		 src3.eerm,src3.hour_month,src3.pwr,src3.code_tu1 as code_tu,src3.code_ptu,src3.code_area from
		(select src2.*,tcl as id_client,pcl as id_pclient,case when src2.potr_act>0 then
		 ROUND((sum(src2.potr_react) OVER (PARTITION BY src2.code_area))/case when (sum(src2.potr_act) OVER (PARTITION BY src2.code_area))<>0 then (sum(src2.potr_act) OVER (PARTITION BY src2.code_area)) else 999999999 end,2) else tg_norm end AS tg_r
		from
		-- Показания по видам энергии
		(select src1.code_area,src1.code_tu,src1.code_eqp,src1.eerm,src1.hour_month,src1.pwr,src1.code_tu1,src1.code_ptu,
		sum(case when src1.vid_e=1 then src1.potr end) as potr_act,
		sum(case when src1.vid_e=2 then src1.potr end) as potr_react,
		sum(case when src1.vid_e=3 then src1.potr end) as potr_gen
		from
		-- Последние показания по потребителю
		(select max(a.date) as date,a.code_tu,a.code_area,a.code_eqp,a.vid_e,case when a.value_diff is null then a.value else value_diff end as potr,
		b.eerm,b.hour_month,b.power as pwr,b.code_tu as code_tu1,b.code_ptu  
		from legal_indic a
		inner join tmp_data_react b
		on a.id_client=b.id_client and a.id_client<>$1 and a.code_tu=b.code_tu
		where b.id_client=tcl and b.level=i and b.id_pclient=$1 and a.value>0
		group by 2,3,4,5,6,7,8,9,10,11) as src1
		group by 1,2,3,4,5,6,7,8) as src2) as src3
		left join (select distinct * from tmp_preact where tmp_preact.priz=0) predok on
		src3.id_pclient=predok.id_client and src3.code_ptu=predok.code_tu) as src4;
		--where not exists(select * from tmp_preact where tmp_preact.id_client=tcl and tmp_preact.code_tu=src4.code_tu and tmp_preact.code_ptu=src4.code_ptu);
		--end if;

		end if;
				 
	end loop;

		
	-- Суммирование по показаниям счетчиков субпотребителей
	insert into tmp_preact(id_client,id_pclient,potr_act,potr_react,priz,priz_re,code_tu,code_ptu)
	select a.id_client,a.id_pclient,sum(a.potr_act) as potr_act,sum(a.potr_react) as potr_react,2 as priz,a.priz_re,a.code_tu,a.code_ptu
	from tmp_preact a
	where cast(a.id_client as varchar)||cast(a.code_tu as varchar)||cast(a.code_ptu as varchar) not in
	(select cast(tmp_preact.id_client as varchar)||cast(tmp_preact.code_tu as varchar)||cast(tmp_preact.code_ptu as varchar) from tmp_preact where tmp_preact.priz=2)
	and a.priz=1
	group by a.id_client,a.id_pclient,a.priz_re,a.code_tu,a.code_ptu;	

	
	--delete from tmp_preact a where a.potr_act=0 and a.potr_react=0 and a.priz=2;

	-- Корректировка изначальных показаний счетчиков potr_act_src и potr_react_src
	update tmp_preact a
	set potr_act_src = b.potr_act,
	potr_react_src = b.potr_react
	from (select distinct tmp_preact.potr_act,tmp_preact.potr_react,tmp_preact.id_client,tmp_preact.id_pclient,tmp_preact.code_ptu from tmp_preact where tmp_preact.priz=1) as b
	where a.priz=2 and a.id_client=b.id_client
	and a.id_pclient=b.id_pclient and a.code_ptu=b.code_ptu;

	update tmp_preact a
	set potr_act_src = b.potr_act_src,
	potr_react_src = b.potr_react_src
	from (select * from tmp_preact where tmp_preact.priz=2) as b
	where a.priz=1 and a.id_client=b.id_client
	and a.id_pclient=b.id_pclient and a.code_ptu=b.code_ptu;

	

	-- Вычитание из показаний счетчиков субпотребителей для предка
	/*
	insert into tmp_preact(id_client,id_pclient,potr_act,potr_react,potr_act_src,potr_react_src,priz,priz_re,code_tu,code_ptu)
	select distinct a.id_client,a.id_pclient,
	LAST_VALUE(a.potr_act-b.potr_act) OVER (PARTITION BY a.id_client) as potr_act,
	LAST_VALUE(a.potr_react-b.potr_react) OVER (PARTITION BY a.id_client) as potr_react,
	--a.potr_act-b.potr_act as potr_act,
	--a.potr_react-b.potr_react as potr_react,
	a.potr_act as potr_act_src,
	a.potr_react as potr_react_src,
	3 as priz,a.priz_re,a.code_tu,a.code_ptu
	from tmp_preact a
	inner join tmp_preact b on
	a.id_client=b.id_pclient and a.code_tu=b.code_ptu and b.priz=1 --and b.priz_re=99
	where cast(a.id_client as varchar)||cast(a.code_tu as varchar)||cast(a.code_ptu as varchar) not in
	(select cast(tmp_preact.id_client as varchar)||cast(tmp_preact.code_tu as varchar)||cast(tmp_preact.code_ptu as varchar) from tmp_preact where tmp_preact.priz=3);
	*/
	
	-- Вычитание из показаний счетчиков субпотребителей для предка (переделано, теперь с помощью цикла)
	
	for r1 in
		Select *
		from tmp_preact a
		loop
	
		pcl:=r1.id_pclient;  -- Код предка
		tcl=r1.id_client;    -- Код потребителя
		c_potr_act=r1.potr_act;
		c_potr_react=r1.potr_react;
		c_code_tu=r1.code_tu;
		c_code_ptu=r1.code_ptu;
		c_priz_re=r1.priz_re;

		for r2 in
		Select *
		from tmp_preact b where b.priz=1
		loop
	
			pcl1:=r2.id_pclient;  -- Код предка
			tcl1=r2.id_client;    -- Код потребителя
			c1_potr_act=r2.potr_act;
			c1_potr_react=r2.potr_react;
			c1_code_tu=r2.code_tu;
			c1_code_ptu=r2.code_ptu;
			c1_priz_re=r2.priz_re;
			c1_priz=r2.priz;
			
			select distinct tmp_preact.potr_act_src into c_potr_act_src from tmp_preact where tmp_preact.potr_act_src>0 and tmp_preact.id_client=tcl and tmp_preact.priz<3;
			select distinct tmp_preact.potr_react_src into c_potr_react_src from tmp_preact where tmp_preact.potr_react_src>0 and tmp_preact.id_client=tcl and tmp_preact.priz<3;

			Raise Notice 'id_client= %',tcl ;
			Raise Notice 'potr_act_src= %',c_potr_act_src ;	
			
			if pcl1=tcl and c1_code_ptu=c_code_tu and c1_priz=1 then
				if tcl1=12315 then
					Raise Notice '*****************id_client= %',tcl ;
					Raise Notice '*****************id_pclient= %',pcl ;
					Raise Notice '*****************code_tu= %',c_code_tu ;
					Raise Notice '*****************code_ptu= %',c_code_ptu ;
					Raise Notice '*****************potr_act= %',c_potr_act-c1_potr_act ;
				end if;
				insert into tmp_preact(id_client,id_pclient,id_tclient,potr_act,potr_react,potr_act_src,potr_react_src,priz,priz_re,code_tu,code_ptu,addf)
				select distinct tcl,pcl,tcl1,c_potr_act-c1_potr_act,c_potr_react-c1_potr_react,c_potr_act_src,c_potr_react_src,
				3,c_priz_re,c_code_tu,c_code_ptu,1
				where not exists(select * from tmp_preact where tmp_preact.id_client=tcl and tmp_preact.code_tu=c_code_tu
				and tmp_preact.code_ptu=c_code_ptu and tmp_preact.id_pclient=pcl and tmp_preact.priz=3 and tmp_preact.id_tclient=tcl1);
				
			end if;

			
			if pcl1=tcl and c1_code_ptu=c_code_tu and c1_priz=1 then
				update tmp_preact
				set potr_act_src=c_potr_act_src,
				potr_react_src=c_potr_react_src
				--potr_act=c_potr_act_src-c1_potr_act,
				--potr_react=c_potr_react_src-c1_potr_react
				where tmp_preact.id_client=tcl and tmp_preact.code_tu=c_code_tu
				and tmp_preact.code_ptu=c_code_ptu and tmp_preact.id_pclient=pcl and tmp_preact.priz<>0;
							
			end if;
			
			
		end loop;	

	end loop;	

	-- Результирующие показания (по новому)
	insert into tmp_preact(id_client,id_pclient,potr_act,potr_react,potr_act_src,potr_react_src,priz,priz_re,code_tu,code_ptu)
	select distinct a.id_client,a.id_pclient,a.potr_act,a.potr_react,a.potr_act_src,a.potr_react_src,-3 as priz,a.priz_re,a.code_tu,a.code_ptu
	from tmp_preact a
	where a.priz=3;

	insert into tmp_preact(id_client,id_pclient,potr_act,potr_react,potr_act_src,potr_react_src,priz,priz_re,code_tu,code_ptu,addf)
	select distinct a.id_client,a.id_pclient,a.potr_act,a.potr_react,a.potr_act_src,a.potr_react_src,-3 as priz,a.priz_re,a.code_tu,a.code_ptu,2
	from tmp_preact a
	where a.priz=0 and a.id_client not in(select distinct b.id_client from tmp_preact b where b.priz=3) ;
	
	
	-- Запись в промежуточную таблицу с суммарными результатами по субпотребителям (по новому)
	insert into tmp_subres(id_pclient,potr_act,potr_react)
	select d.id_pclient,sum(d.potr_act) as potr_act,sum(d.potr_react) as potr_react from
	(select distinct a.* from tmp_preact a 
	where a.priz=2) as d
	group by d.id_pclient;

	-- Запись в промежуточную таблицу с суммарными изначальными показаниями (по новому)
	delete from tmp_srcres;
	
	insert into tmp_srcres(id_client,code_tu,code_ptu,potr_act,potr_react)
	select d.id_client,d.code_tu,d.code_ptu,sum(d.potr_act) as potr_act,sum(d.potr_react) as potr_react from
	(select distinct a.* from tmp_preact a 
	where a.priz=0) as d
	group by d.id_client,d.code_tu,d.code_ptu;

	-- Корректировка показаний с начальными показаниями (по новому)
	update tmp_preact a
	set potr_act_src = b.potr_act,
	potr_react_src = b.potr_react
	from tmp_srcres as b
	where a.priz=-3 and a.id_client=b.id_client and a.code_tu=b.code_tu and a.code_ptu=b.code_ptu;

	insert into tab_ppp
	select * from tmp_preact;

	-- Корректировка показаний (по новому)
	update tmp_preact a
	set potr_act = a.potr_act_src-b.potr_act,
	potr_react = a.potr_react_src-b.potr_react
	from tmp_subres as b
	where a.priz=-3 and a.id_client=b.id_pclient;
			
	-- Корректировка показаний
	update tmp_preact a
	set potr_act = a.potr_act_src-b.potr_act,
	potr_react = a.potr_react_src-b.potr_react
	from (select distinct * from tmp_preact where tmp_preact.priz=3) as b
	where a.priz=3 and a.id_client=b.id_pclient
	and a.code_tu=b.code_ptu; --and a.code_tu=b.code_tu;

	

	update tmp_preact a
	set potr_act = a.potr_act-b.potr_act,
	potr_react = a.potr_react-b.potr_react
	from (select sum(ee.potr_act) as potr_act,sum(ee.potr_react) as potr_react,ee.id_client,ee.id_pclient,ee.code_ptu
	from (select distinct z.potr_act,z.potr_react,z.id_client,z.id_pclient,z.code_ptu
	from tmp_preact z where z.priz=2) as ee group by ee.id_client,ee.id_pclient,ee.code_ptu) as b
	where a.priz=3 and a.id_client=b.id_pclient
	and a.code_tu=b.code_ptu 
	and exists(select * from tmp_preact where tmp_preact.id_tclient is not null and tmp_preact.id_tclient=b.id_client)
	and a.id_pclient=$1 and a.potr_act is not null and a.id_tclient=b.id_client;
	
		
	-- Корректировка показаний для самого главного потребителя
	update tmp_preact a
	set potr_act_src = b.potr_act,
	potr_react_src = b.potr_react
	from (select * from tmp_preact where tmp_preact.priz=0) as b
	where a.priz=3 and a.id_client=b.id_pclient
	and a.code_tu=b.code_ptu and a.id_client=$1;

	update tmp_preact a
	set potr_act_src = b.potr_act,
	potr_react_src = b.potr_react
	from (select * from tmp_preact where tmp_preact.priz=0 and tmp_preact.id_client=$1) as b
	where a.priz=3 and a.id_client=a.id_pclient
	and a.id_client=$1;

	-- Корректировка показаний для самого главного потребителя (по новому)
	update tmp_preact a
	set potr_act_src = b.potr_act,
	potr_react_src = b.potr_react
	from (select * from tmp_preact where tmp_preact.priz=0) as b
	where a.priz=-3 and a.id_client=b.id_pclient
	and a.code_tu=b.code_ptu and a.id_client=$1;

	update tmp_preact a
	set potr_act_src = b.potr_act,
	potr_react_src = b.potr_react
	from (select * from tmp_preact where tmp_preact.priz=0 and tmp_preact.id_client=$1) as b
	where a.priz=-3 and a.id_client=a.id_pclient
	and a.id_client=$1;

	update tmp_preact a
	set potr_act = a.potr_act_src-b.potr_act,
	potr_react = a.potr_react_src-b.potr_react
	from (select sum(e.potr_act) as potr_act,sum(e.potr_react) as potr_react
	      from 
	      (select distinct tmp_preact.id_client,tmp_preact.id_pclient,tmp_preact.potr_act,tmp_preact.potr_react
	       from tmp_preact where tmp_preact.priz=-3 and tmp_preact.id_client<>$1) as e) as b
	where a.priz=-3 and a.id_client=$1;
	-------------------------------------------------------------------------------------------------------------
	-- Корректировка показаний для самого главного потребителя
	/*
	update tmp_preact a
	set potr_act = a.potr_act_src-b.potr_act,
	potr_react = a.potr_react_src-b.potr_react
	from (select * from tmp_preact where tmp_preact.priz=0) as b
	where a.priz=3 and a.id_client=b.id_pclient
	and a.code_tu=b.code_ptu and a.id_client=$1;
	*/

	update tmp_preact a
	set potr_act = a.potr_act_src-b.potr_act,
	potr_react = a.potr_react_src-b.potr_react
	from (select sum(e.potr_act) as potr_act,sum(e.potr_react) as potr_react
	      from 
	      (select distinct tmp_preact.id_client,tmp_preact.id_pclient,tmp_preact.potr_act,tmp_preact.potr_react
	       from tmp_preact where tmp_preact.priz=3 and tmp_preact.id_client<>$1) as e) as b
	where a.priz=3 and a.id_client=$1;

	-- Проставляем значения tg,eerm,pwr и hour_month
	update tmp_preact a
	set tg=b.tg,eerm=b.eerm,hour_month=b.hour_month,pwr=b.pwr,
	code_area=b.code_area,tg_rp=b.tg_rp
	from (select * from tmp_preact where tmp_preact.priz=0) as b
	where a.priz=-3 and a.id_client=b.id_client
	and a.code_ptu=b.code_ptu and a.code_tu=b.code_tu;

	-- Проставляем значения рассчетов по реактиву (p1,p2,p3)
	update tmp_preact a
	set ps=b.ps1,pg=b.pg1,all_ps=b.all_ps1,all_pg=b.all_pg1,p1=b.p1q,p2=b.p2q,p3=b.p3q
	from (select *,(src8.p1q+src8.p2q) as p3q
	from 
	-- Получаем p3
	(select *,case when ((src7.all_ps1 is null or src7.all_ps1=0) and (src7.all_pg1 is null or src7.all_pg1=0)) then 0 else src7.p1_1 end as p1q,
	case when ((src7.all_ps1 is null or src7.all_ps1=0) and (src7.all_pg1 is null or src7.all_pg1=0)) then 0 else src7.p2_1 end as p2q
	from
	(select *,sum(case when src6.all_ps1 is null then 0 else src6.all_ps1 end + case when src6.all_pg1 is null then 0 else src6.all_pg1 end) OVER (PARTITION BY src6.code_area) as p1_1,
	ROUND(coalesce(src6.all_ps1,0)*power((src6.tg_rp-0.25),2),2) AS p2_1
	from
	-- Получаем p1 и p2
	(select *,case when ((src5.all_potr_react>999.99) and src5.pwr>16) then ROUND(src5.potr_react*src5.eerm*t,2)::numeric(14,2) else 0::numeric(14,2) end as ps1,
	0::numeric(14,2) as pg1,
	sum(case when ((src5.all_potr_react>999.99) and src5.pwr>16) then ROUND(src5.potr_react*src5.eerm*t,2)::numeric(14,2) else 0::numeric(14,2) end) OVER (PARTITION BY src5.code_tu) as all_ps1,
	0::numeric(14,2) as all_pg1
	from
	(select a.*,sum(a.potr_react) OVER (PARTITION BY a.code_tu) as all_potr_react
	from tmp_preact a 
	where a.priz=-3) as src5)
	as src6)
	as src7)
	as src8) as b
	where a.priz=-3 and a.id_client=b.id_client
	and a.code_ptu=b.code_ptu and a.code_tu=b.code_tu;		
	
	i=i-1;
end loop; 

--- Реализация нового алгоритма ---

insert into tmp_preact(id_client,id_pclient,priz_re,code_tu,code_ptu,priz)
select a.id_client,a.id_pclient,min(a.priz_re) as priz_re,
a.code_tu,a.code_ptu,4
from tmp_preact a
where a.priz=0 or a.priz=1
group by a.id_client,a.id_pclient,
a.code_tu,a.code_ptu;

delete from tmp_preact a where (a.priz=0 or a.priz=1) and 
not exists(select b.* from tmp_preact b join
 (select e.* from tmp_preact e where e.priz=4) c on b.id_client=c.id_pclient
  and b.code_tu=c.code_tu and b.code_ptu=c.code_ptu and b.priz_re=c.priz_re);

 
  		
i=1;
delete from tab_ppp;

for r3 in
	WITH RECURSIVE r AS (  -- Рекурсивный запрос
		   select distinct 0 as ord,a.id_client,a.id_pclient,a.priz_re,a.potr_act,a.potr_react,a.potr_act_src,a.potr_react_src,a.tg,a.eerm,
		   a.hour_month,a.pwr,a.code_tu,a.code_ptu,a.code_area,a.ps,a.pg,a.all_ps,a.all_pg,a.p1,a.p2,a.p3,a.tg_rp,b.level,
		   case when a.id_client=$1 then 1 else 0 end as order from tmp_preact a
		   left join tmp_data_react b on a.id_client=b.id_client and a.code_tu=b.code_tu and a.code_ptu=b.code_ptu
		   join 
		   (select e.* from tmp_preact e where e.priz=4) c on 
		   a.id_client=c.id_client
		   and a.code_tu=c.code_tu and a.code_ptu=c.code_ptu and a.priz_re=c.priz_re
		   where a.priz=0 or a.priz=1 
		   UNION 
		   select distinct (ord+1) as ord,a.id_client,a.id_pclient,a.priz_re,a.potr_act,a.potr_react,a.potr_act_src,a.potr_react_src,a.tg,a.eerm,
		   a.hour_month,a.pwr,a.code_tu,a.code_ptu,a.code_area,a.ps,a.pg,a.all_ps,a.all_pg,a.p1,a.p2,a.p3,a.tg_rp,b.level,
		   case when a.id_client=$1 then 1 else 0 end as order from tmp_preact a
		   left join tmp_data_react b on a.id_client=b.id_client and a.code_tu=b.code_tu and a.code_ptu=b.code_ptu
		   join 
		   (select e.* from tmp_preact e where e.priz=4) c on 
		   a.id_client=c.id_client
		   and a.code_tu=c.code_tu and a.code_ptu=c.code_ptu and a.priz_re=c.priz_re
		    JOIN r
		    ON a.id_client = r.id_pclient and a.code_tu=r.code_ptu
		   where a.priz=0 or a.priz=1
		)
		SELECT distinct r.* from r where r.ord=0 order by ord
		loop
				   
		
		insert into tab_ppp(id_client,id_pclient,priz_re,potr_act,potr_react,potr_act_src,potr_react_src,tg,eerm,
	        hour_month,pwr,code_tu,code_ptu,code_area,ps,pg,all_ps,all_pg,p1,p2,p3,tg_rp,level)
		values(r3.id_client,r3.id_pclient,r3.priz_re,r3.potr_act,r3.potr_react,r3.potr_act_src,r3.potr_react_src,r3.tg,r3.eerm,
		   r3.hour_month,r3.pwr,r3.code_tu,r3.code_ptu,r3.code_area,r3.ps,r3.pg,r3.all_ps,r3.all_pg,r3.p1,r3.p2,r3.p3,r3.tg_rp,i); 
		
		i=i+1;

end loop;		

i=1;

update tab_ppp a
set potr_act_src = b.potr_act,
potr_react_src = b.potr_react
from tmp_srcres as b
where a.id_client=b.id_client and a.code_tu=b.code_tu and a.code_ptu=b.code_ptu and a.potr_act_src is null;

--update tab_ppp a
--set potr_act = 0,potr_react=0;


for r4 in
		SELECT * from tab_ppp 
		loop

		c_code_tu=r4.code_tu;
		c_code_ptu=r4.code_ptu;
		tcl=r4.id_client;
		pcl=r4.id_pclient;
		c_potr_act=r4.potr_act;
		c_potr_react=r4.potr_react;
		
		update tab_ppp a
		set 
		potr_act=a.potr_act_src-c_potr_act,
		potr_react=a.potr_react_src-c_potr_react
		where a.code_tu=c_code_ptu and a.id_client=pcl and a.id_client<>$1;

		--insert into tab_pp 
		--select * from tab_ppp a where a.code_tu=c_code_ptu and a.id_client=pcl;
end loop;

-- Корректировка потребления для главного потребителя
update tab_ppp a
set potr_act = a.potr_act_src-b.potr_act,
potr_react = a.potr_react_src-b.potr_react
from (select q.id_pclient,q.code_ptu,sum(q.potr_act) as potr_act,sum(q.potr_react) as potr_react
       from  tab_ppp q where q.id_client<>$1 
       group by q.id_pclient,q.code_ptu) as b
where a.id_client=b.id_pclient and a.code_tu=b.code_ptu and a.id_client=$1;

-- Проставляем значения рассчетов по реактиву (p1,p2,p3)
	update tab_ppp a
	set ps=b.ps1,pg=b.pg1,all_ps=b.all_ps1,all_pg=b.all_pg1,p1=b.p1q,p2=b.p2q,p3=b.p3q
	from (select *,(src8.p1q+src8.p2q) as p3q
	from 
	-- Получаем p3
	(select *,case when ((src7.all_ps1 is null or src7.all_ps1=0) and (src7.all_pg1 is null or src7.all_pg1=0)) then 0 else src7.p1_1 end as p1q,
	case when ((src7.all_ps1 is null or src7.all_ps1=0) and (src7.all_pg1 is null or src7.all_pg1=0)) then 0 else src7.p2_1 end as p2q
	from
	(select *,sum(case when src6.all_ps1 is null then 0 else src6.all_ps1 end + case when src6.all_pg1 is null then 0 else src6.all_pg1 end) OVER (PARTITION BY src6.code_area) as p1_1,
	ROUND(coalesce(src6.all_ps1,0)*power((src6.tg_rp-0.25),2),2) AS p2_1
	from
	-- Получаем p1 и p2
	(select *,case when ((src5.all_potr_react>999.99) and src5.pwr>16) then ROUND(src5.potr_react*src5.eerm*t,2)::numeric(14,2) else 0::numeric(14,2) end as ps1,
	0::numeric(14,2) as pg1,
	sum(case when ((src5.all_potr_react>999.99) and src5.pwr>16) then ROUND(src5.potr_react*src5.eerm*t,2)::numeric(14,2) else 0::numeric(14,2) end) OVER (PARTITION BY src5.code_tu) as all_ps1,
	0::numeric(14,2) as all_pg1
	from
	(select a.*,sum(a.potr_react) OVER (PARTITION BY a.code_tu) as all_potr_react
	from tab_ppp a ) as src5)
	as src6)
	as src7)
	as src8) as b
	where a.id_client=b.id_client
	and a.code_ptu=b.code_ptu and a.code_tu=b.code_tu;	

i=0;
-- Учитываем только один раз сумму реактива (убираем повторения)
for r5 in
		SELECT * from tab_ppp order by id_client
		loop
		
		tcl=r5.id_client;
		c_code_tu=r5.code_tu;
		c_code_ptu=r5.code_ptu;
		if tcl=$1 then
			i=i+1;
			if i>1 then
				update tab_ppp a
				set p1=0
				where a.code_tu=c_code_tu and a.id_client=tcl and a.code_ptu=c_code_ptu;
			end if;
		end if;
		
end loop;	

update tab_ppp a
set p3=p1+p2
where a.id_client=$1;

		
RETURN QUERY
--select distinct a.id_client,a.id_pclient,a.priz_re,0 as priz_gen,a.potr_act,a.potr_react,a.potr_act_src,a.potr_react_src,a.tg,
--a.priz,a.eerm,a.hour_month,a.pwr,a.code_tu,a.code_ptu,a.code_area,a.ps,a.pg,a.all_ps,a.all_pg,a.p1,a.p2,a.p3,a.tg_rp 
--from tmp_preact a ;--where a.priz>=2;

select distinct a.id_client,a.id_pclient,a.priz_re,0 as priz_gen,a.potr_act,a.potr_react,a.potr_act_src,a.potr_react_src,a.tg,
a.priz,a.eerm,a.hour_month,a.pwr,a.code_tu,a.code_ptu,a.code_area,a.ps,a.pg,a.all_ps,a.all_pg,a.p1,a.p2,a.p3,a.tg_rp,a.level,
b.name as name_kl,eq2.name_eqp as name_area,q.name as name_cnt 
from tab_ppp a join clm_client_tbl b on
a.id_client=b.id
left JOIN eqm_compens_station_inst_tbl AS area ON (a.code_tu=area.code_eqp)
left JOIN eqm_equipment_tbl AS eq2 ON (area.code_eqp_inst=eq2.id)
left join get_datainput(a.id_client) q on a.code_tu=q.code_tu and a.code_area=q.code_area
order by a.level desc;


end;
$BODY$
  LANGUAGE plpgsql VOLATILE STRICT
  COST 100
  ROWS 1000;
ALTER FUNCTION public.get_calc_reactiv_sub(integer)
  OWNER TO postgres;




------- Нужно переделать так ----------------------
select h.*,case when u.value_diff is null then u.value else value_diff end as potr from
(select max(a.date) as date,a.id_client,a.code_tu,a.code_area,a.code_eqp,a.vid_e,
		b.eerm,b.hour_month,b.power as pwr,b.code_tu as code_tu1,b.code_ptu  
		from legal_indic a
		inner join tmp_data_react b
		on a.id_client=b.id_client and a.id_client<>12768 --and a.code_tu=b.code_tu
		where b.id_client=12770 and b.level=1 and b.id_pclient=12768 --and a.value>0
		group by 2,3,4,5,6,7,8,9,10,11) h
join legal_indic u on
u.id_client=h.id_client and u.code_eqp=h.code_eqp and u.code_area=h.code_area and 
u.code_tu=h.code_tu and u.date=h.date and u.vid_e=h.vid_e

--------------------------------------------------------



-- Function: public.get_calc_reactiv(integer)

-- DROP FUNCTION public.get_calc_reactiv(integer);

CREATE OR REPLACE FUNCTION public.get_calc_reactiv(IN id_cl integer)
  RETURNS TABLE(eerm numeric, hour_month integer, pwr numeric, name character varying, code_area integer, code_tu integer, code_eqp integer, potr_act numeric, potr_react numeric, potr_gen numeric, tg_r numeric, tg_rp numeric, all_potr_react numeric, all_potr_gen numeric, ps numeric, pg numeric, all_ps numeric, all_pg numeric, p1_1 numeric, p2_1 numeric, p1 numeric, p2 numeric, p3 numeric) AS
$BODY$
Declare 
t numeric(14,5);
tg_norm numeric(14,2);

Begin

select value into t from spr_const where name_s='T';
select value into tg_norm from spr_const where name_s='Tg_norm';

RETURN QUERY
select *,(src8.p1+src8.p2) as p3
from 
-- Получаем p3
(select *,case when ((src7.all_ps is null or src7.all_ps=0) and (src7.all_pg is null or src7.all_pg=0)) then 0 else src7.p1_1 end as p1,
case when ((src7.all_ps is null or src7.all_ps=0) and (src7.all_pg is null or src7.all_pg=0)) then 0 else src7.p2_1 end as p2
from
(select *,sum(case when src6.all_ps is null then 0 else src6.all_ps end + case when src6.all_pg is null then 0 else src6.all_pg end) OVER (PARTITION BY src6.code_area) as p1_1,
ROUND(coalesce(src6.all_ps,0)*power((src6.tg_rp-0.25),2),2) AS p2_1
from
-- Получаем p1 и p2
(select *,case when ((src5.all_potr_react>999.99 or src5.all_potr_gen>999.99) and src5.pwr>16) then ROUND(src5.potr_react*src5.eerm*t,2)::numeric(14,2) else 0 end as ps,
case when ((src5.potr_react>999.99 or src5.potr_gen>999.99) and src5.pwr>16) then ROUND(src5.potr_gen*src5.eerm*t,2)::numeric(14,2) else 0 end as pg,
sum(case when ((src5.all_potr_react>999.99 or src5.all_potr_gen>999.99) and src5.pwr>16) then ROUND(src5.potr_react*src5.eerm*t,2)::numeric(14,2) else 0 end) OVER (PARTITION BY src5.code_tu) as all_ps,
sum(case when ((src5.potr_react>999.99 or src5.potr_gen>999.99) and src5.pwr>16) then ROUND(src5.potr_gen*src5.eerm*t,2)::numeric(14,2) else 0 end) OVER (PARTITION BY src5.code_tu) as all_pg
from
-- Получаем данные ps и pg
(select a.eerm,a.hour_month,a.power as pwr,a.name,src4.*,
sum(src4.potr_react) OVER (PARTITION BY src4.code_tu) as all_potr_react,
sum(src4.potr_gen) OVER (PARTITION BY src4.code_tu) as all_potr_gen
from get_datainput(id_cl) a
left join 
(select *,case when src3.tg_r>2 then 2 else src3.tg_r end as tg_rp
from
-- Получаем применяемый тангенс
(select *,case when src2.potr_act>0 then ROUND((sum(src2.potr_react) OVER (PARTITION BY src2.code_area))/(sum(src2.potr_act) OVER (PARTITION BY src2.code_area)),2) else tg_norm end AS tg_r
from
-- Показания по видам энергии
(select src1.code_area,src1.code_tu,src1.code_eqp,
sum(case when src1.vid_e=1 then src1.potr end) as potr_act,
sum(case when src1.vid_e=2 then src1.potr end) as potr_react,
sum(case when src1.vid_e=3 then src1.potr end) as potr_gen
from
-- Последние показания по потребителю
(select max(a.date) as date,a.code_tu,a.code_area,a.code_eqp,a.vid_e,case when a.value_diff is null then a.value else value_diff end as potr 
from legal_indic a
where a.id_client=$1
group by 2,3,4,5,6) as src1
group by 1,2,3) as src2) as src3) as src4 on
a.code_tu=src4.code_tu) as src5)
as src6)
as src7) as src8;

end;
$BODY$
  LANGUAGE plpgsql VOLATILE STRICT
  COST 100
  ROWS 1000;
ALTER FUNCTION public.get_calc_reactiv(integer)
  OWNER TO postgres;








---- 28.01.2019 -------
-- Запрос по поиску клиентов
select distinct v.client_main as id_client,v.adr_old,v.addr,v.lic_sch,v.name_s,v.name_f,v.tel,v.tel_work,v.email,
v.flg as flag_budjet,v.dti as dt_indicat,v.edrpou,count(v.code_tu) as kol_tu,v.kol from
(select a.*,c.*,b.kol,e.potr_act,e.potr_react,w.*,r.num_eqp as eis,a.flag_budjet as flg,a.dt_indicat as dti  from vw_client a
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
(select z.id_client,sum(potr_act) as potr_act,sum(potr_react) as potr_react from
(select h.*,case when h.vid_e=1 then case when u.value_diff is null then u.value else value_diff end end as potr_act,
case when h.vid_e=2 then case when u.value_diff is null then u.value else value_diff end end as potr_react
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
eqm_equipment_tbl r on w.code_tu=r.id
where a.id_client=12768
) as v
group by v.client_main,v.lic_sch,v.name_s,v.name_f,v.tel,v.edrpou,v.kol,
v.adr_old,v.addr,v.tel_work,v.email,v.flg,v.dti



-- 06.02.19 ----
Изменение eerm
select del_notrigger('eqm_point_tbl','update eqm_point_tbl set d=0.0615 where code_eqp=120513')


select * from get_calc_reactiv_sub(11843)

select * from atab_r

update atab_r a
	set ps=b.ps1,pg=b.pg1,all_ps=b.all_ps1,all_pg=b.all_pg1,p1=b.p1q, p2=case when b.p1q=0 then 0 else b.p2qq end,p3=b.p3q
	from (select *,(src8.p1q+src8.p2q) as p3q,sum(p2q) OVER (PARTITION BY src8.code_area) as p2qq
	from 
	-- Получаем p3
	(select *,case when ((src7.all_ps1 is null or src7.all_ps1=0) and (src7.all_pg1 is null or src7.all_pg1=0)) then 0 else src7.p1_1 end as p1q,
	case when ((src7.all_ps1 is null or src7.all_ps1=0) and (src7.all_pg1 is null or src7.all_pg1=0)) then 0 else src7.p2_1 end as p2q
	from
	(select *,sum(case when src6.all_ps1 is null then 0 else src6.all_ps1 end + case when src6.all_pg1 is null then 0 else src6.all_pg1 end) OVER (PARTITION BY src6.code_area) as p1_1,
	ROUND(coalesce(src6.all_ps1,0)*power((src6.tg_rp-0.25),2),2) AS p2_1
	from
	-- Получаем p1 и p2
	(select *,case when ((src5.all_potr_react>999.99) and src5.pwr>16) then ROUND(src5.potr_react*src5.eerm*0.8,2)::numeric(14,2) else 0::numeric(14,2) end as ps1,
	0::numeric(14,2) as pg1,
	sum(case when ((src5.all_potr_react>999.99) and src5.pwr>16) then ROUND(src5.potr_react*src5.eerm*0.8,2)::numeric(14,2) else 0::numeric(14,2) end) OVER (PARTITION BY src5.code_tu) as all_ps1,
	0::numeric(14,2) as all_pg1
	from
	(select a.*,sum(a.potr_react) OVER (PARTITION BY a.code_tu) as all_potr_react
	from atab_r a ) as src5)
	as src6)
	as src7)
	as src8) as b
	where a.id_client=b.id_client
	and a.code_ptu=b.code_ptu and a.code_tu=b.code_tu;




