    <?php    require "database.php";
        $conn = connectDB();
        pg_query($conn,"SET SEARCH_PATH TO SISIDANG");
        session_start(); 
        ?>
<!DOCTYPE html>

<html>
<head>
	<title>Daftar MK Spesial (Admin)</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<style type="text/css">
	  	.containers{
	  		max-width: 1200px;
	  		margin: 10px auto;
	  	}
	</style>
</head>
<body>


	<div class="container">
	<h1>Daftar MKS Spesial (Admin)</h1>
	<a href="TambahMKS.php"><input type=button value="Tambah MKS"></a>

	<table class="table table-hover containers" id="table-mk-spesial">
		<tr>
			<th>ID</th>
			<th>Judul</th>
			<th>Mahasiswa</th>
			<th>Term</th>
			<th>Jenis MKS</th>
			<th>Status</th>
		</tr>

		<?php

         $result = pg_query($conn,"SELECT mks.idmks, mks.judul, m.nama, mks.tahun, mks.semester, jm.namamks, mks.issiapsidang, mks.pengumpulanhardcopy, mks.ijinmajusidang 
         	 FROM mata_kuliah_spesial mks, mahasiswa m, jenismks jm 
         	 WHERE m.npm=mks.npm AND mks.idjenismks=jm.id
         	 ORDER BY m.nama;");


        echo "<tbody>";
                                            
        if(pg_num_rows($result) > 0){
        	while($row = pg_fetch_assoc($result)){
                

                $statusizinmaju = "";
                $statushardcopy = "";
                $statussiapsidang = "";

                if ($row["issiapsidang"]=="t"){
                	$statussiapsidang = "Siap Sidang";
                }

                if ($row["pengumpulanhardcopy"]=="t"){
                	$statushardcopy = "Kumpul Hard Copy";
                }

                if ($row["ijinmajusidang"]=="t"){
                	$statusizinmaju = "Izin Maju Sidang";
                }

                echo "

                    <tr class='odd gradeX'>".
                    "<td>". $row["idmks"]. "</td>" .
                    "<td>". $row["judul"]. "</td>" .
                    "<td>". $row["nama"]. "</td>" .
                    "<td>". $row["tahun"]. "/" . $row["semester"] ."</td>" .
                    "<td>". $row["namamks"]. "</td>" .
                    "<td> <ul> <li>". $statussiapsidang. "</li> <li>" . $statushardcopy. "</li> <li> " .$statusizinmaju." </li> </ul> </td>" .
                    "</tr>";
            }
        }
        echo "</tbody>";
		?>

	</table>
</div>
</body>
</html>