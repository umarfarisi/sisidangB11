<?php
session_start();
include '../database-config.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Jadwal Non-Sidang Dosen - SISIDANG</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
    <div class="row">
        <h3>Jadwal Non-Sidang Dosen</h3>
        <form class="form-horizontal" method="post" action="addAction.php">
            <fieldset>
                <button type="submit" class="btn btn-primary">Simpan</button>
                <div class="form-group">
                    <label class="col-md-5 control-label" for="nipdosen">Dosen</label>
                    <div class="col-md-5">
                        <select id="nipdosen" name="nipdosen" class="form-control">
                            <?php
                            if ($_SESSION['role'] == 'dosen') {
                                $username = $_SESSION['username'];

                                $query = <<<SQL
select * from dosen
  where username='$username'
SQL;

                                $result = pg_query($conn,$sql);
                                $lecturer = pg_fetch_assoc($result);

                                echo '<option value="' . $lecturer->nip . '">' . $lecturer->nama . '</option>';
                            } else {
                                $query = <<<SQL
select * from dosen
SQL;

                                $result = pg_query($conn,$sql);
                                $lecturers = pg_fetch_assoc($result);

                                foreach ($lecturers as $lecturer) {
                                    echo '<option value="' . $lecturer->nip . '">' . $lecturer->nama . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-5 control-label" for="tanggalmulai">Tanggal Mulai</label>
                    <div class="col-md-5">
                        <input id="tanggalmulai" name="tanggalmulai" placeholder="YYYY-MM-DD" class="form-control input-md" required="" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-5 control-label" for="tanggalselesai">Tanggal Selesai</label>
                    <div class="col-md-5">
                        <input id="tanggalselesai" name="tanggalselesai" placeholder="YYYY-MM-DD" class="form-control input-md" required="" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-5 control-label" for="repetisi">Kegiatan Berulang</label>
                    <div class="col-md-5">
                        <div class="radio">
                            <label for="repetisi-0">
                                <input name="repetisi" id="repetisi-0" value="Harian" checked="checked" type="radio">
                                Harian
                            </label>
                        </div>
                        <div class="radio">
                            <label for="repetisi-1">
                                <input name="repetisi" id="repetisi-1" value="Mingguan" type="radio">
                                Mingguan
                            </label>
                        </div>
                        <div class="radio">
                            <label for="repetisi-2">
                                <input name="repetisi" id="repetisi-2" value="Bulanan" type="radio">
                                Bulanan
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-5 control-label" for="alasan">Keterangan</label>
                    <div class="col-md-5">
                        <textarea class="form-control" id="alasan" name="alasan"></textarea>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</div>
</body>
</html>