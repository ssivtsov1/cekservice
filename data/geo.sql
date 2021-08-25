select a.*,b.name 
from street a
left join streettype b on
a.streettypecode=b.id


select a.*,b.* from address a
left join street b on
a.streetcode=b.code

select * from street a where code=765

select a.zip,b.name as street,b.name_town,a.locationhouse,a.locationapp from address a
left join street b on
a.streetcode=b.code

select * from address 

