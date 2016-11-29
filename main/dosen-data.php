<?php

	include "../database-config.php";

	if(isset($_POST["month"]) && isset($_POST["year"])){

		$sql = "SELECT EXTRACT(DAY FROM JS.Tanggal) as day FROM jadwal_sidang JS WHERE EXTRACT(MONTH FROM JS.Tanggal) = ".$_POST["month"]." AND EXTRACT(YEAR FROM JS.Tanggal) = ".$_POST["year"].";" ;

		$result = pg_query($conn, $sql);

		if($result !== FALSE){
			$row = pg_fetch_all($result);
			if($row !== FALSE){

				$output = array("sql" => $sql,'result' => "sukses", 'data' => $row, 'count'=> count($row));
				echo json_encode($output);
			}else{
				// echo "Data Tidak Ada";
				$output = array("sql" => $sql,'result' => "gagal row false", 'data' => "[]", 'count'=> 0);
				echo json_encode($output);
			}
		}else{
			// echo "Data Tidak Ada";
			$output = array("sql" => $sql,'result' => "gagal result false", 'data' => "[]", 'count'=> 0);
			echo json_encode($output);
		}
	}else{
		$output = array('result' => "gagal data tidak tertransfer", 'data' => "[]", 'count'=> 0);
		echo json_encode($output);
	}

?>