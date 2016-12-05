<?php
session_start();
include '../database-config.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Izin Jadwal Sidang - SISIDANG</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
    <div class="row">
        <h3>Izin Jadwal Sidang <span style="color:red;"><?php echo '(' . 'admin' . ')' ?></span></h3>
        <p>Sort by <a href="#">[Mahasiswa]</a>, <a href="#">[Jenis sidang]</a>, <a href="#">[Waktu]</a></p>
        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>Mahasiswa</th>
                <th>Jenis sidang</th>
                <th>Judul</th>
                <th>Waktu &amp; lokasi</th>
                <th>Pembimbing lain</th>
                <th>Izinkan maju sidang</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $query = <<<SQL
select * from jadwal_sidang
  natural join mata_kuliah_spesial
  natural join ruangan
SQL;

            $result = pg_query($conn, $query);
            $schedule = pg_fetch_all($result);

            foreach($schedule as $event) {
                if ($event['username']) {
                    echo '<tr><td>-</td><td>-</td><td>' . $event['judul'] . '</td><td>' . $event['tanggal'] . ' ' . $event['jammulai'] . ' - ' . $event['jamselesai'] . ' ' . $event['namaruangan'] . '</td><td>-</td><td><button class="btn btn-default" type="submit">Izinkan</button></td>';
                }
            }
            ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>