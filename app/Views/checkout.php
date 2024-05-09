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
<style>
    tr.noBorder td {
  border: 0;
}
</style>
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

                            <?php if(session()->get('cart_count') > 0) : ?>
                            <div class="row mt-5">
                                <h2>Shipping Address</h2>
                                <div class="row">
                                <?php if (session()->getFlashdata('validation')) : ?>
								<div class="alert alert-danger alert-dismissible" role="alert">
								<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
									<?= session()->getFlashdata('validation')->listErrors() ?>
								</div>
							<?php endif; ?>
							<?php if (session()->getFlashdata('msg')) : ?>
								<div class="alert alert-<?= session()->getFlashdata('msgtype') ?> alert-dismissible" role="alert">
								<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
									<?= session()->getFlashdata('msg') ?>
								</div>
							<?php endif; ?>
                                </div>
                                <div class="row">
                                    <form method="post" action="<?= base_url('update-shipping-details') ?>" id="shippingdetform">   
                                    <div class="form-group">
                                        <label for="shipping_name">Name</label>
                                        <input type="text" class="form-control" value="<?= $data['user_data']['first_name']. ' '.$data['user_data']['last_name'] ?>" id="shippingName" name="shipping_name" placeholder="Enter your name">
                                        <span class="text-danger"><?= isset($validation) ? display_error($validation, 'shipping_name') : '' ?></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="shipping_email">Email</label>
                                        <input type="email" class="form-control" id="shipping_email" name="shippingEmail" value="<?= $data['user_data']['email'] ?>" placeholder="Enter your email">
                                        <span class="text-danger"><?= isset($validation) ? display_error($validation, 'shipping_email') : '' ?></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="shipping_phone">Phone</label>
                                        <input type="text" class="form-control" id="shipping_phone" name="shippingPhone" value="<?= $data['user_data']['phone'] ?>" placeholder="Enter your phone">
                                        <span class="text-danger"><?= isset($validation) ? display_error($validation, 'shipping_phone') : '' ?></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="shipping_address">Address</label>
                                        <input type="text" class="form-control" id="shipping_address" name="shippingAddress" value="<?= $data['user_data']['address'] ?>" placeholder="Enter your address">
                                        <span class="text-danger"><?= isset($validation) ? display_error($validation, 'shipping_address') : '' ?></span>
                                    </div>
                                    <div class="row">
                                    <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="shipping_city">City</label>
                                        <input type="text" class="form-control" id="shipping_city" name="shippingCity" value="<?= $data['user_data']['city'] ?>" placeholder="Enter your city">
                                        <span class="text-danger"><?= isset($validation) ? display_error($validation, 'shipping_city') : '' ?></span>
                                    </div>
                                    </div>
                                    <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="shipping_state">State</label>
                                        <input type="text" class="form-control" id="shipping_state" name="shippingState" value="<?= $data['user_data']['state'] ?>" placeholder="Enter your state">
                                        <span class="text-danger"><?= isset($validation) ? display_error($validation, 'shipping_state') : '' ?></span>
                                    </div>
                                    </div>
                                    <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="shipping_zip">Zip</label>
                                        <input type="text" class="form-control" id="shipping_zip" name="shippingZip" value="<?= $data['user_data']['zip'] ?>" placeholder="Enter your zip">
                                        <span class="text-danger"><?= isset($validation) ? display_error($validation, 'shipping_zip') : '' ?></span>
                                    </div>
                                    </div>
                                    </div>
                                    <button id="updateShipping" type="submit" class="btn btn-primary">Update Shipping Address</button>
                                </form>
                                </div>
                            </div>
						</div>
                        <?php endif; ?>
						<div class="col-lg-4 position-relative">
                            <?php if(session()->get('cart_count') > 0) : ?>
							<div class="card border-width-3 border-radius-0 border-color-hover-dark" data-plugin-sticky data-plugin-options="{'minWidth': 991, 'containerSelector': '.row', 'padding': {'top': 85}}">
								<div class="card-body">
									<h4 class="font-weight-bold text-uppercase text-4 mb-3">Cart Totals</h4>
									<div id="cart-tot-table">
                                        <table class="table cart-totals">
                                            <tbody>
                                                <tr class="cart-subtotal">
                                                    <th class="text-color-dark text-uppercase">Subtotal</th>
                                                    <td class="text-end text-5 text-color-dark font-weight-bold">$<?= session()->get('cart_total') ?></td>
                                                </tr>
                                                <tr class="shipping">
                                                    <th class="text-color-dark text-uppercase">Shipping </th>
                                                    <td></td>
                                                </tr>
                                                <tr class="noBorder">
                                                    <td>
                                                        <label>
                                                            <input class="shipping_options" type="radio" name="shipping_option" value="FreeShipping"<?= ($data['selected_shipping'] == 'FreeShipping') ? ' checked' : ''; ?>>
                                                            Free Shipping<br>(5-8 business days)
                                                        </label>
                                                    </td>
                                                    <td class="text-end shippingCost">$0.00</td>
                                                </tr>
                                                <?php if($data['shipping_rates']) : ?>
                                                    <?php foreach($data['shipping_rates'] as $rate) : ?>
                                                        <tr class="noBorder">
                                                            <td><label>
                                                                <input class="shipping_options" type="radio" name="shipping_option" value="<?= $rate['service_identifier'] ?>"<?= ($data['selected_shipping'] == $rate['service_identifier']) ? ' checked' : ''; ?>>
                                                            <?= $rate['service'] ?><br>(<?= $rate['delivery_days'] ?> business days)
                                                            </label></td>
                                                            <td class="text-end shippingCost">$<?= $rate['rate'] ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                                <?php if($data['taxes'] > 0) : ?>
                                                    <tr class="taxes">
                                                        <th class="text-color-dark text-uppercase">Taxes (<?= $data['tax_rate'] ?>%)</th>
                                                        <td class="text-end text-5 text-color-dark">$<?= $data['taxes'] ?></td>
                                                    </tr>
                                                <?php endif; ?>
                                                <tr class="total">
                                                    <th class="text-color-dark text-uppercase">Total</th>
                                                    <td class="text-end text-5 text-color-dark font-weight-bold">$<?= $data['grand_total'] ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
									<a href="<?= base_url('payment') ?>" class="btn btn-dark btn-modern w-100 text-uppercase bg-color-hover-primary border-color-hover-primary border-radius-0 text-3 py-3">Proceed to Checkout <i class="fas fa-arrow-right ms-2"></i></a>
									<a href="javascript:void(0)" id="saveCart" class="btn btn-outline-dark btn-modern w-100 text-uppercase bg-color-hover-primary border-color-hover-primary border-radius-0 text-3 py-3 mt-3"><i class="fas fa-save me-2"></i> Save Cart</a>
								</div>
							</div>
                            <?php endif; ?>
						</div>
					</div>
					
				</div>
