<?php
$id = $_GET['id'];

$query = <<<SQL
delete from jadwal_non_sidang
  where id=$id;
SQL;

pg_query($query);

header('Location: ./index.php');