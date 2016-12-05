<!DOCTYPE html>
<html>
<head>
	<title></title>
	<script type="text/javascript">
		$ ( document ). ready ( function (){

			var countPref;
			var start;
			var nextNav;
			var prefNav;
			var data;
			var sorted;

			initVariable();
			getDataFromServer(true);
			

			function initVariable() {
				countPref = new Array(0);
				start = 0;
				nextNav = false;
				prefNav = false;
				sorted = "waktu"
				data = {start: start, sorted: sorted};
			}

			function loadAJAX(data, onSuccess){
				var url = "http://localhost/sisidangB11/main/admin-data.php";
				$.ajax({
					type : 'POST',
					url : url,
					dataType : 'text',
					data : data,
					success : onSuccess,
					error : function(a,error,z){
						alert("Data transmitte error "+error);
					}
				});
			}

			function onDataSuccess(results, isNext){

				console.log(results);

				var data = JSON.parse(results);

				if(data.result === "sukses"){
					var rows = data.data;
					if(isNext){
						countPref.push(data.count);

						if(data.count > 10){
							countPref.pop();
							countPref.push(10);
							nextNav = true;
						}else{
							nextNav = false;
						}
					}else{
						nextNav = true;
					}

					$("#total-row p span").html("Count: "+countPref[countPref.length-1]);

					prefNav = start !== 0;

					nextNav = prefNav = rows.length !== 0;

					showOrHideNavButton();

					$("#table-jadwal-sidang").empty();
					$("#table-jadwal-sidang").append("<thead>");
					$("#table-jadwal-sidang").append("<tr>"
							+"<th>Mahasiswa</th>"
							+"<th>Jenis Sidang</th>"
							+"<th>Judul</th>"
							+"<th>Waktu dan Lokasi</th>"
							+"<th>Dosen Pembimbing</th>"
							+"<th>Dosen Penguji</th>"
							+"<th>Action</th>"
							+"</tr>");
					$("#table-jadwal-sidang").append("</thead>");
					$("#table-jadwal-sidang").append("</tbody>");
					$("#table-jadwal-sidang").append("<tbody>");

					for(var i = 0 ; i < rows.length && i < 10 ; i++){
						var mahasiswa = rows[i].mahasiswa;
						var jenisSidang = rows[i].jenis_sidang;
						var judul = rows[i].judul;
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
							+"<td><button class=\"btn btn-success edit-btn\">Edit</button></td>"
							+"</tr>");
					}

					$("#table-jadwal-sidang").append("</tbody>");


				}else{
					nextNav = prefNav = false;

					showOrHideNavButton();
				}
			}

			function showOrHideNavButton(){
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
			}

			function getDataFromServer(isNext){
				loadAJAX(data, function(result){onDataSuccess(result, isNext)});
			}

			$(document).on('click','.edit-btn',function(){

				alert("edit");

			});

			$("#nav-next-btn").click(function(){
				start += countPref[countPref.length-1];
				data = {start: start, sorted: sorted};
				getDataFromServer(true);
			});
			
			$("#nav-pref-btn").click(function(){
				start -= countPref[countPref.length-2];
				data = {start: start, sorted: sorted};
				countPref.pop();
				getDataFromServer(false);
			});

			$("#tambah-jadwal-sidang-btn").click(function(){
				alert("Tambah Jadwal Sidang");
			});

			$("#sorted-by").change(function(){
				initVariable();
				sorted = $(this).val();
				data = {start: start, sorted: sorted};
				getDataFromServer(true);
			});

		});
	</script>
	<style type="text/css">
		#containers-nav-button{
			max-width: 1000px;
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
	  	#table-jadwal-sidang{
	  		margin-top: 15px;
	  	}
	  	.containers{
	  		max-width: 1000px;
	  		margin: auto;
	  	}
	  	.sorted-input, h4{
	  		margin-bottom: 10px;
	  	}
	</style>
</head>
<body>
	<h1>Jadwal Sidang Mahasiswa</h1>
	<h4 class="containers">Sorted By:</h4>
	<select class="form-control sorted-input containers" id="sorted-by">
	  <option value="waktu">Waktu</option>
	  <option value="jenissidang">Jenis Sidang</option>
	  <option value="mahasiswa">Mahasiswa</option>
	</select>
	<button class="btn btn-success btn-block containers" id="tambah-jadwal-sidang-btn">Tambah</button>
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
