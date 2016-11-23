<?php
	include "../database-config.php";
	session_start();
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<script type="text/javascript">
		$ ( document ). ready ( function (){

			$("#search-btn").click(function(){

				var url = "http://localhost/sisidangB11/main/search-helper.php";
				$.ajax({
					type : 'POST',
					url : url,
					dataType : 'text',
					data : {
						searchBy: $("#search-by").val(),
						term: $("#search-by-term").val(),
						jenisSidang: $("#search-by-jenis-sidang").val(),
						npm: $("#search-by-npm").val()
					},
					success : function(result){
						console.log(result);
						$("#table-jadwal-sidang").empty();
						$("#table-jadwal-sidang").append("<tr>"+
							"<th>Jenis Sidang</th>"+
							"<th>Mahasiswa</th>"+
							"<th>Dosen Pembimbing</th>"+
							"<th>Dosen Penguji</th>"+
							"<th>Waktu dan Lokasi</th>"+
							"<th>Action</th>"+
							"</tr>");
						var data = JSON.parse(result);
						for(var i = 0 ; i < data.length ; i++){
							// alert(data[i].tanggal);
							$("#table-jadwal-sidang").append("<tr>"+
								"<td>"+data[i].jenis_sidang+"</td>"+
								"<td>"+data[i].mahasiswa+"</td>"+
								"<td>"+data[i].dosen_pembimbing+"</td>"+
								"<td>"+data[i].dosen_penguji+"</td>"+
								"<td>"+data[i].tanggal+" || "+data[i].jam_mulai+" || "+data[i].jam_selesai+" || "+data[i].namaruangan+"</td>"+
								"<td><button class=\"btn btn-default\" >Edit</button></td>"+
								"</tr>");
						}
					},
					error : function(a,error,z){
						alert("Login error "+error);
					}
				});
			});

			$("#search-by").change(function(){
				var searchBy = $(this).val();
				switch(searchBy){
					case "jenisSidang":
						$("#search-by-term").css("display","block");
						$("#search-by-jenis-sidang").css("display","block");
						$("#search-by-npm").css("display","none");
						$("#search-btn").css("display","block");
						break;
					case "mahasiswa":
						$("#search-by-term").css("display","none");
						$("#search-by-jenis-sidang").css("display","none");
						$("#search-by-npm").css("display","block");
						$("#search-btn").css("display","block");
						break;
					default:
						$("#search-by-term").css("display","none");
						$("#search-by-jenis-sidang").css("display","none");
						$("#search-by-npm").css("display","none");
						$("#search-btn").css("display","none");
						break;
				}
			});
		});
	</script>
