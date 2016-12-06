<?php 
        require "database.php";
        $conn = connectDB();
        pg_query($conn,"SET SEARCH_PATH TO SISIDANG");
        session_start(); 
        ?>

<!DOCTYPE html>
<html>
<head>
<style>
.dropbtn {
    background-color: #4CAF50;
    color: white;
    padding: 16px;
    font-size: 16px;
    border: none;
    cursor: pointer;
}

.dropbtn:hover, .dropbtn:focus {
    background-color: #3e8e41;
}

.dropdown {
    position: relative;
    display: inline-block;
}

.dropdown-content {
    display: none;
    position: absolute;
    background-color: #f9f9f9;
    min-width: 160px;
    overflow: auto;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
}

.dropdown-content a {
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
}

.dropdown a:hover {background-color: #f1f1f1}

.show {display:block;}
</style>
</head>
<body>

<h2>Tambah Data MKS</h2>
<form action = "handletambahmks.php" method = "post">

<p>Tahun </p>
<select name="tahun">
    <?php
    $result = pg_query($conn, "select tahun from term;");
    $tahun = pg_fetch_all($result);
    
    foreach($tahun as $row){ ?>
        <option value ="<?= $row['tahun']?>"><?= $row['tahun']?> </option>

    <?php
        } 
        ?>

    </select>

    <p>Semester </p>
<select name="semester">
    <?php
    $result = pg_query($conn, "select semester from term;");
    $semester = pg_fetch_all($result);
    
    foreach($semester as $row){ ?>
        <option value ="<?= $row['semester']?>"><?= $row['semester']?> </option>

    <?php
        } 
        ?>

    </select>

  <p>Jenis Mks </p>
<select name="jenis_mks">
    <?php
       $result = pg_query($conn, "select namamks from jenismks;");
       $jenis= pg_fetch_all($result);
    foreach($jenis as $row){ ?>
        <option value ="<?= $row['namamks'] ?>"><?= $row['namamks']?> </option>

    <?php
        } 
        ?>

    
</select>
  <p>Mahasiswa </p>


<select  name="nama_mahasiswa">
    <?php
       $result = pg_query($conn, "select nama from mahasiswa;");
       $nama= pg_fetch_all($result);
    foreach($nama as $row){ ?>
        <option value ="<?= $row['nama'] ?>"><?= $row['nama']?> </option>

    <?php
        } 
        ?>


</select>
  <p>Judul MKS </p>
<input type = text name = "judul_mks">


 </select> 
  <p>Pembimbing 1 </p>
<select  name="nama_pembimbing1">
    <?php
       $result = pg_query($conn, "select nama from dosen;");
       $dosen= pg_fetch_all($result);
    foreach($dosen as $row){ ?>
        <option value ="<?= $row['nama'] ?>"><?= $row['nama']?> </option>

    <?php
        } 
        ?>



</select>
    <p>Pembimbing 2 </p>
  <select  name="nama_pembimbing2">

       <?php
       $result = pg_query($conn, "select nama from dosen;");
       $dosen= pg_fetch_all($result);
    foreach($dosen as $row){ ?>
        <option value ="<?= $row['nama'] ?>"><?= $row['nama']?> </option>

    <?php
        } 
        ?>



</select>
    <p>Pembimbing 3 </p>
<select  name="nama_pembimbing3">
    
           <?php
       $result = pg_query($conn, "select nama from dosen;");
       $dosen= pg_fetch_all($result);
    foreach($dosen as $row){ ?>
        <option value ="<?= $row['nama'] ?>"><?= $row['nama']?> </option>

    <?php
        } 
        ?>


</select>
     <p>Penguji 1 </p>
<select  name="nama_penguji1">

       <?php
       $result = pg_query($conn, "select nama from dosen;");
       $dosen= pg_fetch_all($result);
    foreach($dosen as $row){ ?>
        <option value ="<?= $row['nama'] ?>"><?= $row['nama']?> </option>

    <?php
        } 
        ?>

 
</select>



<button type="button" >tambah penguji</button>

<br>

<input type="submit" value= "Simpan" >

<br>

        <a href="daftarmksdosen.php"><input type="button" value="batal"></a>

</form>

<script>
/* When the user clicks on the button, 
toggle between hiding and showing the dropdown content */
function myFunction() {
    document.getElementById("myDropdown").classList.toggle("show");
}

// Close the dropdown if the user clicks outside of it
window.onclick = function(event) {
  if (!event.target.matches('.dropbtn')) {

    var dropdowns = document.getElementsByClassName("dropdown-content");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
}
</script>

</body>
</html>
