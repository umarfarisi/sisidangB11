<!DOCTYPE html>
<html>
<head>
	<title>Jadwal Sidang</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<style type="text/css">
		h1{
			text-align: center;
			margin: 10px 0px;
		}
		h2{
			text-align: center;
			margin: 10px 0px;
		}
	  	.containers{
	  		max-width: 600px;
	  		margin: 10px auto;
	  	}
	</style>
</head>
<body>

</body>
</html>
<?php

include "../database-config.php";
session_start();

if(isset($_SESSION["role"])){
  if($_SESSION["role"] === "mahasiswa"){
    include "mahasiswa.php";
  }else if($_SESSION["role"] === "admin"){
    include "admin.php";
  }else if($_SESSION["role"] === "dosen"){
    include "dosen.php";
  }
}

?>