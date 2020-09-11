<?php
#ini adalah halaman form Login, jika pengguna sudah login maka kami tidak akan mengizinkan pengguna untuk mengakses halaman ini dengan menjalankan isset ($ _ SESSION ["uid"])
#Jika pernyataan di bawah mengembalikan true maka kami akan mengirim pengguna ke halaman profile.php mereka
if (isset($_SESSION["uid"])) {
	header("location:profile.php");
}
// di halaman action.php jika pengguna mengklik tombol "siap untuk checkout" maka saat itu kita akan mengirimkan data dalam bentuk dari halaman action.php
if (isset($_POST["login_user_with_product"])) {
	// ini adalah array daftar produk
	$product_list = $_POST["product_id"];
	// disini kita mengubah array menjadi format json karena array tidak bisa disimpan dalam cookie
	$json_e = json_encode($product_list);
	// di sini kita membuat cookie dan nama cookie adalah product_list
	setcookie("product_list",$json_e,strtotime("+1 day"),"/","","",TRUE);

}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Test Store</title>
		<link rel="stylesheet" href="css/bootstrap.min.css"/>
		<script src="js/jquery2.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="main.js"></script>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
<body>
<div class="wait overlay">
	<div class="loader"></div>
</div>
	<div class="navbar navbar-inverse navbar-fixed-top">
		<div class="container-fluid">	
			<div class="navbar-header">
			</div>
			<ul class="nav navbar-nav">
				<li><a href="index.php"><span class="glyphicon glyphicon-home"></span>Home</a></li>
				<li><a href="index.php"><span class="glyphicon glyphicon-modal-window"></span>Produk</a></li>
			</ul>
		</div>
	</div>
	<p><br/></p>
	<p><br/></p>
	<p><br/></p>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-2"></div>
			<div class="col-md-8" id="signup_msg">
				<!--Alert dari signup form-->
			</div>
			<div class="col-md-2"></div>
		</div>
		<div class="row">
			<div class="col-md-4"></div>
			<div class="col-md-4">
				<div class="panel panel-primary">
					<div class="panel-heading">Customer Login Form</div>
					<div class="panel-body">
						<!--User Login Form-->
						<form onsubmit="return false" id="login">
							<label for="email">Email</label>
							<input type="email" class="form-control" name="email" id="email" required/>
							<label for="email">Password</label>
							<input type="password" class="form-control" name="password" id="password" required/>
							<p><br/></p>
							<a href="#" style="color:#333; list-style:none;">Lupa Password</a><input type="submit" class="btn btn-success" style="float:right;" Value="Login">
							<! - Jika pengguna tidak memiliki akun maka dia akan mengklik tombol buat akun ->
							<div><a href="customer_registration.php?register=1">Buat akun baru?</a></div>						
						</form>
				</div>
				<div class="panel-footer"><div id="e_msg"></div></div>
			</div>
		</div>
		<div class="col-md-4"></div>
	</div>
</body>
</html>






















