<!DOCTYPE html>
<html>
<head>
	<title></title>
	<script type="text/javascript">
		$ ( document ). ready ( function (){

			var cDate;
			var month;
			var year;
			var day;

			initialVariable();
			hideMenuWhitchNotAllowedToAccess();
			setCalendar();
			markCalendar();

			function initialVariable(){
				cDate = new Date();
				month = cDate.getMonth();
				year = cDate.getFullYear();
				day = cDate.getDate();
			}

			function hideMenuWhitchNotAllowedToAccess(){
				$("#buat-jadwal-sidang-mks").css("display","none");
			}

			function setCalendar(){
				$('#head-calendar').html(getMonth(month)+" "+year);

				var numberOfDaysinMonth = daysInMonth(cDate.getMonth(), year);
				var $calenderBody = $('#calender tbody');

				var entry = "";
				for(var day = 1 ; day <= numberOfDaysinMonth ; day++){
					if(day % 7 === 1){
						entry += "<tr>";
					}
					entry += "<td id=\"day-"+day+"\">"+day+"</td>";
					if(day === numberOfDaysinMonth || day % 7 === 0){
						entry += "</tr>";
					}
				}

				$calenderBody.append(entry);
			}

			function markCalendar(){
				$("#day-"+day).css("background-color","blue");
				$("#day-"+day).css("color","white");
				loadAJAX({month: month+1, year: year}, onSuccessGetDataCalendar);
			}

			function onSuccessGetDataCalendar(result){
				console.log(result);
				var json = JSON.parse(result);
				if(json.result === "sukses"){
					var data = json.data;
					for(var index = 0 ; index < data.length ; index++){
						if(data[index].day == day){
							$("#day-"+data[index].day).css("background-color","#009688");
						}else{
							$("#day-"+data[index].day).css("background-color","red");
						}
						
						$("#day-"+data[index].day).css("color","white");
					}
					
				}
			}

			function getMonth(index){
				switch(index){
					case 0:
						return "Januari";
					case 1:
						return "Februari";
					case 2:
						return "Maret";
					case 3:
						return "April";
					case 4:
						return "Mai";
					case 5:
						return "Juni";
					case 6:
						return "Juli";
					case 7:
						return "Agustus";
					case 8:
						return "September";
					case 9:
						return "Oktober";
					case 10:
						return "November";
					case 11:
						return "Desember";

				}
			}

			function daysInMonth(month,year) {
			    return new Date(year, month, 0).getDate();
			}

			function loadAJAX(dataCurrentCalendat, onSuccess){
				var url = "http://localhost/sisidangB11/main/dosen-data.php";
				$.ajax({
					type : 'POST',
					url : url,
					dataType : 'text',
					data : dataCurrentCalendat,
					success : onSuccess,
					error : function(a,error,z){
						alert("Data transmitte error "+error);
					}
				});
			}


		});
	</script>
	<style type="text/css">
	  	#logout-btn{
	  		margin-top: 6px;
	  		float: right;
	  	}
	  	.containers{
	  		max-width: 600px;
	  		margin: auto;
	  	}
      .search-input{
        margin-top: 5px;
        margin-bottom: 5px;
      }
      h1{
        text-align: center;
      }
      h2{
        text-align: center;
        margin-top: 20px;
        color: red;
      }
      h3{
        max-width: 600px;
        margin: auto;
      }
      th, td{
      	text-align: center;
      }
      .info{
      	margin-top: 10px;
      	text-align: center;
      	height: 30px;
      	width: 150px;
      	color: white;
      	padding-top: 10px;
      	font-size: 10px;
      	text-align: center;
      }
	  </style>
</head>
<body>

<h1>Jadwal Sidang</h1>
<h3 id="head-calendar">November 2016</h3>

<table id="calender" class="table table-hover containers">
	<tbody>
		
	</tbody>
</table>

<div class="containers">
	<div style="background-color:red" class="info">Jadwal sidang</div>
	<div style="background-color:blue" class="info">Hari ini</div>
	<div style="background-color:#009688" class="info">Jadwal sidang pada hari ini</div>
</div>

</body>
</html>

