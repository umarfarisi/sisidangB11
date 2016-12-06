<?php
include '../database-config.php';
$idjadwal = $_GET['idjadwal'];
$query = <<<SQL
update jadwal_sidang set issiapsidang=true, izinmajusidang=false where idjadwal=$idjadwal
SQL;
$result = pg_query($conn, $query);
header('Location: /izin_jadwal_sidang/index.php');