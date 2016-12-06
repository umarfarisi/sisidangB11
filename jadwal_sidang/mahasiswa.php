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
			$sql = "SELECT MKS.IsSiapSidang, MKS.IDMKS, MKS.Judul, JS.tanggal, JS.Jam_Mulai, JS.Jam_Selesai, R.NamaRuangan, MKS.IsSiapSidang AS NamaDosenPembimbing FROM MATA_KULIAH_SPESIAL MKS, JADWAL_SIDANG JS, RUANGAN R, MAHASISWA M WHERE MKS.IdMKS = JS.IdMKS AND JS.IdRuangan = R.IdRuangan AND M.NPM = MKS.NPM AND M.username = '".$_SESSION["username"]."';";

			echo "<script>console.log(\"$sql\")</script>";

			$result = pg_query($conn, $sql);
			
			if($result !== FALSE){
				$row = pg_fetch_all($result);
				if($row !== FALSE){
					for($i = 0 ; $i < count($row) ; $i++){
						if($row[$i]["issiapsidang"] === "t"){
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
							echo "<th>Tempat Sidang</th><td>".$row[$i]["namaruangan"]."</td>";
							echo "</tr>";
							// echo "<tr>";
							// echo "<th>Dosen Pembimbing</th><td>".$row[$i]["namadosenpembimbing"]."<span><b> Status: </b>Izin maju sidang, Kumpul hard copy</span></td>";
							// echo "</tr>";
							echo "<tr>";
							echo "<th>Dosen Pembimbing</th><td>";

							$sql_dosen_pembimbing = "SELECT D.Nama FROM DOSEN D, DOSEN_PEMBIMBING DP WHERE D.NIP = DP.NIPDosenPembimbing AND DP.IDMKS = '".$row[$i]['idmks']."' ;";

							$result_dosen_pembimbing = pg_query($conn, $sql_dosen_pembimbing);
							if( $result_dosen_pembimbing !== FALSE){
								$row_dosen_pembimbing = pg_fetch_all($result_dosen_pembimbing);
								if($row_dosen_pembimbing !== FALSE){
									for($j = 0 ; $j < count($row_dosen_pembimbing) ; $j++){
										echo $row_dosen_pembimbing[$j]["nama"];
										if($j !== count($row_dosen_pembimbing)-1){
											echo ", ";
										}
									}
								}
							}
							echo "</td>";
							echo "</tr>";
							echo "<tr>";
							echo "<th>Dosen Penguji</th><td>";

							$sql_dosen_penguji = "SELECT D.Nama FROM DOSEN D, DOSEN_PENGUJI DP WHERE D.NIP = DP.NIPDosenPenguji AND DP.IDMKS = '".$row[$i]['idmks']."' ;";

							$result_dosen_penguji = pg_query($conn, $sql_dosen_penguji);
							if( $result_dosen_penguji !== FALSE){
								$row_dosen_penguji = pg_fetch_all($result_dosen_penguji);
								if($row_dosen_penguji !== FALSE){
									for($j = 0 ; $j < count($row_dosen_penguji) ; $j++){
										echo $row_dosen_penguji[$j]["nama"];
										if($j !== count($row_dosen_penguji)-1){
											echo ", ";
										}
									}
								}
							}
							echo "</td>";
							echo "</tr>";
							echo "</table>";
						}else{
							echo "<h2>Maaf, Jadwal Sidang Blom Diizinkan<h2>";
						}
					}
				}else{
					// echo "Data Tidak Ada";
					echo "<h2>Tidak Ada Data untuk ditampilkan</h2>";
				}
			}else{
				// echo "Data Tidak Ada";
				echo "<h2>Tidak Ada Data untuk ditampilkan</h2>";
			}
		}else{
			echo "<h2>Tidak Ada Data untuk ditampilkan</h2>";
		}

	?>


</div>
</body>
</html>