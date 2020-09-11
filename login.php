<?php
include "db.php";

session_start();

#skrip #Login dimulai di sini
# Jika pengguna diberi kredensial yang cocok dengan data yang tersedia di database, maka kita akan menggemakan string login_success
#login_success string akan kembali ke fungsi Anonymous funtion $("# login"). click ()
if(isset($_POST["email"]) && isset($_POST["password"])){
	$email = mysqli_real_escape_string($con,$_POST["email"]);
	$password = md5($_POST["password"]);
	$sql = "SELECT * FROM user_info WHERE email = '$email' AND password = '$password'";
	$run_query = mysqli_query($con,$sql);
	$count = mysqli_num_rows($run_query);
	// jika record pengguna tersedia di database maka $count akan sama dengan 1
	if($count == 1){
		$row = mysqli_fetch_array($run_query);
		$_SESSION["uid"] = $row["user_id"];
		$_SESSION["name"] = $row["first_name"];
		$ip_add = getenv("REMOTE_ADDR");
		// kita telah membuat cookie di halaman login_form.php jadi jika cookie itu tersedia berarti pengguna tidak login
			if (isset($_COOKIE["product_list"])) {
				$p_list = stripcslashes($_COOKIE["product_list"]);
				// di sini kita mendekode cookie daftar produk json yang disimpan ke array normal
				$product_list = json_decode($p_list,true);
				for ($i=0; $i < count($product_list); $i++) { 
					// Setelah mendapatkan user id dari database disini kita memeriksa item keranjang pengguna apakah sudah ada produk yang terdaftar atau belum
					$verify_cart = "SELECT id FROM cart WHERE user_id = $_SESSION[uid] AND p_id = ".$product_list[$i];
					$result  = mysqli_query($con,$verify_cart);
					if(mysqli_num_rows($result) < 1){
						// jika pengguna menambahkan produk pertama kali ke keranjang, kita akan memperbarui user_id ke tabel database dengan id yang valid
						$update_cart = "UPDATE cart SET user_id = '$_SESSION[uid]' WHERE ip_add = '$ip_add' AND user_id = -1";
						mysqli_query($con,$update_cart);
					}else{
						// jika produk tersebut sudah tersedia di tabel database, kami akan menghapus record tersebut
						$delete_existing_product = "DELETE FROM cart WHERE user_id = -1 AND ip_add = '$ip_add' AND p_id = ".$product_list[$i];
						mysqli_query($con,$delete_existing_product);
					}
				}
				// di sini kita menghancurkan cookie pengguna
				setcookie("product_list","",strtotime("-1 day"),"/");
				// jika pengguna login dari halaman setelah keranjang kita akan mengirim cart_login
				echo "cart_login";
				exit();
				
			}
			// jika pengguna login dari halaman kita akan mengirimkan login_success
			echo "login_success";
			exit();
		}else{
			echo "<span style='color:red;'> Silahkan daftar sebelum login ..!</span>";
			exit();
		}
	
}

?>