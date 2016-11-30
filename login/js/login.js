$ ( document ). ready ( function (){

	cekUser();

	//Untuk mengecek apakah user sudah login atau belum
	function cekUser(){
		if(sessionStorage.getItem("user") !== null){
			window.open("../Main","_self");
		}
	}

	$('#loginButton').click(function(){
		var $username = $('#username');
		var $password = $('#password');
		$username.removeClass("invalidInput");
		$password.removeClass("invalidInput");
		if(isValid($username.val(), $password.val())){
			var username = $username.val();
			var password = $password.val();
			loadAJAX({username, password},onSuccessLogin);
		}else{
			if($password.val().length===0){
				$password.addClass("invalidInput");
			}
			if($username.val().length===0){
				$username.addClass("invalidInput");
			}
		}
	});

	//mengecek apakah input dr user sudah valid atau belum
	function isValid(username, passowrd){
		return username.length !== 0 && passowrd.length !== 0;
	}

	function loadAJAX(data, onSuccess){
		console.log("Dataaa: "+data.start);
		var url = "http://localhost/sisidangB11/login/login.php";
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

	function onSuccessLogin(result){
		console.log(result);
		var data = JSON.parse(result);
		switch(data.result){
			case "match":
				sessionStorage.setItem("user",data.message.username);
				window.open("../Main","_self");
				break;
			case "dismatch":
				alert(data.message);
				break;
			case "admin":
				var user = "admin";
				sessionStorage.setItem("user",user);
				window.open("../Main","_self");
				break;
			default:
				"user tidak ditemukan";
				break;
		}
	}

} );