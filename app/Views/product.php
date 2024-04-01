<?= $this->extend("layouts/app") ?>

<?=$this->section("meta")?>
<?php
foreach ($data['meta_tags']['tags'] as $tag) {
    if ($tag['enabled']) :
        echo "<meta {$tag['type']}='{$tag['type_value']}' content='{$tag['content']}'>";
endif;
    }
?>
<?=$this->endSection()?>

<?=$this->section("topscripts")?>
<script>
//product variables
var product_id = <?= $data['product']['id'] ?>;
var product_name = "<?= $data['product']['name'] ?>";
var product_price = <?= $data['product']['sales_price'] ?>;
var product_image = "<?= base_url($data['product']['display_image']) ?>";
var productVariantID;
var productSku;
var product_extra;
	</script>
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
<div role="main" class="main shop pt-4">

				<div class="container">

					<div class="row">
						<div class="col">
							<ul class="breadcrumb breadcrumb-style-2 d-block text-4 mb-4">
								<li><a href="<?= base_url('products/collections/'.$data['product']['collection_slug']) ?>" class="text-color-default text-color-hover-primary text-decoration-none"><?= $data['product']['collection_name'] ?></a></li>
								<li><?= $data['product']['name'] ?></li>
							</ul>
						</div>
					</div>
					<div class="row">
						<div id="listErrors"></div>
						<div class="col-md-5 mb-5 mb-md-0">

                        <div class="thumb-gallery-wrapper">
								<div class="thumb-gallery-detail owl-carousel owl-theme manual nav-inside nav-style-1 nav-dark mb-3">
									<div>
										<img alt="<?= $data['product']['name'] ?>" class="img-fluid" src="<?= base_url($data['product']['display_image']) ?>" data-zoom-image="<?= base_url($data['product']['display_image']) ?>">
									</div>
                                    <?php foreach ($data['images'] as $image) : ?>
                                    <div>
                                        <img id="firstImage" alt="<?= $data['product']['name'] ?>" class="img-fluid" src="<?= base_url($image['image']) ?>" data-zoom-image="<?= base_url($image['image']) ?>">
                                    </div>
                                    <?php endforeach; ?>
								</div>
								<div class="thumb-gallery-thumbs owl-carousel owl-theme manual thumb-gallery-thumbs">
									<div class="cur-pointer">
										<img id="firstThumbnail" alt="" class="img-fluid" src="<?= base_url($data['product']['display_image']) ?>">
									</div>
                                    <?php foreach ($data['images'] as $image) : ?>
                                    <div class="cur-pointer">
                                        <img alt="" class="img-fluid" src="<?= base_url($image['image']) ?>">
                                    </div>
                                    <?php endforeach; ?>
								</div>
							</div>

						</div>

						<div class="col-md-7">

							<div class="summary entry-summary position-relative">

								<h1 class="mb-0 font-weight-bold text-7"><?= $data['product']['name'] ?></h1>

								<div class="pb-0 clearfix d-flex align-items-center">
									<div title="Rated 3 out of 5" class="float-start">
										<input type="text" class="d-none" value="3" title="" data-plugin-star-rating data-plugin-options="{'displayOnly': true, 'color': 'primary', 'size':'xs'}">
									</div>

								</div>

								<div class="divider divider-small">
									<hr class="bg-color-grey-400">
								</div>

								<p class="price mb-3">
									<span id="salesPrice" class="sale text-color-dark">$<?= $data['product']['sales_price'] ?> <span class="text-color-grey">/ per day</span></span>
                                   
								</p>

								<p class="text-3-5 mb-3"><?php
                                $description = $data['product']['description'];
                                if (strlen($description) > 200) {
                                    echo substr($description, 0, 200)."...";
                                } else {
                                    echo $description;
                                }
                                ?></p>

								<ul class="list list-unstyled text-2">
									<li class="mb-0">AVAILABILITY: <?= ($data['product']['availability'] == "in_stock") ? "<strong class='text-color-dark' id='prodAvailability'>Available</strong>" : "<strong class='text-secondary' id='prodAvailability'>Sold Out</strong>" ?></li>
									<li class="mb-0">SKU: <strong class="text-color-dark" id="productSku"><?= $data['product']['sku'] ?></strong></li>
								</ul>

								<form enctype="multipart/form-data" method="post" class="cart" action="">
								<div class="row">
														<div class="form-group col">
														<?php if (count($data['variants']) > 0) : ?>
															<?php foreach ($data['variants'] as $variant) : ?>
																<div class="form-check form-check-inline">
																<label class="form-check-label">
																	<input data-variant-name="<?= $variant['variant_name'] ?>" class="form-check-input variant-radio" type="radio" name="variant" data-msg-required="Please select an option." id="variant<?= $variant['id'] ?>" value="<?= $variant['id'] ?>" required> <?= $variant['variant_name'] ?>
																</label>
															</div>
																<?php endforeach; ?>
														<?php endif; ?>
														</div>
													</div>	
										<table class="table table-borderless" style="max-width: 300px;" id="colorTable">
										<tbody>
											<tr>
												<td class="align-middle text-2 px-0 py-2">COLOR:</td>
												<td class="px-0 py-2">
													<div class="custom-select-1">
														<select name="color" class="form-control form-select text-1 h-auto py-2" id="colorVariants">
															
														</select>
													</div>
												</td>
											</tr>
											<tr id="durationTr">
												<td class="align-middle text-2 px-0 py-2">DURATION:</td>
												<td class="px-0 py-2">
													<div class="custom-select-1">
														<select name="duration" class="form-control form-select text-1 h-auto py-2" id="rentDuration">
															<option value="3">3 Days</option>
															<option value="7">7 Days</option>
															<option value="30">30 Days</option>
														</select>
													</div>
												</td>
											</tr>
											<tr id="startTr">
												<td class="align-middle text-2 px-0 py-2">START:</td>
												<td class="px-0 py-2">
													<div class="custom-select-1">
														<input type="date" value="<?= date('Y-m-d') ?>" min="<?= date('Y-m-d') ?>" name="start_date" class="form-control form-select text-1 h-auto py-2" id="rentStartDate">
													</div>
												</td>
											</tr>
										</tbody>
									</table>
									<hr>
								
							
									<div class="quantity quantity-lg" id="qtyDiv">
										<input type="button" class="minus text-color-hover-light bg-color-hover-primary border-color-hover-primary" value="-">
										<input type="text" class="input-text qty text" title="Qty" value="1" name="quantity" min="1" step="1">
										<input type="button" class="plus text-color-hover-light bg-color-hover-primary border-color-hover-primary" value="+">
									</div>
									<button id="addToCartBtn" type="submit" class="btn btn-dark btn-modern text-uppercase bg-color-hover-primary border-color-hover-primary">Add to cart</button>
									<hr>
								</form>

								<div class="d-flex align-items-center">
									<ul class="social-icons social-icons-medium social-icons-clean-with-border social-icons-clean-with-border-border-grey social-icons-clean-with-border-icon-dark me-3 mb-0">
										<!-- Facebook -->
										<li class="social-icons-facebook">
											<a href="http://www.facebook.com/sharer.php?u=<?= base_url('product/'.$data['product']['slug']) ?>" target="_blank" data-bs-toggle="tooltip" data-bs-animation="false" data-bs-placement="top" title="Share On Facebook">
												<i class="fab fa-facebook-f"></i>
											</a>
										</li>
										<!-- Twitter -->
										<li class="social-icons-twitter">
											<a href="https://twitter.com/share?url=<?= base_url('product/'.$data['product']['slug']) ?>&amp;text=<?= $data['product']['name'] ?>&amp;hashtags=rocoutdoors,paddleboards" target="_blank" data-bs-toggle="tooltip" data-bs-animation="false" data-bs-placement="top" title="Share On Twitter">
												<i class="fab fa-twitter"></i>
											</a>
										</li>
										<!-- Email -->
										<li class="social-icons-email">
											<a href="mailto:?Subject=<?= $data['product']['name'] ?>%20onRoc%20Outdoors&amp;Body=I%20saw%20this%20<?= $data['product']['name'] ?>%20and%20thought%20of%20you!%20 <?= base_url('product/'.$data['product']['slug']) ?>" data-bs-toggle="tooltip" data-bs-animation="false" data-bs-placement="top" title="Share By Email">
												<i class="far fa-envelope"></i>
											</a>
										</li>
									</ul>
								</div>

							</div>

						</div>
					</div>

					<div class="row mb-4">
						<div class="col">
							<div id="description" class="tabs tabs-simple tabs-simple-full-width-line tabs-product tabs-dark mb-2">
								<ul class="nav nav-tabs justify-content-start">
									<li class="nav-item"><a class="nav-link active font-weight-bold text-3 text-uppercase py-2 px-3" href="#productDescription" data-bs-toggle="tab">Description</a></li>
									<li class="nav-item"><a class="nav-link font-weight-bold text-3 text-uppercase py-2 px-3" href="#includedItems" data-bs-toggle="tab">Included Items</a></li>
									<li class="nav-item"><a class="nav-link nav-link-reviews font-weight-bold text-3 text-uppercase py-2 px-3" href="#techSpecs" data-bs-toggle="tab">Technical Specifications</a></li>
								</ul>
								<div class="tab-content p-0">
									<div class="tab-pane px-0 py-3 active" id="productDescription">
                                    <?= $data['product']['description'] ?>
									</div>
									<div class="tab-pane px-0 py-3" id="includedItems">
                                    <?= $data['product']['included_items'] ?>
									</div>
									<div class="tab-pane px-0 py-3" id="techSpecs">
                                        <table class="table table-striped m-0">
											<tbody>
												<tr>
													<th class="border-top-0">
														Dimensions:
													</th>
													<td class="border-top-0">
                                                    <?= $data['product']['length'].' X '.$data['product']['breadth'].' X '.$data['product']['height'] ?>
													</td>
												</tr>
												<tr>
													<th>
														Weight:
													</th>
													<td>
														<?= $data['product']['weight'] ?>lbs - total package
													</td>
												</tr>
												<tr>
													<th>
														Material:
													</th>
													<td>
                                                    <?= $data['product']['material'] ?> 
													</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col">
							<h4 class="font-weight-semibold text-4 mb-3">RELATED PRODUCTS</h4>
							<hr class="mt-0">
							<div class="products row">
								<div class="col">
									<div class="owl-carousel owl-theme nav-style-1 nav-outside nav-outside nav-dark mb-0" data-plugin-options="{'loop': false, 'autoplay': false, 'items': 4, 'nav': true, 'dots': false, 'margin': 20, 'autoplayHoverPause': true, 'autoHeight': true, 'stagePadding': '75', 'navVerticalOffset': '50px'}">
