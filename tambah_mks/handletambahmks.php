<?php 
        require "database.php";
        $conn = connectDB();
        pg_query($conn,"SET SEARCH_PATH TO SISIDANG");
        session_start(); 
        

        $formatpembimbing = true;
        $tahun = $_POST['tahun'];
        $semester = $_POST['semester'];
        $jenismks =$_POST['jenis_mks']; 
        $namamahasiswa = $_POST['nama_mahasiswa'];
        $judulmks = $_POST['judul_mks'];
        $namapembimbing1 = $_POST['nama_pembimbing1'];
        $namapembimbing2 = $_POST['nama_pembimbing2'];
        $namapembimbing3 = $_POST['nama_pembimbing3'];
        $namapenguji = $_POST['nama_penguji1'];

        if ((strcmp($namapembimbing1,$namapembimbing2)==0)  ||  (strcmp($namapembimbing2,$namapembimbing3)==0)  ||  (strcmp($namapembimbing1,$namapembimbing3)==0) ){
        	echo "Pembimbing tidak boleh sama";
        	exit;
        }

        echo "Tahun: ".$tahun."<br>";
        echo "Semester: ".$semester."<br>";
        echo "Jenis MKS: ".$jenismks."<br>";
        echo "Mahasiswa: ".$namamahasiswa."<br>";
        echo "Judul MKS: ".$judulmks."<br>";
        echo "Pembimbing 1: ".$namapembimbing1."<br>";
        echo "Pembimbing 2: ".$namapembimbing2."<br>";
        echo "Pembimbing 3: ".$namapembimbing3."<br>";
        echo "Penguji 1: ".$namapenguji."<br>";

        $result = pg_query($conn, "SELECT idmks from mata_kuliah_spesial order by idmks desc limit 1;");
        $lastidmks = pg_fetch_array($result,0)['idmks'];
        $idmks = $lastidmks + 1;

        $result = pg_query($conn, "SELECT npm from mahasiswa where nama='$namamahasiswa';");
        $npm = pg_fetch_array($result,0)['npm'];

        $result = pg_query($conn, "SELECT id from jenismks where namamks='$jenismks';");
        $idjenismks = pg_fetch_array($result,0)['id'];

        $insert = pg_query($conn, "INSERT INTO mata_kuliah_spesial values ('$idmks', '$npm', '$tahun', '$semester', '$judulmks', 'false', 'false', 'false', '$idjenismks');");

        echo "Berhasil memasukan data";


        ?>


