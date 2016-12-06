<?php
session_start();
include '../database-config.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Jadwal Non-Sidang Dosen - SISIDANG</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
    <div class="row">
        <h3>Jadwal Non-Sidang Dosen</h3>
        <a href="add.php" role="button" class="btn btn-default">Tambah</a>
        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>Tanggal</th>
                <th>Keterangan</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php
            if ($_SESSION['role'] == 'admin' || $_SESSION["role"] == 'dosen') {
                $query = <<<SQL
select * from jadwal_non_sidang
  natural join dosen
SQL;

                $result = pg_query($conn, $query);

                $schedule = pg_fetch_all($result);

                foreach ($schedule as $event) {
                    if ($_SESSION['role'] == 'dosen') {
                        if ($username == '$_SESSION["username"]') {
                            echo '<tr><td>' . $event['tanggalmulai'] . ' - ' . $event['tanggalselesai'] . '</td><td>' . $event['alasan'] . '</td><td><a href="edit.php?id=' . $event['idjadwal'] . '">Edit</a></td></tr>';
                        }
                    } else {
                        echo '<tr><td>' . $event['tanggalmulai'] . ' - ' . $event['tanggalselesai'] . '</td><td>' . $event['alasan'] . '</td><td><a href="edit.php?id=' . $event['idjadwal'] . '">Edit</a></td></tr>';
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