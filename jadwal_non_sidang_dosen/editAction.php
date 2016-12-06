<?php
$idjadwal = $_GET['id'];
$nipdosen = $_POST['nipdosen'];
$tanggalmulai = $_POST['tanggalmulai'];
$tanggalselesai = $_POST['tanggalselesai'];
$alasan = $_POST['alasan'];
$repetisi = $_POST['repetisi'];

$query = <<<SQL
update jadwal_non_sidang
  set nipdosen=$nipdosen, tanggalmulai=$tanggalmulai, tanggalselesai=$tanggalselesai, alasan=$alasan
  where idjadwal=$idjadwal;
SQL;

header('Location: ./index.php');