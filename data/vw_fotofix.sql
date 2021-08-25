create view vw_fotofix as
select a.id,a.note,a.f1,b.LS as ls,b.potrebitel,b.adres,b.dates,e.names as nazv_sob,
f.names as nazv_res,d.names as type_foto,a.foto_id as id_typeimage,b.res_id as id_res,
b.sob_id as id_event,c.fio as operator
from bfoto a 
left join bsob b on a.bsob_id = b.id 
left join users c on a.user_id=c.id 
left join spr_foto d on a.foto_id=d.id 
left join spr_sob e on b.sob_id=e.id 
left join spr_res f on b.res_id=f.id 
