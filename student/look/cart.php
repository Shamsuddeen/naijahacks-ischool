<?php 
	session_start();
	$sub = "Cart";
	include 'inc/header.php';
	require_once 'config/connect.php';
	include 'inc/nav.php'; 
	$cart = $_SESSION['cart'];
?>

	
	<!-- SHOP CONTENT -->
	<section id="content">
		<div class="content-blog">
			<div class="container">
				<div class="row">
					<div class="page_header text-center">
						<h2>Shop Cart</h2>
						<p>Get the best kit for smooth shave</p>
					</div>
					<div class="col-md-12">

<table class="cart-table table table-bordered">
				<thead>
					<tr>
						<th>&nbsp;</th>
						<th>&nbsp;</th>
						<th>Product</th>
						<th>Price</th>
						<th>Quantity</th>
						<th>Total</th>
					</tr>
				</thead>
				<tbody>
				<?php
					//print_r($cart);
				$total = 0;
					foreach ($cart as $key => $value) {
						//echo $key . " : " . $value['quantity'] ."<br>";
						$cartsql = "SELECT * FROM products WHERE id=$key";
						$cartres = mysqli_query($connection, $cartsql);
						$cartr = mysqli_fetch_assoc($cartres);

					
				 ?>
					<tr>
						<td>
							<a class="remove" href="delcart.php?id=<?php echo $key; ?>"><i class="fa fa-times"></i></a>
						</td>
						<td>
							<a href="#"><img src="<?php echo $cartr['thumb']; ?>" alt="" height="90" width="90"></a>					
						</td>
						<td>
							<a href="single.php?id=<?php echo $cartr['id']; ?>"><?php echo substr($cartr['name'], 0 , 30); ?></a>					
						</td>
						<td>
							<span class="amount"><?php echo $currency; ?><?php echo number_format($cartr['price'], 2); ?></span>					
						</td>
						<td>
							<div class="quantity"><?php echo $value['quantity']; ?></div>
						</td>
						<td>
							<span class="amount"><?php echo $currency; ?><?php echo number_format(($cartr['price']*$value['quantity']), 2); ?></span>					
						</td>
					</tr>
				<?php 
					$total = $total + ($cartr['price']*$value['quantity']);
					$_SESSION['cart_total'] = $total;
				} 
				?>
					<tr>
						<td colspan="6" class="actions">
							<div class="col-md-6">
							<!--	<div class="coupon">
									<label>Coupon:</label><br>
									<input placeholder="Coupon code" type="text"> <button type="submit">Apply</button>
								</div> -->
							</div>
							<div class="col-md-6">
								<div class="cart-btn">
									<!-- <button class="button btn-md" type="submit">Update Cart</button> -->
									<a href="checkout.php" class="button btn-md" >Checkout</a>
								</div>
							</div>
						</td>
					</tr>
				</tbody>
			</table>		

			<div class="cart_totals">
				<div class="col-md-6 push-md-6 no-padding">
					<h4 class="heading">Cart Totals</h4>
					<table class="table table-bordered col-md-6">
						<tbody>
							<tr>
								<th>Cart Subtotal</th>
								<td><span class="amount"><?php echo $currency; ?> <?php echo number_format($total, 2); ?></span></td>
							</tr>
							<tr>
								<th>Shipping and Handling</th>
								<td>
									<?php 
										$_SESSION['countShip'] = 0;
										foreach ($cart as $key => $value) {
											//echo $key . " : " . $value['quantity'] ."<br>";
											$ordsql       = "SELECT * FROM products WHERE id=$key";
											$ordres       = mysqli_query($connection, $ordsql);
											$ordr         = mysqli_fetch_assoc($ordres);
											if ($ordr['is_virtual'] == 1 || $ordr['downloadable'] == 1) {
												$eShip = 0;
												$_SESSION['countShip'] = 0;
											}else {
												$_SESSION['countShip'] += 1;
												$eShip = 1;
											}
										}

										$countShip = $_SESSION['countShip'];
										
										if ($shipping != NULL || $shipping != 0) {
											if ($countShip > 0) {	
												echo $currency. number_format($shipping, 0);                                                							
											}else {
												echo "Not Applicable";                                           
											}
										}else {
											echo "Free Shipping";
										}
									?>				
								</td>
							</tr>
							<tr>
								<th>Order Total</th>
								<td>
									<strong><span class="amount">
										<?php 
											if ($countShip > 0) {
												echo $currency. number_format($_SESSION['cart_total'] + $shipping, 2);										
											}else {
												echo $currency." ". number_format($_SESSION['cart_total'], 2);
											}
										?>
									</span></strong> 
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>			
							
					</div>
				</div>
			</div>
		</div>
	</section>
<?php include 'inc/footer.php' ?>
