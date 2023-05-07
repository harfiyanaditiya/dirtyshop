<?php 
include 'header.php';
$kd = mysqli_real_escape_string($conn,$_GET['kode_cs']);
$cs = mysqli_query($conn, "SELECT * FROM customer WHERE kode_customer = '$kd'");
$rows = mysqli_fetch_assoc($cs);
?>

<div class="container" style="padding-bottom: 100px">
	<h2 style=" width: 100%; border-bottom: 4px solid #ff8680"><b>Checkout</b></h2>
	<div class="row">
		<div class="col-md-12">
			<h4>Order List</h4>
			<table class="table table-stripped">
				<tr>
					<th>No</th>
					<th>Name</th>
					<th>Price</th>
					<th>Qty</th>
					<th>Sub Total</th>
				</tr>
				<?php 
				$result = mysqli_query($conn, "SELECT * FROM keranjang WHERE kode_customer = '$kd'");
				$no = 1;
				$hasil = 0;
				while($row = mysqli_fetch_assoc($result)){
					?>
					<tr>
						<td><?= $no; ?></td>
						<td><?= $row['nama_produk']; ?></td>
						<td>$<?= number_format($row['harga']); ?></td>
						<td><?= $row['qty']; ?></td>
						<td>$<?= number_format($row['harga'] * $row['qty']);  ?></td>
					</tr>
					<?php 
					$total = $row['harga'] * $row['qty'];
					$hasil += $total;
					$no++;
				}
				?>
				<tr>
					<td colspan="5" style="text-align: right; font-weight: bold;">Grand Total = $<?= number_format($hasil); ?></td>
				</tr>
			</table>
		</div>

	</div>
	<div class="row">
	<div class="col-md-6 bg-success">
		<h5>Make Sure Your Order Is Correct</h5>
	</div>
	</div>
	<br>
	<div class="row">
	<div class="col-md-6 bg-warning">
		<h5>Fill in the form below </h5>
	</div>
	</div>
	<br>
	<form action="proses/order.php" method="POST">
		<input type="hidden" name="kode_cs" value="<?= $kd; ?>">
		<div class="form-group">
			<label for="exampleInputEmail1">Name</label>
			<input type="text" class="form-control" id="exampleInputEmail1" required placeholder="Name" name="nama" style="width: 557px;" value="<?= $rows['nama']; ?>" readonly>
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="exampleInputPassword1">State</label>
					<input type="text" class="form-control" id="exampleInputPassword1" required placeholder="State" name="prov">
				</div>
			</div>

			<div class="col-md-6">
				<div class="form-group">
					<label for="exampleInputPassword1">City</label>
					<input type="text" class="form-control" id="exampleInputPassword1" required placeholder="City" name="kota">
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="exampleInputPassword1">Street</label>
					<input type="text" class="form-control" id="exampleInputPassword1" required placeholder="Street" name="almt">
				</div>
			</div>

			<div class="col-md-6">
				<div class="form-group">
					<label for="exampleInputPassword1">Zip Code</label>
					<input type="text" class="form-control" id="exampleInputPassword1" required placeholder="Zip Code" name="kopos">
				</div>
			</div>
		</div>
		<div class="btn " type="submit" id="paypal-button-container"></div>
		<!-- <button type="submit" class="btn btn-success"><i class="glyphicon glyphicon-shopping-cart"></i> Order Now</button> -->
		
		<!-- <a href="keranjang.php" class="btn btn-danger">Cancel</a> -->
	</form>
	
</div>


<?php 
include 'footer.php';
?>

<!-- Replace "test" with your own sandbox Business account app client ID -->
<script src="https://www.paypal.com/sdk/js?client-id=AbDe1DNkrsOaSnDSA7V9HP3Ezql0R--zpDwhbSYPnNxZNux5HClr2lLDr4zAbD6RNDzu_8qIppjBbGtW&currency=USD"></script>
<script>
    //   const fundingSources = [
    //     paypal.FUNDING.PAYPAL,
    //     paypal.FUNDING.PAYLATER,
    //     paypal.FUNDING.VENMO,
    //     paypal.FUNDING.CARD
    //   ];

    //   for (const fundingSource of fundingSources) {
        
    //     paypal
    //     .Buttons({
    //        fundingSource,
          
    //        style: {
    //          layout: 'vertical',
    //          shape: 'rect'
    //        },
       
    //        createOrder: function (data, actions) {
    //          const createOrderPayload = {
    //            purchase_units: [
    //              {
    //                amount: {
    //                  value: '<?= $hasil ?>',
    //                },
    //              },
    //            ],
    //          };
       
    //          return actions.order.create(createOrderPayload);
    //        },
           
    //        onApprove: function (data, actions) {
             
    //        },
    //     })
    //     .render("#paypal-button-container");
    //    }



	   paypal.Buttons({
			// onclick(){
			// 	var kode_cs =$(kode_cs).val();
			// 	var nama =$('#nama').val();
			// 	var prov =$('#prov').val();
			// 	var kota =$('#kota').val();
			// 	var almt =$('#almt').val();
			// 	var kopos =$('#kopos').val();
			// },
			createOrder: (data, actions) => {
				return actions.order.create({
					purchase_units: [{
						amount: {
							value: '<?= $hasil?>'
						}
					}]
				});
			},

			onApprove: (data, actions) => {
				return actions.order.capture().then(function(orderData) {
					// console.log('capture result', orderData, JSON.stringify(orderData, null, 2));
					const transaction = orderData.purchase_units[0].payments.captures[0];

					// var data = {
					// 	'kode_cs':kode_cs,
					// 	'nama':nama,
					// 	'prov':prov,
					// 	'kota':kota,
					// 	'almt':almt,
					// 	'kopos':kopos,
					// }
					$.ajax({
						method: "POST",
						url: "proses/order.php",
						data: data,
						success: function (response){
							window.location.href = 'selesai.php';
						}
					});

					// alert(`Transaction ${transaction.status}`);
				});
			}
	   }).render("#paypal-button-container");
    </script>
