<?php

include('./class/db_Class.php');
$obj=new db_class();
$obj->FlyPrepare("DROP TABLE IF EXISTS reorder");
$obj->FlyPrepare("DROP TABLE IF EXISTS reorder_user");
$obj->FlyPrepare("CREATE TABLE IF NOT EXISTS reorder
(
id int(20) auto_increment primary key,
store_id int(20),
pid int(20),
stock float(10,2),
date text,
datetime TIMESTAMP,
status ENUM('1','2')
)");

$obj->FlyPrepare("CREATE TABLE IF NOT EXISTS reorder_user
(
id int(20) AUTO_INCREMENT PRIMARY KEY,
rid text,
store_id int(20),
date date,
datetime timestamp
)");



$obj->FlyPrepare("INSERT INTO reorder (store_id,pid,date,status,stock)
SELECT ro.store_id,ro.id,CURDATE(),'1' as status,ro.stock FROM (select
p.id,
p.store_id,
p.name,
p.quantity,
IFNULL(SUM(s.quantity),0) as sold,
(IFNULL(p.quantity,0)-IFNULL(SUM(s.quantity),0)) as stock,
p.reorder,
CASE p.reorder WHEN IFNULL(p.reorder,0)>(IFNULL(p.quantity,0)-IFNULL(SUM(s.quantity),0)) THEN '1'
ELSE '0' END AS reorder_status
from product as p
LEFT JOIN sales as s on s.pid=p.id
GROUP BY p.id) as ro WHERE ro.reorder_status='1' AND ro.reorder!='0'");
?>
