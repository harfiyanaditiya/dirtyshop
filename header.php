<?php 
session_start();
include 'koneksi/koneksi.php';
if(isset($_SESSION['kd_cs'])){

	$kode_cs = $_SESSION['kd_cs'];
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>DIRTY-SHOP</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap-theme.css">
	<script  src="js/jquery.js"></script>
	<script  src="js/bootstrap.min.js"></script>


</head>
<body>
	<div class="container-fluid">
		<div class="row top" style="background-color: #ff8c00">
			<center>
				<!-- <div class="col-md-4 bg-danger text-primary" style="padding: 3px;">
					<span> <i class="glyphicon glyphicon-earphone"></i> </span>
					<span> - </span>
				</div> -->


				<div class="background-color #198754"  style="padding: 3px;background-color: #ff8c00">
					<span  style="color:white"><i class="glyphicon glyphicon-envelope colo"></i> dirtysketch22@gmail.com</span>
				</div>


				<!-- <div class="col-md-4 bg-danger text-primary"  style="padding: 3px;">
					<span>-</span>
				</div> -->
			</center>
		</div>
	</div>

	<nav class="navbar navbar-default" style="padding: 5px;">
		<div class="container">

			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#" style="color: #ff8c00"><b>DIRTY-SHOP</b></a>
			</div>

			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1" >
				<ul class="nav navbar-nav navbar-right">
					<li><a href="index.php">Home</a></li>
					<li><a href="produk.php">Products</a></li>
					<!-- <li><a href="about.php">About Us</a></li> -->
					<li><a href="manual.php">How to Order</a></li>
					<?php 
					if(isset($_SESSION['kd_cs'])){
					$kode_cs = $_SESSION['kd_cs'];
					$cek = mysqli_query($conn, "SELECT kode_produk from keranjang where kode_customer = '$kode_cs' ");
					$value = mysqli_num_rows($cek);

						?>
						<li><a href="history.php">Order History</a></li>
						<li><a href="keranjang.php"><i class="glyphicon glyphicon-shopping-cart"></i> <b>[ <?= $value ?> ]</b></a></li>
						<?php 
					}else{
						echo "
						<li><a href='keranjang.php'><i class='glyphicon glyphicon-shopping-cart'></i> [0]</a></li>

						";
					}
					if(!isset($_SESSION['user'])){
						?>

						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="glyphicon glyphicon-user"></i> Akun <span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a href="user_login.php">login</a></li>
								<li><a href="register.php">Register</a></li>
							</ul>
						</li>
						<?php 
					}else{
						?>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="glyphicon glyphicon-user"></i> <?= $_SESSION['user']; ?> <span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a href="proses/logout.php">Log Out</a></li>
							</ul>
						</li>

						<?php 
					}
					?>
				</ul>
			</div><!-- /.navbar-collapse -->
		</div><!-- /.container-fluid -->
	</nav>