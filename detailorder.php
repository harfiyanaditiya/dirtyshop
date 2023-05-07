<?php 
include 'header.php';
$invoices = $_GET['inv'];
$d_order = mysqli_query($conn, "SELECT * FROM produksi WHERE invoice = '$invoices'");
$t_order = mysqli_fetch_assoc($d_order);

$sortage = mysqli_query($conn, "SELECT * FROM produksi where cek = '1'");
$cek_sor = mysqli_num_rows($sortage);

// customer
$cs = mysqli_query($conn, "SELECT * FROM customer WHERE kode_customer = '".$t_order['kode_customer']."'");
$t_cs = mysqli_fetch_assoc($cs);
?>

<div class="container">

	<h5 class="bg-success" style="padding: 7px; width: 810px; font-weight: bold;"><marquee>Reload every time you enter this page, to avoid data and information errors</marquee></h5>

	<table class="table table-striped">
		<thead>
			<tr>
				<th scope="col">No</th>
				<th scope="col">Invoice</th>
				<th scope="col">Customer Code</th>
				<th scope="col">Status</th>
				<th scope="col">Date</th>
				<th scope="col">Action</th>
			</tr>
		</thead>
		<tbody>

			<?php 
                    $kode_cs = $_SESSION['kd_cs'];
                    $result = mysqli_query($conn, "SELECT * FROM produksi WHERE kode_customer='$kode_cs'");
                    $no = 1;
                    $array = 0;
                    while($row = mysqli_fetch_assoc($result)){
                        $kodep = $row['kode_produk'];
                        $inv = $row['invoice'];
				?>

				<tr>
					<td><?= $no; ?></td>
					<td><?= $row['invoice']; ?></td>
					<td><?= $row['kode_customer']; ?></td>
					<?php if($row['terima'] == 1){ ?>
						<td style="color: green;font-weight: bold;">Pesanan Diterima (Siap Kirim)
							<?php
						}else if($row['tolak'] == 1){
							?>
							<td style="color: red;font-weight: bold;">Pesanan Ditolak
								<?php 
							}
							if($row['terima'] == 0 && $row['tolak'] == 0){
								?>
								<td style="color: orange;font-weight: bold;"><?= $row['status']; ?>
								<?php 
							}
							$t_bom = mysqli_query($conn, "SELECT * FROM bom_produk WHERE kode_produk = '$kodep'");

							while($row1 = mysqli_fetch_assoc($t_bom)){
								$kodebk = $row1['kode_bk'];

								$inventory = mysqli_query($conn, "SELECT * FROM inventory WHERE kode_bk = '$kodebk'");
								$r_inv = mysqli_fetch_assoc($inventory);

								$kebutuhan = $row1['kebutuhan'];	
								$qtyorder = $row['qty'];
								$inventory = $r_inv['qty'];

								$bom = ($kebutuhan * $qtyorder);
								$hasil = $inventory - $bom;
								if($hasil < 0 && $row['tolak'] == 0){
									$nama_material[] = $r_inv['nama'];
									mysqli_query($conn, "UPDATE produksi SET cek = '1' where invoice = '$inv'");
									?>
									<?php 
								}
							}
							?>
						</td>
						<td><?= $row['tanggal']; ?></td>
						<td>
							<a href="detailorder.php?inv=<?= $row['invoice']; ?>&cs=<?= $row['kode_customer']; ?>" type="submit" class="btn btn-warning"><i class="glyphicon glyphicon-eye-open"></i> Order Details</a>
						</td>
					</tr>
					<?php
					$no++; 
				}
				?>

			</tbody>
		</table>



	<button type="hidden" data-toggle="modal" data-target="#myModal" id="btn" style="background-color: #fff; border: #fff;">
	</button>
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<a href="m_produk.php" class="btn btn-default close"></a>
					<h4 class="modal-title" id="myModalLabel">#<?= $t_order['invoice']; ?></h4>
				</div>
				<div class="modal-body">
					<table class="table table-striped">
						<tr>
							<td>Invoice</td>
							<td><?= $t_order['invoice']; ?></td>
						</tr>
						<tr>
							<td>Customer Code</td>
							<td><?= $t_order['kode_customer']; ?></td>
						</tr>
						<tr>
							<td>Name</td>
							<td><?= $t_cs['nama']; ?></td>
						</tr>
						<tr>
							<td>Address</td>
							<td><?php echo  $t_order['alamat'].",".$t_order['kota']." ".$t_order['provinsi'].",".$t_order['kode_pos']; ?></td>
						</tr>
						<tr>
							<td>Phone number</td>
							<td><?= $t_cs['telp']; ?></td>
						</tr>
					</table>

					<hr>
					<h4>List Order</h4>
					<table class="table table-striped">
						<tr>
							<th>No</th>
							<th>Product Code</th>
							<th>Product Name</th>
							<th>Price</th>
							<th>Quantity</th>
							<th>Subtotal</th>
						</tr>
					<?php 
						$order = mysqli_query($conn, "SELECT * FROM produksi WHERE invoice = '$invoices'");
						$no = 1;
						$grand = 0;
						while ($list = mysqli_fetch_assoc($order)) {
					 ?>
						<tr>
							<td><?= $no;  ?></td>
							<td><?= $list['kode_produk']; ?></td>
							<td><?= $list['nama_produk']; ?></td>
							<td>$<?= number_format($list['harga'], 0, ".", ".");  ?></td>
							<td><?= $list['qty'];  ?></td>
							<td>$<?= number_format($list['harga']*$list['qty'], 0, ".", ".");  ?></td>
						</tr>
					<?php 
						$sub = $list['harga'] * $list['qty'];
						$grand += $sub;
						$no++;
						}
					 ?>
						<tr>
							<td colspan="6" class="text-right"><b>Grand Total = $<?= number_format($grand, 0, ".", ".");  ?></b></td>
						</tr>
					</table>
				</div>
				<div class="modal-footer">
					<a href="history.php" class="btn btn-default">Close</a>
				</div>
			</div>
		</div>
	</div>

		<?php 
if($cek_sor > 0){
 ?>
	<br>
	<br>
	<div class="row">
		<div class="col-md-4 bg-danger" style="padding:10px;">
			<h4>Kekurangan Material </h4>
			<h5 style="color: red;font-weight: bold;">Silahkan Tambah Stok Material dibawah ini : </h5>
			<table class="table table-striped">
				<tr>
					<th>No</th>
					<th>Material</th>
				</tr>
	<?php 
	$arr = array_values(array_unique($nama_material));
	for ($i=0; $i < count($arr); $i++) { 

	 ?>
				<tr>
					<td><?= $i+1 ?></td>
					<td><?= $arr[$i]; ?></td>
				</tr>
	<?php } ?>
			</table>
		</div>
	</div>
<?php 
}
 ?>
	</div>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
<script type="text/javascript">
	$( document ).ready(function() {
		$( "#btn" ).click();
	});
</script>

	<?php 
	include 'footer.php';
	?>