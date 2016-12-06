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
        <h3>Izin Jadwal Sidang</h3>
        <p>Sort by <a href="?sortby=mahasiswa">[Mahasiswa]</a>, <a href="?sortby=jenis">[Jenis sidang]</a>, <a href="?sortby=waktu">[Waktu]</a></p>
        <p><a href="<?php echo isset($_GET['sortby']) ? '?sortby=' . $_GET['sortby'] . '&asc=true' : '#' ?>">[Ascending]</a> <a href="<?php echo isset($_GET['sortby']) ? '?sortby=' . $_GET['sortby'] . '&asc=false' : '#' ?>">[Descending]</a></p>
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
            if ($_SESSION['role'] == 'admin' || $_SESSION["role"] == 'dosen') {
                if (!isset($_GET['sortby']) || $_GET['sortby'] == 'waktu') {
                    if (!isset($_GET['asc']) || $_GET['asc'] == 'true') {
                        $query = <<<SQL
select * from jadwal_sidang
  natural join mata_kuliah_spesial
  natural join ruangan
  natural join mahasiswa
  where izinmajusidang=true
  order by tanggal, jam_mulai
SQL;
                    } else {
                        $query = <<<SQL
select * from jadwal_sidang
  natural join mata_kuliah_spesial
  natural join ruangan
  natural join mahasiswa
  where izinmajusidang=true
  order by tanggal, jam_mulai desc
SQL;
                    }
                } else if ($_GET['sortby'] == 'mahasiswa') {
                    if (!isset($_GET['asc']) || $_GET['asc'] == 'true') {
                        $query = <<<SQL
select * from jadwal_sidang
  natural join mata_kuliah_spesial
  natural join ruangan
  natural join mahasiswa
  where izinmajusidang=true
  order by nama
SQL;
                    } else {
                        $query = <<<SQL
select * from jadwal_sidang
  natural join mata_kuliah_spesial
  natural join ruangan
  natural join mahasiswa
  where izinmajusidang=true
  order by nama desc
SQL;
                    }
                } else if ($_GET['sortby'] == 'jenis') {
                    if (!isset($_GET['asc']) || $_GET['asc'] == 'true') {
                        $query = <<<SQL
select * from jadwal_sidang
  natural join mata_kuliah_spesial
  natural join ruangan
  natural join mahasiswa
  where izinmajusidang=true
  order by namamks
SQL;
                    } else {
                        $query = <<<SQL
select * from jadwal_sidang
  natural join mata_kuliah_spesial
  natural join ruangan
  natural join mahasiswa
  where izinmajusidang=true
  order by namamks desc
SQL;
                    }
                }

                $result = pg_query($conn, $query);
                $schedule = pg_fetch_all($result);

                foreach ($schedule as $event) {
                    if ($event['username']) {
                        echo '<tr><td>' . $event['nama'] . '</td><td>' . $event['namamks'] . '</td><td>' . $event['judul'] . '</td><td>' . $event['tanggal'] . ' ' . $event['jam_mulai'] . ' - ' . $event['jam_selesai'] . ' ' . $event['namaruangan'] . '</td><td><ul>';

                        $idmks = $event['idmks'];

                        $query = <<<SQL
select * from dosen_pembimbing
  natural join dosen
  where idmks=$idmks
SQL;

                        $result1 = pg_query($conn, $query);
                        $lecturers = pg_fetch_all($result);

                        foreach ($lecturers as $lecturer) {
                            echo '<li>' . $lecturer['name'] . '</li>';
                        }

                        echo '</ul></td><td><a href="confirm_permit.php?idjadwal=' . $event['idjadwal'] . '" role="button" class="btn btn-default">Izinkan</button></td>';
                    }
                }
            } else {
                header('Location: ../login');
            }
            ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>