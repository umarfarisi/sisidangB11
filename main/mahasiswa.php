<!DOCTYPE html>
<html>
<head>
	<title></title>
	<script type="text/javascript">
		$ ( document ). ready ( function (){

			hideMenuWhitchNotAllowedToAccess();

			function hideMenuWhitchNotAllowedToAccess(){
				$("#buat-jadwal-sidang-mks").css("display","none");
				$("#buat-jadwal-non-sidang-dosen").css("display","none");
				$("#lihat-dftar-mks").css("display","none");
			}
		});
	</script>
</head>
<body>
	<div class="containers">
		<div><span><b>Data Mahasiswa</b></span></div>
	</div>
	<table class="table table-hover containers" id="table-data-mahasiswa">
		<tr>
			<th>NPM</th>
			<th>Nama</th>
			<th>Username</th>
			<th>Email</th>
			<th>Email Alternatif</th>
			<th>Telepon</th>
			<th>Nomor Telepon</th>
		</tr>

		<?php
			if(isset($_SESSION["username"])){

				$sql = "SELECT * FROM MAHASISWA WHERE username = '".$_SESSION["username"]."';";
				$result = pg_query($conn, $sql);
				
				if($result !== FALSE){
					$row = pg_fetch_all($result);
					echo "";
					if($row !== FALSE){
						for($i = 0 ; $i < count($row) ; $i++){
							echo "<tr>";
							echo "<td>".$row[$i]["npm"]."</td>";
							echo "<td>".$row[$i]["nama"]."</td>";
							echo "<td>".$row[$i]["username"]."</td>";
							echo "<td>".$row[$i]["email"]."</td>";
							echo "<td>".$row[$i]["email_alt"]."</td>";
							echo "<td>".$row[$i]["telepon"]."</td>";
							echo "<td>".$row[$i]["notelp"]."</td>";
							echo "</tr>";
						}
					}else{
						// echo "Data Tidak Ada";
					}
				}else{
					// echo "Data Tidak Ada";
				}
				
			}else{
				// echo "TIDAAAA";
			}

		?>

	</table>
</body>
</html>