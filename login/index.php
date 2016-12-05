<?php
	session_start();
	$_SESSION["role"] = "BLUM ADA";
?>
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
		<input type="text" class="form-control" id="username" placeholder="username">
	</div>
	<div class="form-group">
		<input type="password" class="form-control" id="password" placeholder="password">
	</div>	
	<div>
		<button id="loginButton" class="btn btn-primary btn-block">Login</button>
	</div>
</div>

</body>
</html>