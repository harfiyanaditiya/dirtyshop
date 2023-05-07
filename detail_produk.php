<?php 
include 'header.php';
$kode = mysqli_real_escape_string($conn,$_GET['produk']);
$result = mysqli_query($conn, "SELECT * FROM produk WHERE kode_produk = '$kode'");
$row = mysqli_fetch_assoc($result);

?>
<div class="container">
	<h2 style=" width: 100%; border-bottom: 4px solid white; color:black"><b>Product details</b></h2>

	<div class="row">
		<div class="col-md-4">
			<div class="thumbnail">
				<img src="image/produk/<?= $row['image']; ?>" width="400">
			</div>
		</div>

		<div class="col-md-8">
			<form action="proses/add.php" method="GET">
				<input type="hidden" name="kd_cs" value="<?= $kode_cs; ?>">
				<input type="hidden" name="produk" value="<?= $kode;  ?>">
				<input type="hidden" name="hal"  value="2">
				<table class="table table-striped">
					<tbody>
						<tr>
							<td><b>Name</b></td>
							<td><?= $row['nama']; ?></td>
						</tr>
						<tr>
							<td><b>Price</b></td>
							<td>$<?= number_format($row['harga']); ?></td>
						</tr>
						<tr>
							<td><b>Description</b></td>
							<td><?= $row['deskripsi'];  ?></td>
						</tr>
						<tr>
							<td><b>Quantity</b></td>
							<td><input class="form-control" type="number" min="1" name="jml" value="1" style="width: 155px;"></td>
						</tr>
					</tbody>
				</table>
				<div class="row">
					<?php if(isset($_SESSION['kd_cs'])){ ?>
					<div class="col-md-3 ">
						<a href="proses/add.php?produk=<?= $row['kode_produk']; ?>&kd_cs=<?= $kode_cs; ?>&hal=1" class="btn btn-success btn-block " role="button"><i class="glyphicon glyphicon-shopping-cart"></i> Add to Cart</a>
					</div>
					<?php 
						}
					else{
						?>
					<div class="col-md-3">
						<a href="keranjang.php" class="btn btn-success btn-block" role="button"><i class="glyphicon glyphicon-shopping-cart"></i> Add to Cart</a>
					</div>

					<?php 
						}
					?>
					<div class="col-md-3">
						<a href="#" onclick="history.go(-1)" class="btn btn-warning btn-block">Back</a> 
					</div>
				</div>
		</form>
	</div>
</div>	
<br>
<br>

<div class="container">
	<h3 style=" width: 100%; border-top: 2px solid white; color:black">You may also like</h3>
	<br>

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