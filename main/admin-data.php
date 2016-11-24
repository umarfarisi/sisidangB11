<?php

	include "../database-config.php";

	if(isset($_POST["start"])){
		$sql = "SELECT MKS.IDMKS, JMKS.NamaMKS as Jenis_Sidang, M.Nama as Mahasiswa, JS.Tanggal, JS.Jam_Mulai, JS.Jam_Selesai, R.NamaRuangan FROM JENISMKS JMKS, MAHASISWA M, JADWAL_SIDANG JS, RUANGAN R, MATA_KULIAH_SPESIAL MKS WHERE JS.IDRuangan = R.IDRuangan AND MKS.IDMKS = JS.IDMKS AND MKS.NPM = M.NPM AND MKS.IDJenisMKS = JMKS.ID AND MKS.IsSiapSidang = true ORDER BY JS.Tanggal, JS.Jam_Mulai, JS.Jam_Selesai LIMIT 10 OFFSET ".$_POST["start"].";";

		$result = pg_query($conn, $sql);

		if($result !== FALSE){
			$row = pg_fetch_all($result);
			if($row !== FALSE){
				for($i = 0 ; $i < count($row) ; $i++){

					$sql_dosen_pembimbing = "SELECT D.Nama"
					." FROM DOSEN D, DOSEN_PEMBIMBING DP, MATA_KULIAH_SPESIAL MKS, MAHASISWA M "
					." WHERE M.NPM = MKS.NPM AND MKS.IDMKS = DP.IDMKS AND DP.NIPDOSENPEMBIMBING = D.NIP "
					." AND MKS.IDMKS = ".$row[$i]['idmks']
					.";";

					$result_dosen_pembimbing = pg_query($conn, $sql_dosen_pembimbing);

					if($result_dosen_pembimbing !== FALSE){
						$row_dosen_pembimbing = pg_fetch_all($result_dosen_pembimbing);
						if($row_dosen_pembimbing !== FALSE){
							$row[$i]['pembimbing'] = $row_dosen_pembimbing;
						}else{
							$row[$i]['pembimbing'] = array();
						}
					}else{
						$row[$i]['pembimbing'] = array();
					}

					$sql_dosen_penguji = "SELECT D.Nama"
					." FROM DOSEN D, DOSEN_PENGUJI DP, MATA_KULIAH_SPESIAL MKS, MAHASISWA M "
					." WHERE M.NPM = MKS.NPM AND MKS.IDMKS = DP.IDMKS AND DP.NIPDOSENPENGUJI = D.NIP "
					." AND MKS.IDMKS = ".$row[$i]['idmks']
					.";";

					$result_dosen_penguji = pg_query($conn, $sql_dosen_penguji);

					if($result_dosen_penguji !== FALSE){
						$row_dosen_penguji = pg_fetch_all($result_dosen_penguji);
						if($row_dosen_pembimbing !== FALSE){
							$row[$i]['penguji'] = $row_dosen_penguji;
						}else{
							$row[$i]['penguji'] = array();
						}
					}else{
						$row[$i]['penguji'] = array();
					}

					// echo "<tr>";
					// echo "<td>".$row[$i]["jenis_sidang"]."</td>";
					// echo "<td>".$row[$i]["mahasiswa"]."</td>";
					// // echo "<td>".$row[$i]["dosen_pembimbing"]."</td>";
					// // echo "<td>".$row[$i]["dosen_penguji"]."</td>";
					// echo "<td>".$row[$i]["tanggal"]." || ".$row[$i]["jam_mulai"]." || ".$row[$i]["jam_selesai"]." || ".$row[$i]["namaruangan"]."</td>";
					// echo "<td><button class=\"btn btn-default\" >Edit</button></td>";
					// echo "</tr>";
				}
				$output = array('result' => "sukses", 'data' => $row, 'count'=> count($row));
				echo json_encode($output);
			}else{
				// echo "Data Tidak Ada";
				$output = array('result' => "gagal", 'data' => "[]", 'count'=> 0);
				echo json_encode($output);
			}
		}else{
			// echo "Data Tidak Ada";
			$output = array('result' => "gagal", 'data' => "[]", 'count'=> 0);
			echo json_encode($output);
		}
	}else{
		$output = array('result' => "gagal", 'data' => "[]", 'count'=> 0);
		echo json_encode($output);
	}

?>