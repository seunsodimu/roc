<?= $this->extend("layouts/app") ?>

<?=$this->section("meta")?>
<?php
// var_dump($data['meta_tags']['tags']); exit;
foreach ($data['meta_tags']['tags'] as $tag) {
    if ($tag['enabled']) :
        echo "<meta {$tag['type']}='{$tag['type_value']}' content='{$tag['content']}'>";
endif;
    }
?>
<?=$this->endSection()?>

<?=$this->section("topscripts")?>
<?=$this->endSection()?>

<?=$this->section("page_top_promo")?>
<?php if ($data['page_top_promo']['enabled']) : ?>
    <div class="notice-top-bar bg-primary" data-sticky-start-at="100">
				<button class="hamburguer-btn hamburguer-btn-light notice-top-bar-close m-0 active" data-set-active="false">
					<span class="close">
						<span></span>
						<span></span>
					</span>
				</button>
				<div class="container">
					<div class="row justify-content-center py-2">
						<div class="col-9 col-md-12 text-center">
							<p class="text-color-light mb-0"><?= $data['page_top_promo']['text'] ?></p>
						</div>
					</div>
				</div>
			</div>
<?php endif; ?>
<?=$this->endSection()?>

<?=$this->section("body")?>
<div role="main" class="main shop pb-4">

				<div class="container">

					<div class="row">
						<div class="col">
							<ul class="breadcrumb font-weight-bold text-6 justify-content-center my-5">
								<li class="text-transform-none me-2">
									<span class="text-decoration-none text-color-primary">Shopping Cart</span>
								</li>
							</ul>
						</div>
					</div>
					<div class="row pb-4 mb-5">
						<div class="col-lg-8 mb-5 mb-lg-0">
							<form method="post" action="">
								<div class="table-responsive">
									<table class="shop_table cart">
										<thead>
											<tr class="text-color-dark">
												<th class="product-thumbnail" width="15%">
													&nbsp;
												</th>
												<th class="product-name text-uppercase" width="30%">
													Item
												</th>
												<th class="product-price text-uppercase" width="15%">
													Price
												</th>
												<th class="product-quantity text-uppercase" width="20%">
													Rent Duration
												</th>
												<th class="product-subtotal text-uppercase text-end" width="20%">
													Subtotal
												</th>
											</tr>
										</thead>
										<tbody>
                                            <?php if((session()->get('cart')) && (session()->get('cart_count')) > 0){ ?>
                                                <?php foreach(session()->get('cart') as $cart) :
                                                    // first key
                                                    $key = array_search($cart, session()->get('cart'));

                                                    ?>

											<tr class="cart_table_item">
												<td class="product-thumbnail">
													<div class="product-thumbnail-wrapper">
														<a href="#" class="product-thumbnail-remove" title="Remove Product"  onclick="removeCartItem(<?= $key ?>)">
                                                        <i class="fa fa-trash"></i></a>	
														</a>
														<a href="<?= base_url('product/').$cart['product_id'] ?>" class="product-thumbnail-image" title="<?= $cart['product_name'] ?>">
															<img width="90" height="90" alt="" class="img-fluid" src="<?= $cart['product_image'] ?>">
														</a>
													</div>
												</td>
												<td class="product-name">
													<a href="<?= base_url('product/').$cart['product_id'] ?>" class="font-weight-semi-bold text-color-dark text-color-hover-primary text-decoration-none"><?= $cart['product_name'] ?></a>
                                                    <br><span class="text-color-grey font-weight-semi-bold">(<?= $cart['color_name'] ?>)</span>
                                                    <br><span class="text-color-dark"><?= $cart['product_extra'] ?></span>
												</td>
												<td class="product-price">
													<span class="amount font-weight-medium text-color-grey">$<?= $cart['product_price'] ?> / day</span>
												</td>
												<td class="product-quantity">
													<div class="float-none m-0">
                                                    <?= $cart['rent_duration'] ?> days
                                                    <br><span style="font-size: 12px"> (starting <?= date('m-d-Y', strtotime($cart['rental_start'])) ?>)</span>
													</div>
												</td>
												<td class="product-subtotal text-end">
													<span class="amount text-color-dark font-weight-bold text-4">$<?= $cart['subtotal'] ?></span>
												</td>
											</tr>

                                            <?php endforeach; ?>
                                            <?php }else{ ?>
                                                <tr>
                                                    <td colspan="5" class="text-center">No items in cart</td>
                                                </tr>
                                            <?php } ?>

										</tbody>
									</table>
								</div>
							</form>
						</div>
						<div class="col-lg-4 position-relative">
                            <?php if(session()->get('cart_count') > 0) : ?>
							<div class="card border-width-3 border-radius-0 border-color-hover-dark" data-plugin-sticky data-plugin-options="{'minWidth': 991, 'containerSelector': '.row', 'padding': {'top': 85}}">
								<div class="card-body">
									<h4 class="font-weight-bold text-uppercase text-4 mb-3">Cart Totals</h4>
									<table class="shop_table cart-totals mb-4">
										<tbody>
											<tr class="cart-subtotal">
												<td class="border-top-0">
													<strong class="text-color-dark">Subtotal</strong>
												</td>
												<td class="border-top-0 text-end">
													<strong><span class="amount font-weight-medium">$<?= session()->get('cart_total') ?></span></strong>
												</td>
											</tr>
											<tr class="shipping">
												<td colspan="2">
													<strong class="d-block text-color-dark mb-2">Shipping & Taxes</strong>

													<div class="d-flex flex-column">
														<i>Taxes and shipping will be calculated at checkout</i>
													</div>
												</td>
											</tr>
											<tr class="total">
												<td>
													<strong class="text-color-dark text-3-5">Total</strong>
												</td>
												<td class="text-end">
													<strong class="text-color-dark"><span class="amount text-color-dark text-5">$<?= session()->get('cart_total') ?></span></strong>
												</td>
											</tr>
										</tbody>
									</table>
									<a href="<?= base_url('payment') ?>" class="btn btn-dark btn-modern w-100 text-uppercase bg-color-hover-primary border-color-hover-primary border-radius-0 text-3 py-3">Proceed to Checkout <i class="fas fa-arrow-right ms-2"></i></a>
									<a href="javascript:void(0)" id="saveCart" class="btn btn-outline-dark btn-modern w-100 text-uppercase bg-color-hover-primary border-color-hover-primary border-radius-0 text-3 py-3 mt-3"><i class="fas fa-save me-2"></i> Save Cart</a>
								</div>
							</div>
                            <?php endif; ?>
						</div>
					</div>
					
				</div>

			</div>
<?=$this->endSection()?>

<?=$this->section("bottomscripts")?>
<script src="<?= base_url() ?>assets/js/examples/examples.gallery.js"></script>	
<script>
	$(document).ready(function() {
		$('#saveCart').click(function(){
			$.ajax({
				url: '<?= base_url('save-cart') ?>',
				type: 'post',
				success: function(response){
					if(response == 'success'){
						alert('Cart saved successfully');
					}else{
						alert('Cart not saved');
					}
				}
			});
		});
	});
	</script>
<?=$this->endSection()?>