<?php foreach ($data['related_products'] as $rproduct) : ?>
										<div class="product mb-0">
											<div class="product-thumb-info border-0 mb-3">

												<a href="<?= base_url('product/'.$rproduct['slug']) ?>">
													<div class="product-thumb-info-image">
														<img alt="" class="img-fluid" src="<?= base_url($rproduct['display_image']) ?>">

													</div>
												</a>
											</div>
											<div class="d-flex justify-content-between">
												<div>
													<a href="<?= base_url('products/collections/'.$rproduct['collection_slug']) ?>" class="d-block text-uppercase text-decoration-none text-color-default text-color-hover-primary line-height-1 text-0 mb-1"><?= $rproduct['category_name'] ?></a>
													<h3 class="text-3-5 font-weight-medium font-alternative text-transform-none line-height-3 mb-0"><a href="<?= base_url('product/'.$rproduct['slug']) ?>" class="text-color-dark text-color-hover-primary"><?= $rproduct['name'] ?></a></h3>
												</div>
												
											</div>
											<div title="Rated 5 out of 5">
												<input type="text" class="d-none" value="5" title="" data-plugin-star-rating data-plugin-options="{'displayOnly': true, 'color': 'default', 'size':'xs'}">
											</div>
											<p class="price text-5 mb-3">
                                                <?php if ($rproduct['discount_perc'] > 0) :
                                                $original_price = "$".round($rproduct['sales_price'] + ($rproduct['sales_price'] * $rproduct['discount_perc'] / 100), 2);
                                                ?>
												<span class="sale text-color-dark font-weight-semi-bold"><?= $original_price ?></span>
                                                <?php endif; ?>
												<span class="amount"><?= $rproduct['sales_price'] ?></span>
											</p>
										</div>
