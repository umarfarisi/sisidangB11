<?php

	include "../database-config.php";

	if(isset($_POST["start"]) && isset($_POST["username"])){
		$sql = "SELECT M.USERNAME, MKS.IDMKS, M.Nama, JMKS.NamaMKS, MKS.Judul, JS.Tanggal, JS.JAM_MULAI, JS.JAM_SELESAI, R.NamaRuangan, MKS.IsSiapSidang, MKS.izinMajuSidang, MKS.PengumpulanHardCopy"
			." FROM MAHASISWA M, JADWAL_SIDANG JS, MATA_KULIAH_SPESIAL MKS, JENISMKS JMKS, RUANGAN R, DOSEN D, DOSEN_PEMBIMBING DP, DOSEN_PENGUJI DPI WHERE JS.IDMKS = MKS.IDMKS AND M.NPM = MKS.NPM AND MKS.IDJENISMKS = JMKS.ID AND ((DP.NIPDOSENPEMBIMBING = D.NIP AND DP.IDMKS = MKS.IDMKS) OR (DPI.NIPDOSENPENGUJI = D.NIP AND DPI.IDMKS = MKS.IDMKS))  AND D.USERNAME = '".$_POST["username"]."' "
			." GROUP BY M.USERNAME, MKS.IDMKS, M.Nama, JMKS.NamaMKS, MKS.Judul, JS.Tanggal, JS.JAM_MULAI, JS.JAM_SELESAI, R.NamaRuangan, MKS.IsSiapSidang, MKS.izinMajuSidang, MKS.PengumpulanHardCopy ";

		if(isset($_POST['sorted'])){
			if($_POST['sorted'] === 'jenissidang'){
				$sql.=  " ORDER BY JMKS.NamaMKS LIMIT 11 OFFSET ".$_POST["start"].";";
			}else if($_POST['sorted'] === 'mahasiswa'){
				$sql.=  " ORDER BY M.USERNAME LIMIT 11 OFFSET ".$_POST["start"].";";
			}else if($_POST['sorted'] === 'waktu'){
				$sql.=  " ORDER BY JS.Tanggal, JS.Jam_Mulai, JS.Jam_Selesai LIMIT 11 OFFSET ".$_POST["start"].";";
			}
		}

		$result = pg_query($conn, $sql);
		
		if($result !== FALSE){
			$row = pg_fetch_all($result);
			
			if($row !== FALSE){
				for($i = 0 ; $i < count($row) ; $i++){

					$sql_other = "SELECT D.Nama"
					." FROM DOSEN D, DOSEN_PEMBIMBING DP, MATA_KULIAH_SPESIAL MKS, MAHASISWA M "
					." WHERE M.NPM = MKS.NPM AND MKS.IDMKS = DP.IDMKS AND DP.NIPDOSENPEMBIMBING = D.NIP "
					." AND M.USERNAME = '".$row[$i]['username']
					."' AND DP.IDMKS = ".$row[$i]['idmks']
					." AND MKS.IDMKS = ".$row[$i]['idmks']
					." AND D.USERNAME <> '".$_POST['username']."';";

					$result_other = pg_query($conn, $sql_other);

					if($result_other !== FALSE){
						$row_other = pg_fetch_all($result_other);
						if($row_other !== FALSE){
							$row[$i]['pembimbing_lain'] = $row_other;
						}else{
							$row[$i]['pembimbing_lain'] = array();
						}
					}else{
						$row[$i]['pembimbing_lain'] = array();
					}

				}
				$output = array('sql' => $sql, 'result' => "sukses", 'data' => $row, 'count'=> count($row));
				echo json_encode($output);
			}else{
				$output = array('sql' => $sql, 'result' => " gagal row false", 'data' => "[]", 'count'=> 0);
				echo json_encode($output);
			}
		}else{
			$output = array('sql' => $sql, 'result' => "gagal result false", 'data' => "[]", 'count'=> 0);
			echo json_encode($output);
		}
		
	}else{
		$output = array('result' => "gagal transfer data", 'data' => "[]", 'count'=> 0);
		echo json_encode($output);
	}


?>