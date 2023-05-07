<?php 
include 'header.php';
?>
<!-- IMAGE -->
<div class="container-fluid" style="margin: 0;padding: 0;">
	<div class=" " style="margin-top: -21px; ">
		<img class="" src="image/home/3.png" style="width: 100%;  height: auto; position-relative; ">
		
		<a href="produk.php" class=" btn position-absolute" style="position:absolute; top:52%; left:43%; width:15%; height:60px; background-color:black; color:white; text-align: center; padding: 17px 27px "><span>SHOP NOW</span></a>
	</div>
</div>
<br>
<br>

<!-- PRODUK TERBARU -->
<div class="container">
	<h2 style=" width: 100%; border-bottom: 4px solid white; color:black"><b>Products</b></h2>

	<div class="row">
		<?php 
		$result = mysqli_query($conn, "SELECT * FROM produk");
		while ($row = mysqli_fetch_assoc($result)) {
			?>
			<div class="col-sm-6 col-md-3">
				<div class="thumbnail" style="height:36rem">
					<img src="image/produk/<?= $row['image']; ?>" style="height:20rem" >
					<div class="caption">
						<h5><?= $row['nama'];  ?></h5>
						<h4>$<?= number_format($row['harga']); ?></h4>
						<div class="row">
							<div class="col">
								<a href="detail_produk.php?produk=<?= $row['kode_produk']; ?>" class="btn btn-warning btn-block">More</a> 
							</div>
							<?php if(isset($_SESSION['kd_cs'])){ ?>
								<div class="col ">
									<a href="proses/add.php?produk=<?= $row['kode_produk']; ?>&kd_cs=<?= $kode_cs; ?>&hal=1" class="btn btn-success btn-block " role="button"><i class="glyphicon glyphicon-shopping-cart"></i> Add to Cart</a>
								</div>
								<?php 
							}
							else{
								?>
								<div class="col">
									<a href="keranjang.php" class="btn btn-success btn-block" role="button"><i class="glyphicon glyphicon-shopping-cart"></i> Add to Cart</a>
								</div>

								<?php 
							}
							?>

						</div>

					</div>
				</div>
			</div>
			<?php 
		}
		?>
	</div>

</div>

</div>
<br>
<br>
<br>
<br>
<?php 
include 'footer.php';
?>