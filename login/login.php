<?php

if(isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["role"])){

	$host = "localhost"; 
	$user = "postgres"; 
	$pass = "basdattugasakhir"; 
	$db = "postgres"; 

	$conn = pg_connect("host=$host dbname=$db user=$user password=$pass") ;
	
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
		echo "gagal";
	}else{

		$table = $_POST["role"];

		if($table === "mahasiswa" || $table === "dosen"){
			$sql = "SELECT * FROM ".$_POST["role"]." WHERE username = '".$_POST["username"]."';";

			$result = pg_query($conn, $sql);

			if($result !== FALSE){
				$row = pg_fetch_array($result);
				if($row !== FALSE){
					$password_from_server = $row["password"];
					$password_from_user = $_POST["password"];
					if($password_from_server === $password_from_user){
						$output = array("result"=>"match", "message"=>$row);
						echo json_encode($output);
					}else{
						$row = array("result"=>"dismatch", "message"=>"password wrong");
						echo json_encode($row);
					}
				}else{
					$row = array("result"=>"dismatch", "message"=>"username ".$_POST["username"]." tidak terdaftar");
					echo json_encode($row);
				}
			}else{
				$row = array("result"=>"dismatch", "message"=>"data tidak ada");
				echo json_encode($row);
			}
		}else if($table === "admin"){
			if($_POST["username"] === "admin"){
				if($_POST["password"] === "rahasia"){
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
		}

	}

	pg_close($conn);

}else{
	echo "data gagal ditransfer";
}

?>