CREATE OR REPLACE FUNCTION public.normal_acc(character varying)
  RETURNS character varying AS
$BODY$
declare
pos int;
y int;
r character varying;
begin
pos=position('/' in $1);
if pos>0 then
	r=substr($1,pos+1);
else
	r=$1;
end if;
y=length(trim(r));
if y=8 and substr(r,1,1)<>'0' then
	r='0' || r;
end if;
return r;
end;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION public.normal_acc(character varying)
  OWNER TO postgres;
 

create table err_trans(
lic char(9),
err int,
ownername char(100),
val09 dec(12,4),
val10 dec(12,4),
date date
)


SELECT distinct a.*,b.fio as boss FROM `vw_phone` a 
left join 1c b on a.unit_2=b.unit_2 and b.post='Начальник' and a.unit_2<>'Апарат управління'


select *,case when boss1 is null then main_unit else boss1 end as boss from (
SELECT a.*,(select  q.fio  from 1c q where case when q.unit_2='Загальновиробничий персонал' then q.unit_1=a.unit_1 else q.unit_2=a.unit_2 end
                     and q.post='Начальник' and q.unit_2<>'Апарат управління' limit 1)  boss1 FROM `vw_phone` a
    ) z



select *,case when boss2 like '% РЕМ%' then 
(select  q1.fio  from 1c q1 where q.main_unit=boss2.main_unit 
                     and q1.post='Начальник' and q1.unit_2<>'Апарат управління' limit 1) 
else boss2 end from (
select *,case when boss1 is null then main_unit else boss1 end as boss2 from (
SELECT a.*,(select  q.fio  from 1c q where case when q.unit_2='Загальновиробничий персонал' then q.unit_1=a.unit_1 else q.unit_2=a.unit_2 end
                     and q.post='Начальник' and q.unit_2<>'Апарат управління' limit 1)  boss1 FROM `vw_phone` a
    ) z
   
    ) r


SELECT a.*,b.accountid FROM cc_crash a 
left JOIN cc_crash_account b ON 
a.accidentid=b.accidentid
WHERE a.accbegin_date>='2021-07-22'



{youtube}qgJwRtN9gMw{/youtube}   // promo

{youtube}bRBUpXuz4OQ{/youtube}