</head>
<body>
	<div id="search-jadwal-sidang" class="containers">
		<div><span><b>Cari Jadwal Sidang</b></span></div>
		<select class="form-control search-input" id="search-by">
		  <option value="default">Cari berdasarkan</option>
		  <option value="jenisSidang">Jenis Sidang</option>
		  <option value="mahasiswa">Mahasiswa</option>
		</select>
		<?php

	  	$sql = "SELECT * FROM TERM;";
		$result = pg_query($conn, $sql);
		
		if($result !== FALSE){
			$row = pg_fetch_all($result);
			if($row !== FALSE){
				echo " <select class=\"form-control search-input\" id=\"search-by-term\" style=\"display:none\"> ";
				echo "<option value=\"default\">Pilih Term</option>";
				for($i = 0 ; $i < count($row) ; $i++){
					echo "<option value=\"".$row[$i]["tahun"]."/".$row[$i]["semester"]."\">".$row[$i]["tahun"]."/".$row[$i]["semester"]."</option>";
				}
				echo "</select>";
			}else{
				// echo "Data Tidak Ada";
			}
		}else{
			// echo "Data Tidak Ada";
		}

	  	?>

		<?php

	  	$sql = "SELECT namamks FROM JENISMKS;";
		$result = pg_query($conn, $sql);
		
		if($result !== FALSE){
			$row = pg_fetch_all($result);
			if($row !== FALSE){
				echo " <select class=\"form-control search-input\" id=\"search-by-jenis-sidang\" style=\"display:none\"> ";
				echo "<option value=\"default\">Pilih Jenis Sdiang</option>";
				for($i = 0 ; $i < count($row) ; $i++){
					echo "<option value=\"".$row[$i]["namamks"]."\">".$row[$i]["namamks"]."</option>";
				}
				echo "</select>";
			}else{
				// echo "Data Tidak Ada";
			}
		}else{
			// echo "Data Tidak Ada";
		}

	  	?>
	  	<?php

	  	$sql = "SELECT npm FROM MAHASISWA;";
		$result = pg_query($conn, $sql);
		
		if($result !== FALSE){
			$row = pg_fetch_all($result);
			if($row !== FALSE){
				echo " <select class=\"form-control search-input\" id=\"search-by-npm\" style=\"display:none\"> ";
				echo "<option value=\"default\">Pilih NPM Mahasiswa</option>";
				for($i = 0 ; $i < count($row) ; $i++){
					echo "<option value=\"".$row[$i]["npm"]."\">".$row[$i]["npm"]."</option>";
				}
				echo "</select>";
			}else{
				// echo "Data Tidak Ada";
			}
		}else{
			// echo "Data Tidak Ada";
		}

	  	?>
	  	<button id="search-btn" class="btn btn-primary btn-block search-input" style="display:none">Cari Jadwal Sidang</button>
	</div>
	<table class="table table-hover containers" id="table-jadwal-sidang">
		<tr>
			<th>Jenis Sidang</th>
			<th>Mahasiswa</th>
			<th>Dosen Pembimbing</th>
			<th>Dosen Penguji</th>
			<th>Waktu dan Lokasi</th>
			<th>Action</th>
		</tr>

		<?php
			$start = 0;
			if(isset($_SESSION["start"])){
				$start = $_SESSION["start"];
			}
			$sql = "SELECT JMKS.NamaMKS as Jenis_Sidang, M.Nama as Mahasiswa, DPN.Nama as Dosen_Pembimbing, DPI.Nama as Dosen_Penguji, JS.Tanggal, JS.Jam_Mulai, JS.Jam_Selesai, R.NamaRuangan FROM JENISMKS JMKS, MAHASISWA M, DOSEN DPN, DOSEN DPI, JADWAL_SIDANG JS, RUANGAN R, MATA_KULIAH_SPESIAL MKS, DOSEN_PENGUJI DDPI, DOSEN_PEMBIMBING DDPN WHERE JS.IDRuangan = R.IDRuangan AND MKS.IDMKS = JS.IDMKS AND MKS.IDMKS = DDPI.IDMKS AND MKS.IDMKS = DDPN.IDMKS AND MKS.NPM = M.NPM AND MKS.IDJenisMKS = JMKS.ID AND DDPI.NIPDosenPenguji = DPI.NIP AND DDPN.NIPDosenPembimbing = DPN.NIP AND MKS.IsSiapSidang = true ORDER BY JS.Tanggal, JS.Jam_Mulai, JS.Jam_Selesai LIMIT 10;";
			$result = pg_query($conn, $sql);
			
			if($result !== FALSE){
				$row = pg_fetch_all($result);
				if($row !== FALSE){
					for($i = 0 ; $i < count($row) ; $i++){
						echo "<tr>";
						echo "<td>".$row[$i]["jenis_sidang"]."</td>";
						echo "<td>".$row[$i]["mahasiswa"]."</td>";
						echo "<td>".$row[$i]["dosen_pembimbing"]."</td>";
						echo "<td>".$row[$i]["dosen_penguji"]."</td>";
						echo "<td>".$row[$i]["tanggal"]." || ".$row[$i]["jam_mulai"]." || ".$row[$i]["jam_selesai"]." || ".$row[$i]["namaruangan"]."</td>";
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