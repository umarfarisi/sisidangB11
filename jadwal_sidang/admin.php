<!DOCTYPE html>
<html>
<head>
	<title></title>
	<script type="text/javascript">
		$ ( document ). ready ( function (){

			var countPref = new Array(0);
			var start = 0;
			var nextNav = false;
			var prefNav = false;

			navigationSetting(start, true);

			$("#nav-next-btn").click(function(){
				start += countPref[countPref.length-1];
				navigationSetting(start, true);
			});
			$("#nav-pref-btn").click(function(){
				start -= countPref[countPref.length-2];
				countPref.pop();
				navigationSetting(start, false);
			});

			function navigationSetting(start, isNext){
				var url = "http://localhost/sisidangB11/jadwal_sidang/admin-data.php";
				$.ajax({
					type : 'POST',
					url : url,
					dataType : 'text',
					data : {
						start: start,
						username: sessionStorage.getItem("user")
					},
					success : function(results){
						var data = JSON.parse(results);

						if(data.result === "sukses"){
							var rows = data.data;
							if(isNext){
								countPref.push(data.count);

								if(data.count > 9){
									countPref.pop();
									countPref.push(9);
									nextNav = true;
								}else{
									nextNav = false;
								}
							}else{
								nextNav = true;
							}

							$("#total-row p span").html(" countPref: "+countPref[countPref.length-1]+" Start: "+start+" countPref.Length: "+countPref.length);

							prefNav = start !== 0;

							if(nextNav){
								$("#nav-next-btn").css("display","inline-block");
							}else{
								$("#nav-next-btn").css("display","none");
							}
							if(prefNav){
								$("#nav-pref-btn").css("display","inline-block");
							}else{
								$("#nav-pref-btn").css("display","none");
							}

							$("#table-jadwal-sidang").empty();
							$("#table-jadwal-sidang").append("<tr>"
									+"<th>Mahasiswa</th>"
									+"<th>Jenis Sidang</th>"
									+"<th>Judul</th>"
									+"<th>Waktu dan Lokasi</th>"
									+"<th>Dosen Pembimbing</th>"
									+"<th>Dosen Penguji</th>"
									+"<th>Action</th>"
									+"</tr>");


							for(var i = 0 ; i < rows.length && i < 9 ; i++){
								var judul = rows[i].judul;
								var mahasiswa = rows[i].mahasiswa;
								var jenisSidang = rows[i].jenis_sidang;
								var waktuDanLokasi = rows[i].tanggal+" || "+rows[i].jam_mulai+"-"+rows[i].jam_selesai+" || "+rows[i].namaruangan;
								var pembimbing = "";
								for(var j = 0 ; j < rows[i].pembimbing.length ; j++){
									pembimbing += rows[i].pembimbing[j].nama;
									if(j !== rows[i].pembimbing.length){
										pembimbing += ", ";
									}
								}
								var penguji = "";
								for(var j = 0 ; j < rows[i].penguji.length ; j++){
									penguji += rows[i].penguji[j].nama;
									if(j !== rows[i].penguji.length){
										penguji += ", ";
									}
								}
								$("#table-jadwal-sidang").append(""
									+"<tr>"
									+"<td>"+mahasiswa+"</td>"
									+"<td>"+jenisSidang+"</td>"
									+"<td>"+judul+"</td>"
									+"<td>"+waktuDanLokasi+"</td>"
									+"<td>"+pembimbing+"</td>"
									+"<td>"+penguji+"</td>"
									+"<td><button>Edit</button></td>"
									+"</tr>");
							}


						}else{

						}
					},
					error : function(a,error,z){
						alert("Login error "+error);
					}
				});
			}

			// $("#search-btn").click(function(){

			// 	var url = "http://localhost/sisidangB11/main/search-helper.php";
			// 	$.ajax({
			// 		type : 'POST',
			// 		url : url,
			// 		dataType : 'text',
			// 		data : {
			// 			searchBy: $("#search-by").val(),
			// 			term: $("#search-by-term").val(),
			// 			jenisSidang: $("#search-by-jenis-sidang").val(),
			// 			npm: $("#search-by-npm").val()
			// 		},
			// 		success : function(result){
			// 			$("#table-jadwal-sidang").empty();
			// 			$("#table-jadwal-sidang").append("<tr>"+
			// 				"<th>Jenis Sidang</th>"+
			// 				"<th>Mahasiswa</th>"+
			// 				"<th>Dosen Pembimbing</th>"+
			// 				"<th>Dosen Penguji</th>"+
			// 				"<th>Waktu dan Lokasi</th>"+
			// 				"<th>Action</th>"+
			// 				"</tr>");
			// 			var data = JSON.parse(result);
			// 			for(var i = 0 ; i < data.length ; i++){
			// 				$("#table-jadwal-sidang").append("<tr>"+
			// 					"<td>"+data[i].jenis_sidang+"</td>"+
			// 					"<td>"+data[i].mahasiswa+"</td>"+
			// 					"<td>"+data[i].dosen_pembimbing+"</td>"+
			// 					"<td>"+data[i].dosen_penguji+"</td>"+
			// 					"<td>"+data[i].tanggal+" || "+data[i].jam_mulai+" || "+data[i].jam_selesai+" || "+data[i].namaruangan+"</td>"+
			// 					"<td><button class=\"btn btn-default\" >Edit</button></td>"+
			// 					"</tr>");
			// 			}
			// 		},
			// 		error : function(a,error,z){
			// 			alert("Login error "+error);
			// 		}
			// 	});
			// });

			// $("#search-by").change(function(){
			// 	var searchBy = $(this).val();
			// 	switch(searchBy){
			// 		case "jenisSidang":
			// 			$("#search-by-term").css("display","block");
			// 			$("#search-by-jenis-sidang").css("display","block");
			// 			$("#search-by-npm").css("display","none");
			// 			$("#search-btn").css("display","block");
			// 			break;
			// 		case "mahasiswa":
			// 			$("#search-by-term").css("display","none");
			// 			$("#search-by-jenis-sidang").css("display","none");
			// 			$("#search-by-npm").css("display","block");
			// 			$("#search-btn").css("display","block");
			// 			break;
			// 		default:
			// 			$("#search-by-term").css("display","none");
			// 			$("#search-by-jenis-sidang").css("display","none");
			// 			$("#search-by-npm").css("display","none");
			// 			$("#search-btn").css("display","none");
			// 			break;
			// 	}
			// });

			$("#tambah-jadwal-sidang-btn").click(function(){
				alert("tambah jadwal sidang");
			});
		});
	</script>
	<style type="text/css">
		#containers-nav-button{
			max-width: 1600px;
	  		margin: 10px auto;
	  		padding: 0px
		}
	  	#total-row{
	  		background-color: gray;
	  		color: white;
	  	}
	  	#total-row p{
	  		padding-top: 10px;
	  		padding-bottom: 10px;
	  		padding-left: 10px;
	  		font-size: 20px;
	  	}
	  	.nav-button{
	  		width: 50%
	  		margin-right:5px;
	  		margin-left:5px;
	  	}
	</style>
</head>
<body>
<!-- 	<div id="search-jadwal-sidang" class="containers">
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
	</div> -->
	<div><button class="btn btn-success btn-block containers" id="tambah-jadwal-sidang-btn">Tambah Jadwal Sidang</button></div>
	<table class="table table-hover containers" id="table-jadwal-sidang">

	</table>
	<div id="total-row" class="containers">
		<p><span></span></p>
	</div>
	<div id="containers-nav-button" >
		<button id="nav-pref-btn" class="btn btn-primary nav-button">Sebelumnya</button>
		<button id="nav-next-btn" class="btn btn-primary nav-button">Selanjutnya</button>
	</div>
</body>
</html>
