<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<div><h1>Jadwal Sidang Mahasiswa</h1></div>
<div id="body">
	<?php
		if(isset($_SESSION["username"])){
			$sql = "SELECT MKS.Judul, JS.tanggal, JS.Jam_Mulai, JS.Jam_Selesai, R.NamaRuangan, MKS.IsSiapSidang, D.Nama AS NamaDosenPembimbing FROM MATA_KULIAH_SPESIAL MKS, JADWAL_SIDANG JS, RUANGAN R, MAHASISWA M, DOSEN_PEMBIMBING DPN, DOSEN D WHERE MKS.IdMKS = JS.IdMKS AND JS.IdRuangan = R.IdRuangan AND M.NPM = MKS.NPM AND DPN.IdMKS = MKS.IdMKS AND DPN.NIPDosenPembimbing = D.NIP AND M.username = '".$_SESSION["username"]."';";

			$result = pg_query($conn, $sql);

			$sql_dosen_penguji = "SELECT D.Nama FROM DOSEN D, DOSEN_PENGUJI DP, MATA_KULIAH_SPESIAL MKS, MAHASISWA M WHERE D.NIP = DP.NIPDosenPenguji AND DP.IDMKS = MKS.IDMKS AND MKS.NPM = M.NPM AND M.username = '".$_SESSION["username"]."';";

			$result_dosen_penguji = pg_query($conn, $sql_dosen_penguji);
			
			if($result !== FALSE && $result_dosen_penguji !== FALSE){
				$row = pg_fetch_all($result);
				$row_dosen_penguji = pg_fetch_all($result_dosen_penguji);
				if($row !== FALSE && $row_dosen_penguji !== FALSE){
					for($i = 0 ; $i < count($row) ; $i++){
						if($row[$i]["issiapsidang"]){
							echo "<table class=\"table table-hover containers\" >";
							echo "<tr>";
							echo "<th>Judul Tugas Akhir</th><td>".$row[$i]["judul"]."</td>";
							echo "</tr>";
							echo "<tr>";
							echo "<th>Jadwal Sidang</th><td>".$row[$i]["tanggal"]."</td>";
							echo "</tr>";
							echo "<tr>";
							echo "<th>Waktu Sidang</th><td>".$row[$i]["jam_mulai"]."</td>";
							echo "</tr>";
							echo "<tr>";
							echo "<th>Dosen Pembimbing</th><td>".$row[$i]["namadosenpembimbing"]."<span><b>Status: </b>Izin maju sidang, Kumpul hard copy</span></td>";
							echo "</tr>";
							echo "<tr>";
							echo "<th>Dosen Penguji</th><td>";
							for($j = 0 ; $j < count($row_dosen_penguji) ; $j++){
								echo $row_dosen_penguji[$j]["nama"];
								if($j !== count($row_dosen_penguji)-1){
									echo ", ";
								}
							}
							echo "</td>";
							echo "</tr>";
							echo "</table>";
						}else{
							echo "Maaf, Jadwal Sidang Blom Diijinkan";
						}
					}
				}else{
					// echo "Data Tidak Ada";
					echo "Tidak Ada Data untuk ditampilkan";
				}
			}else{
				// echo "Data Tidak Ada";
				echo "Tidak Ada Data untuk ditampilkan";
			}
		}else{
			echo "Tidak Ada Data untuk ditampilkan";
		}

	?>


</div>
</body>
</html>