<!-- modal -->
<div id="loading" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="loading" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 bg-transparent">
            <div class="modal-body text-center p-5">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <h4 class="text-primary mt-3 text-light" id='modalmsg'>Crunching numbers, please wait...</h4>
            </div>
        </div>
    </div>
</div>
			</div>
<?=$this->endSection()?>

<?=$this->section("bottomscripts")?>
<script src="<?= base_url() ?>assets/js/examples/examples.gallery.js"></script>	
<script>
    
	$(document).ready(function() { 
        <?php if(session()->getFlashdata('shippingDetUpdtateMsg')) : ?>
            $('#modalmsg').html('Shipping details updated successfully');
            $('#loading').modal('show');
            setTimeout(function(){
                $('#loading').modal('hide');
            }, 2000);
        <?php endif; ?>
        //shpping details form submit, disable submit button, show modal, then submit form
        $('#shippingdetform').submit(function(e){
            e.preventDefault();
            $('#updateShipping').attr('disabled', true);
            $('#modalmsg').html('Updating shipping details, please wait...');
            $('#loading').modal('show');
            $(this).unbind('submit').submit();
        });

        $('.shipping_options').change(function(){
            var shipping_option = $(this).val();
            var shipping_cost = $(this).closest('tr').find('.shippingCost').text();
            var tax_rate = <?= $data['tax_rate'] ?>;
                $('#loading').modal('show');
                $.ajax({
                    url: '<?= base_url('updateShippingOption') ?>',
                    type: 'post',
                    data: { shipping_option: shipping_option, shipping_cost: shipping_cost, tax_rate: tax_rate },
                    success: function (response) {
                        response = JSON.parse(response);
                        $('#loading').modal('hide');
                        if (response.status == 'success') {
                            // alert('Shipping option updated successfully');
                            location.reload();
                        } else {
                            alert('Shipping option not updated');
                        }
                    }
                });

            });

            $('#saveCart').click(function () {
                $.ajax({
                    url: '<?= base_url('save-cart') ?>',
                    type: 'post',
                    success: function (response) {
                        if (response == 'success') {
                            alert('Cart saved successfully');
                        } else {
                            alert('Cart not saved');
                        }
                    }
                });
            });

           
        });
	</script>
<?=$this->endSection()?>