<?php
	include "../database-config.php";
	session_start();
	if(isset($_POST["searchBy"]) && isset($_POST["term"]) && isset($_POST["jenisSidang"]) && isset($_POST["npm"])){

		$sql = "SELECT JMKS.NamaMKS as Jenis_Sidang, M.Nama as Mahasiswa, DPN.Nama as Dosen_Pembimbing, DPI.Nama as Dosen_Penguji, JS.Tanggal, JS.Jam_Mulai, JS.Jam_Selesai, R.NamaRuangan FROM JENISMKS JMKS, MAHASISWA M, DOSEN DPN, DOSEN DPI, JADWAL_SIDANG JS, RUANGAN R, MATA_KULIAH_SPESIAL MKS, DOSEN_PENGUJI DDPI, DOSEN_PEMBIMBING DDPN WHERE JS.IDRuangan = R.IDRuangan AND MKS.IDMKS = JS.IDMKS AND MKS.IDMKS = DDPI.IDMKS AND MKS.IDMKS = DDPN.IDMKS AND MKS.NPM = M.NPM AND MKS.IDJenisMKS = JMKS.ID AND DDPI.NIPDosenPenguji = DPI.NIP AND DDPN.NIPDosenPembimbing = DPN.NIP AND MKS.IsSiapSidang = true ORDER BY JS.Tanggal, JS.Jam_Mulai, JS.Jam_Selesai LIMIT 10;";

		if($_POST["searchBy"] === "jenisSidang"){
			$term = explode("/", $_POST["term"]);
			$tahun = $term[0];
			$semester = $term[1];
			$sql = "SELECT JMKS.NamaMKS as Jenis_Sidang, M.Nama as Mahasiswa, DPN.Nama as Dosen_Pembimbing, DPI.Nama as Dosen_Penguji, JS.Tanggal, JS.Jam_Mulai, JS.Jam_Selesai, R.NamaRuangan FROM TERM T, JENISMKS JMKS, MAHASISWA M, DOSEN DPN, DOSEN DPI, JADWAL_SIDANG JS, RUANGAN R, MATA_KULIAH_SPESIAL MKS, DOSEN_PENGUJI DDPI, DOSEN_PEMBIMBING DDPN WHERE JS.IDRuangan = R.IDRuangan AND MKS.IDMKS = JS.IDMKS AND MKS.IDMKS = DDPI.IDMKS AND MKS.IDMKS = DDPN.IDMKS AND MKS.NPM = M.NPM AND MKS.IDJenisMKS = JMKS.ID AND DDPI.NIPDosenPenguji = DPI.NIP AND DDPN.NIPDosenPembimbing = DPN.NIP AND MKS.IsSiapSidang = true AND JMKS.NamaMKS = '".$_POST["jenisSidang"]."' AND T.Tahun = $tahun AND T.Semester = $semester ORDER BY JS.Tanggal, JS.Jam_Mulai, JS.Jam_Selesai LIMIT 10;";
		}else if($_POST["searchBy"] === "mahasiswa"){
			$sql = "SELECT JMKS.NamaMKS as Jenis_Sidang, M.Nama as Mahasiswa, DPN.Nama as Dosen_Pembimbing, DPI.Nama as Dosen_Penguji, JS.Tanggal, JS.Jam_Mulai, JS.Jam_Selesai, R.NamaRuangan FROM JENISMKS JMKS, MAHASISWA M, DOSEN DPN, DOSEN DPI, JADWAL_SIDANG JS, RUANGAN R, MATA_KULIAH_SPESIAL MKS, DOSEN_PENGUJI DDPI, DOSEN_PEMBIMBING DDPN WHERE JS.IDRuangan = R.IDRuangan AND MKS.IDMKS = JS.IDMKS AND MKS.IDMKS = DDPI.IDMKS AND MKS.IDMKS = DDPN.IDMKS AND MKS.NPM = M.NPM AND MKS.IDJenisMKS = JMKS.ID AND DDPI.NIPDosenPenguji = DPI.NIP AND DDPN.NIPDosenPembimbing = DPN.NIP AND MKS.IsSiapSidang = true AND M.NPM = '".$_POST["npm"]."' ORDER BY JS.Tanggal, JS.Jam_Mulai, JS.Jam_Selesai LIMIT 10;";
		}

		$result = pg_query($conn, $sql);
		
		if($result !== FALSE){
			$row = pg_fetch_all($result);
			if($row !== FALSE){
				echo json_encode($row);
			}else{
				// echo "Data Tidak Ada";
				echo "[]";
			}
		}else{
			// echo "Data Tidak Ada";
			echo "[]";
		}
	}else{
		echo "Data Belum di transfer";
	}
?>