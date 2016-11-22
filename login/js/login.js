$ ( document ). ready ( function (){

	// cekUser();

	//Untuk mengecek apakah user sudah login atau belum
	// function cekUser(){
	// 	var url = "http://localhost/PPWC_14/Login/login.php";
	// 	$.ajax({
	// 		type : 'GET',
	// 		url : url,
	// 		dataType : 'text',
	// 		success : function(result){
	// 			if(result === "user sudah login"){
	// 				window.open("../Main/main.html","_self");
	// 			}
	// 		},
	// 		error : function(a,error,z){
	// 			alert("Gagal terhubung dengan server, error: "+error);
	// 		}
	// 	});
	// }

	$('#loginButton').click(function(){
		var $username = $('#username');
		var $password = $('#password');
		var $role = $('#role');
		$username.removeClass("invalidInput");
		$password.removeClass("invalidInput");
		$role.removeClass("invalidInput");
		if(isValid($username.val(), $password.val(), $role.val())){
			sendDataToServer($username.val(), $password.val(), $role.val());
		}else{
			if($password.val().length===0){
				$password.addClass("invalidInput");
			}
			if($username.val().length===0){
				$username.addClass("invalidInput");
			}
			if($role.val() === "default"){
				$role.addClass("invalidInput");
			}
		}
	});

	//mengecek apakah input dr user sudah valid atau belum
	function isValid(username, passowrd, role){
		return username.length !== 0 && passowrd.length !== 0 && role !== "default";
	}

	//mengirim semua input user untuk dicek di server
	function sendDataToServer(username, password, role){
		var url = "http://localhost/sisidangB11/login/login.php";
		$.ajax({
			type : 'POST',
			url : url,
			dataType : 'text',
			data : {
				username: username,
				password: password,
				role: role
			},
			success : function(result){
				var data = JSON.parse(result);
				switch(data.result){
					case "match":
						var user = data.message;
						alert(user.username);
						break;
					case "dismatch":
						alert(data.message);
						break;
					case "admin":
						alert("Admin has login");
						break;
					default:
						"user tidak ditemukan";
						break;
				}
			},
			error : function(a,error,z){
				alert("Login error "+error);
			}
		});
	}

	//mengecek result dari login
	function cekResult(result){
		if(result === "password tidak sesuai" || result === "username belum terdaftar" || result === "error trensfer data"){
			alert(result);
		}else{
			sessionStorage.setItem("user",result);
			//TODO buka halaman selanjutnya
			window.open("../Main/main.html","_self");
		}
	}
} );