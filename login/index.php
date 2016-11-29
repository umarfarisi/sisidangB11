<!DOCTYPE html>
<html>
<head>
	<title>Personal Library</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/login.css" id="css-container">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="js/login.js"></script>
</head>
<body>

<h1>Login to Sisidang</h1>
<div id="formLogin">
	<div class="form-group">
		<input type="text" class="form-control" id="username" placeholder="username" value="belawati">
	</div>
	<div class="form-group">
		<input type="password" class="form-control" id="password" placeholder="password" value="qdlgxwzmsv">
	</div>
	<div class="form-group">
		<select class="form-control" id="role">
		  <option value="default">-- Select your role --</option>
		  <option value="admin">Admin</option>
		  <option value="dosen" selected>Dosen</option>
		  <option value="mahasiswa">Mahasiswa</option>
		</select>
	</div>	
	<div>
		<button id="loginButton" class="btn btn-primary btn-block">Login</button>
	</div>
</div>

</body>
</html>