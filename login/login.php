<?php

if(isset($_POST["username"]) && isset($_POST["password"])){

	include "../database-config.php";
	session_start();
	
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
		echo "gagal";
	}else{

		if($_POST["username"] === "admin"){
			if($_POST["username"] === "admin"){
				if($_POST["password"] === "rahasia"){
					$_SESSION["username"] = "admin";
					$_SESSION["role"] = "admin";
					$row = array("result"=>"admin", "message"=>"");
					echo json_encode($row);
				}else{
					$row = array("result"=>"dismatch", "message"=>"password admin salah");
					echo json_encode($row);
				}
			}else{
				$row = array("result"=>"dismatch", "message"=>"admin tidak terdaftar");
				echo json_encode($row);
			}
		}else{
			$sql = "SELECT * FROM Mahasiswa WHERE username = '".$_POST["username"]."';";

			$result = pg_query($conn, $sql);

			if($result !== FALSE){
				$row = pg_fetch_array($result);
				if($row !== FALSE){
					$password_from_server = $row["password"];
					$password_from_user = $_POST["password"];
					if($password_from_server === $password_from_user){
						$_SESSION["username"] = $_POST["username"];
						$_SESSION["role"] = "mahasiswa";
						$output = array("result"=>"match", "message"=>$row);
						echo json_encode($output);
					}else{
						$row = array("result"=>"dismatch", "message"=>"password wrong");
						echo json_encode($row);
					}
				}else{

					//SQL DI DOSEN

					$sql_dosen = "SELECT * FROM Dosen WHERE username = '".$_POST["username"]."';";

					$result_dosen = pg_query($conn, $sql_dosen);

					if($result_dosen !== FALSE){
						$row_dosen = pg_fetch_array($result_dosen);
						if($row_dosen !== FALSE){

							$_SESSION["username"] = $_POST["username"];
							$_SESSION["role"] = "dosen";
							$output = array("result"=>"match", "message"=>$row);
							echo json_encode($output);

						}else{
							$row_dosen = array("result"=>"dismatch", "message"=>"username ".$_POST["username"]." tidak terdaftar");
							echo json_encode($row_dosen);
						}
					}
				}
			}else{
				$row = array("result"=>"dismatch", "message"=>"data tidak ada");
				echo json_encode($row);
			}

		}

	}

	pg_close($conn);

}else{
	echo "data gagal ditransfer";
}

?>