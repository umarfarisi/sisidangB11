<?php

include "../database-config.php";
session_start();

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