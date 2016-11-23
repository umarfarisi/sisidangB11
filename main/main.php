<?php

include "../database-config.php";
session_start();

?>
<!DOCTYPE html>
<html>
<head>
	<title>Halaman Utama</title>
	  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script type="text/javascript">
      $ ( document ). ready ( function (){
          cekUser();

          //Untuk mengecek apakah user sudah login atau belum
          function cekUser(){
            if(sessionStorage.getItem("user") === null){
              window.open("../login/login.html","_self");
            }else{
              $("#username").html("Welcome "+sessionStorage.getItem("user")+", ");
            }
          }

          $("#logout-btn").click(function(){
            sessionStorage.removeItem('user');
            cekUser();
          });

      });
    </script>
	  <style type="text/css">
	  	#logout-btn{
	  		margin-top: 6px;
	  		float: right;
	  	}
	  	.containers{
	  		max-width: 1200px;
	  		margin: auto;
	  	}
      .search-input{
        margin-top: 5px;
        margin-bottom: 5px;
      }
	  </style>
</head>
<body>


<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#" id="username">SI Sidang</a>
    </div>
    <ul class="nav navbar-nav">
      <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Jadwal<span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li id="buat-jadwal-sidang-mks"><a href="#">Buat Jadwal Sidang MKS</a></li>
          <li id="buat-jadwal-non-sidang-dosen"><a href="#">Buat Jadwal Non-Sidang Dosen</a></li>
          <li id="lihat-jadwal-sidang"><a href="#">Lihat Jadwal Sidang</a></li>
        </ul>
      </li>
      <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Mata Kuliah Sepesial<span class="caret"></span></a>
      	<ul class="dropdown-menu">
	        <li id="tambah-peserta-mks"><a href="#">Tambah Peserta MKS</a></li>
	        <li id="lihat-dftar-mks"><a href="#">Lihat Daftar MKS</a></li>
        </ul>
      </li>
    </ul>
    <button class="btn btn-danger" id="logout-btn">Logout</button>
  </div>
</nav>

<?php 
if(isset($_SESSION["role"])){
  if($_SESSION["role"] === "mahasiswa"){
    include "mahasiswa.php";
  }else if($_SESSION["role"] === "admin"){
    include "admin.php";
  }else if($_SESSION["role"] === "dosen"){
    include "admin.php";
  }
}
?>

</body>
</html>