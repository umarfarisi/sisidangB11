<?php

	include "../database-config.php";

<<<<<<< HEAD
	if(isset($_POST["start"]) && isset($_POST["searchBy"]) && isset($_POST["term"]) && isset($_POST["jenisSidang"]) && isset($_POST["npm"]) && isset($_POST["start"])){
		$sql = "SELECT MKS.IDMKS, JMKS.NamaMKS as Jenis_Sidang, M.Nama as Mahasiswa, JS.Tanggal, JS.Jam_Mulai, JS.Jam_Selesai, R.NamaRuangan FROM JENISMKS JMKS, MAHASISWA M, JADWAL_SIDANG JS, RUANGAN R, MATA_KULIAH_SPESIAL MKS ,TERM T WHERE T.TAHUN = MKS.TAHUN AND T.SEMESTER = MKS.SEMESTER AND JS.IDRuangan = R.IDRuangan AND MKS.IDMKS = JS.IDMKS AND MKS.NPM = M.NPM AND MKS.IDJenisMKS = JMKS.ID AND MKS.IsSiapSidang = true ";
		if($_POST["searchBy"] === "jenisSidang"){
			$term = explode("/", $_POST["term"]);
			$tahun = $term[0];
			$semester = $term[1];
			$sql .= " AND JMKS.NamaMKS = '".$_POST["jenisSidang"]."' AND T.Tahun = $tahun AND T.Semester = $semester ";
		}else if($_POST["searchBy"] === "mahasiswa"){
			$sql .= " AND M.NPM = '".$_POST["npm"]."' ";
		}
		$sql .= " ORDER BY JS.Tanggal, JS.Jam_Mulai, JS.Jam_Selesai LIMIT 10 OFFSET ".$_POST["start"].";";
=======
	if(isset($_POST["start"])){

		$sql = "SELECT mks.judul, mks.idmks, JMKS.NamaMKS as jenis_sidang, M.Nama as mahasiswa, JS.Tanggal, JS.Jam_Mulai, JS.Jam_Selesai, R.NamaRuangan from jenismks jmks, mata_kuliah_spesial mks, mahasiswa m, jadwal_sidang js, ruangan r, term t where jmks.id = mks.idjenismks and mks.npm = m.npm and mks.idmks = js.idmks and js.idruangan = r.idruangan and mks.issiapsidang = true " ;

		if(isset($_POST["searchBy"]) && isset($_POST["term"]) && isset($_POST["jenisSidang"]) && isset($_POST["npm"])){
			if($_POST["searchBy"] === "jenisSidang"){
				$term = explode("/", $_POST["term"]);
				$tahun = $term[0];
				$semester = $term[1];
				$sql .= " AND JMKS.NamaMKS = '".$_POST["jenisSidang"]."' AND T.Tahun = $tahun AND T.Semester = $semester ";
			}else if($_POST["searchBy"] === "mahasiswa"){
				$sql .= " AND M.NPM = '".$_POST["npm"]."' ";
			}
		}

		$sql.=  " ORDER BY JS.Tanggal, JS.Jam_Mulai, JS.Jam_Selesai LIMIT 11 OFFSET ".$_POST["start"].";";
>>>>>>> implementasi_2

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

				}

				$output = array("sql" => $sql,'result' => "sukses", 'data' => $row, 'count'=> count($row));
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