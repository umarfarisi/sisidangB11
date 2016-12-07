<?php
$nipdosen = $_POST['nipdosen'];
$tanggalmulai = $_POST['tanggalmulai'];
$tanggalselesai = $_POST['tanggalselesai'];
$alasan = $_POST['alasan'];
$repetisi = $_POST['repetisi'];

$query = <<<SQL
insert into jadwal_non_sidang (tanggalmulai,tanggalselesai,repetisi,alasan,nipdosen)
  values ('$tanggalmulai', '$tanggalselesai', '$repetisi', '$alasan', '$nipdosen');
SQL;

header('Location: ./index.php');