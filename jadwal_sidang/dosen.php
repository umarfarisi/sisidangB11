<!DOCTYPE html>
<html>
<head>
	<title>Jadwal Sidang</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script type="text/javascript">
		$ ( document ). ready ( function (){

		});
	</script>
	<style type="text/css">
	  	.containers{
	  		max-width: 1600px;
	  		margin: 10px auto;
	  	}
	</style>
</head>
<div><h1>Jadwal Sidang Mahasiswa</h1></div>
<body>
	<table class="table table-hover containers" id="table-jadwal-sidang">
		<tr>
			<th>Mahasiswa</th>
			<th>Jenis Sidang</th>
			<th>Judul</th>
			<th>Waktu dan Lokasi</th>
			<th>Pembimbing Lain</th>
			<th>Status</th>
		</tr>

		<?php

			$start = 0;
			if(isset($_SESSION["start"])){
				$start = $_SESSION["start"];
			}
			$sql = "SELECT MKS.IDMKS, M.Nama, JMKS.NamaMKS, MKS.Judul, JS.Tanggal, JS.JAM_MULAI, JS.JAM_SELESAI, R.NamaRuangan, MKS.IsSiapSidang, MKS.IjinMajuSidang, MKS.PengumpulanHardCopy FROM MAHASISWA M, JADWAL_SIDANG JS, MATA_KULIAH_SPESIAL MKS, JENISMKS JMKS, RUANGAN R, DOSEN D, DOSEN_PEMBIMBING DP, DOSEN_PENGUJI DPI WHERE JS.IDMKS = MKS.IDMKS AND M.NPM = MKS.NPM AND MKS.IDJENISMKS = JMKS.ID AND ((DP.NIPDOSENPEMBIMBING = D.NIP AND DP.IDMKS = MKS.IDMKS) OR (DPI.NIPDOSENPENGUJI = D.NIP AND DPI.IDMKS = MKS.IDMKS))  AND D.USERNAME = '".$_SESSION["username"]."' ORDER BY M.Nama, JMKS.NamaMKS, JS.Tanggal, JS.JAM_MULAI, JS.JAM_SELESAI;";
			$result = pg_query($conn, $sql);

			
			if($result !== FALSE){
				$row = pg_fetch_all($result);
				
				if($row !== FALSE){
					for($i = 0 ; $i < count($row) ; $i++){
						echo "<tr>";
						echo "<td>".$row[$i]["nama"]."</td>";
						echo "<td>".$row[$i]["namamks"]."</td>";
						echo "<td>".$row[$i]["judul"]."</td>";
						echo "<td>".$row[$i]["tanggal"]."<br>".$row[$i]["jam_mulai"]."-".$row[$i]["jam_selesai"]."<br>".$row[$i]["namaruangan"]."</td>";
						echo "<td>";

						$sql_pembimbing_lain = "SELECT DISTINCT D.Nama FROM DOSEN D, DOSEN_PEMBIMBING DP, MATA_KULIAH_SPESIAL MKS, MAHASISWA M WHERE MKS.NPM = M.NPM AND DP.IDMKS = MKS.IDMKS AND D.NIP = DP.NIPDOSENPEMBIMBING AND M.USERNAME = '".$_SESSION["username"]."'AND MKS.IDMKS = '".$row[$i]["idmks"]."';";
						$result_pembimbing_lain = pg_query($conn, $sql_pembimbing_lain);
						if($result_pembimbing_lain !== FALSE){
							$row_pembimbing_lain = pg_fetch_all($result_pembimbing_lain);
							if($row_pembimbing_lain !== FALSE){
								echo "<ul>";
								for($j = 0 ; $j < count($row_pembimbing_lain) ; $j++){
									echo "<li>".$row_pembimbing_lain[$j]["nama"]."</li>";
								}
								echo "</ul>";
							}
						}


						echo "</td>";
						echo "<td><ul>";
						if($row[$i]["issiapsidang"] === "t"){
							echo "<li>Siap Sidang</li>";
						}
						if($row[$i]["ijinmajusidang"] === "t"){
							echo "<li>Ijin Maju Sidang</li>";
						}
						if($row[$i]["pengumpulanhardcopy"] === "t"){
							echo "<li>Pengumlupan Hard Copy</li>";
						}
						echo "</ul></td>";
						echo "</tr>";
					}
				}else{
					// echo "Data Tidak Ada";
				}
			}else{
				// echo "Data Tidak Ada";
			}

		?>

	</table>
</body>
</html>