<?php endforeach; ?>
									</div>
								</div>
							</div>
						</div>
					</div>

					<hr class="my-5">

					
				</div>
				<div class="modal fade" id="defaultModal" tabindex="-1" role="dialog" aria-labelledby="defaultModalLabel" aria-hidden="true">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<h4 class="modal-title" id="defaultModalLabel"></h4>
													<button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true">&times;</button>
												</div>
												<div class="modal-body" id="msg-modal">
													</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
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
		$('#colorTable').hide();
		//on variant-radio click get id remove "variant" from selected radio id, use ajax to get colors for that variant
		$('.variant-radio').on('click', function() {
			var variant_id = $(this).attr('id').replace('variant', '');
			//get data-variant-name attribute from selected radio
			var variant_name = $(this).data('variant-name');console.log(variant_name);
			product_extra = variant_name;
			$.ajax({
				url: '<?= base_url('get-variant-colors') ?>',
				type: 'POST',
				data: {
					variant_id: variant_id
				},
				success: function(response) {
					productVariantID = variant_id;
					$('#colorTable').show();
					var colors = JSON.parse(response);
					$('#colorVariants').empty();
					$.each(colors, function(index, value) {
						$('#colorVariants').append('<option value="'+value.id+'">'+value.color+'</option>');
					});
					if(colors[0].status == "available") {
					//change sku to sku from first color
					$('#productSku').text(colors[0].sku);
					$('#salesPrice').html('<span class="sale text-color-dark">$'+colors[0].price+'</span>');
					productSku = colors[0].sku;
					//change current image to first image of first color
					$('#firstImage').attr('src', '<?= base_url() ?>'+colors[0].image);
					$('#firstImage').attr('data-zoom-image', '<?= base_url() ?>'+colors[0].image);
					$('#firstThumbnail').attr('src', '<?= base_url() ?>'+colors[0].image);
					$('#firstThumbnail').attr('data-zoom-image', '<?= base_url() ?>'+colors[0].image);
					productSku = colors[0].sku;
					product_image = '<?= base_url() ?>'+colors[0].image;
					product_price = colors[0].price;
					product_color_name = colors[0].color;
					product_color_id = colors[0].id;	
					} else {
						$('#prodAvailability').html('<strong class="text-secondary">Sold Out</strong>');
						$('#durationTr').hide();
						$('#startTr').hide();
						$('#qtyDiv').hide();
						$('#addToCartBtn').prop('disabled', true);
					}
				}
			});
		});

	//on color change get sku from selected color
	$('#colorVariants').on('change', function() {
		var color_id = $(this).val();
		$.ajax({
			url: '<?= base_url('variant-color') ?>',
			type: 'GET',
			data: {
				id: color_id
			},
			success: function(response) {
				var color = JSON.parse(response);
				$('#productSku').text(color.sku);
				//change current image to first image of selected color
				$('#firstImage').attr('src', '<?= base_url() ?>'+color.image);
				$('#firstImage').attr('data-zoom-image', '<?= base_url() ?>'+color.image);
				$('#firstThumbnail').attr('src', '<?= base_url() ?>'+color.image);
				$('#firstThumbnail').attr('data-zoom-image', '<?= base_url() ?>'+color.image);

				if(color.status == "available") {
					$('#salesPrice').html('<span class="sale text-color-dark">$'+color.price+'</span>');
					product_price = <?= $data['product']['sales_price'] ?>;
					productSku = color.sku;
					product_image = '<?= base_url() ?>'+color.image;
					$('#prodAvailability').html('<strong class="text-color-dark">Available</strong>');
					$('#durationTr').show();
					$('#startTr').show();
					$('#qtyDiv').show();
					//enable add to cart button if product is not available
					$('#addToCartBtn').prop('disabled', false);
				} else {
					$('#prodAvailability').html('<strong class="text-secondary">Sold Out</strong>');
					$('#durationTr').hide();
					$('#startTr').hide();
					$('#qtyDiv').hide();
					$('#addToCartBtn').prop('disabled', true);

				
			}
		}
		});
	});

	//on add to cart button click
	$('#addToCartBtn').on('click', function() {
		event.preventDefault();
		var color_id = $('#colorVariants').val();
		var color_name = $('#colorVariants option:selected').text();
		var duration = $('#rentDuration').val();
		var start_date = $('#rentStartDate').val();
		var qty = $('input[name="quantity"]').val();
		$.ajax({
			url: '<?= base_url('cart/add') ?>',
			type: 'POST',
			data: {
				product_id: product_id,
				product_name: product_name,
				product_price: product_price,
				product_image: product_image,
				product_variant_id: productVariantID,
				product_color_id: product_color_id,
				product_color_name: product_color_name,
				rent_duration: duration,
				rent_start_date: start_date,
				product_qty: qty,
				product_sku: productSku,
				product_extra: product_extra
			},
			success: function(response) {
				response = JSON.parse(response);
				if(response.msgtype == "success") {
					alert(response.msg);
				} else {
					console.log(response);
					$('#listErrors').html('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'+response.msgtype+'</div>');
			
				}
			}
		});
	});
	});
	</script>
<?=$this->endSection()?>