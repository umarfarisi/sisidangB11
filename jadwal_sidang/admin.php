<!DOCTYPE html>
<html>
<head>
	<title>Jadwal Sidang</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script type="text/javascript">
		$ ( document ). ready ( function (){

			$("#tambah-jadwal-sidang-btn").click(function(){
				alert("tambah jadwal sidang");
			});

		});
	</script>
	<style type="text/css">
	  	.containers{
	  		max-width: 1200px;
	  		margin: 10px auto;
	  	}
	</style>
</head>
<body>
	<div><button class="btn btn-success btn-block containers" id="tambah-jadwal-sidang-btn">Tambah Jadwal Sidang</button></div>
	<table class="table table-hover containers" id="table-jadwal-sidang">
		<tr>
			<th>Mahasiswa</th>
			<th>Jenis Sidang</th>
			<th>Waktu dan Lokasi</th>
			<th>Dosen Pembimbing</th>
			<th>Dosen Penguji</th>
			<th>Action</th>
		</tr>

		<?php
			$start = 0;
			if(isset($_SESSION["start"])){
				$start = $_SESSION["start"];
			}
			$sql = "SELECT JMKS.NamaMKS as Jenis_Sidang, M.Nama as Mahasiswa, DPN.Nama as Dosen_Pembimbing, DPI.Nama as Dosen_Penguji, JS.Tanggal, JS.Jam_Mulai, JS.Jam_Selesai, R.NamaRuangan FROM JENISMKS JMKS, MAHASISWA M, DOSEN DPN, DOSEN DPI, JADWAL_SIDANG JS, RUANGAN R, MATA_KULIAH_SPESIAL MKS, DOSEN_PENGUJI DDPI, DOSEN_PEMBIMBING DDPN WHERE JS.IDRuangan = R.IDRuangan AND MKS.IDMKS = JS.IDMKS AND MKS.IDMKS = DDPI.IDMKS AND MKS.IDMKS = DDPN.IDMKS AND MKS.NPM = M.NPM AND MKS.IDJenisMKS = JMKS.ID AND DDPI.NIPDosenPenguji = DPI.NIP AND DDPN.NIPDosenPembimbing = DPN.NIP AND MKS.IsSiapSidang = true ORDER BY M.Nama, JMKS.NamaMKS , JS.Tanggal, JS.Jam_Mulai, JS.Jam_Selesai LIMIT 10;";
			$result = pg_query($conn, $sql);
			
			if($result !== FALSE){
				$row = pg_fetch_all($result);
				if($row !== FALSE){
					for($i = 0 ; $i < count($row) ; $i++){
						echo "<tr>";
						echo "<td>".$row[$i]["mahasiswa"]."</td>";
						echo "<td>".$row[$i]["jenis_sidang"]."</td>";
						echo "<td>".$row[$i]["tanggal"]." || ".$row[$i]["jam_mulai"]." || ".$row[$i]["jam_selesai"]." || ".$row[$i]["namaruangan"]."</td>";
						echo "<td>".$row[$i]["dosen_pembimbing"]."</td>";
						echo "<td>".$row[$i]["dosen_penguji"]."</td>";
						echo "<td><button class=\"btn btn-default\" >Edit</button></td>";
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