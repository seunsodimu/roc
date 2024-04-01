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

					<div class="row justify-content-center">
						<div class="col-lg-8">
							<ul class="breadcrumb breadcrumb-dividers-no-opacity font-weight-bold text-6 justify-content-center my-5">
								
								<li class="text-transform-none text-color-dark">
									<?= (session()->get('msgtype') == 'success') ? '<span class="text-color-primary">Order Complete</span>' : '<span class="text-color-danger">Order Not Completed</span>' ?>
								</li>
							</ul>
						</div>
					</div>

					<div class="row justify-content-center">
						<div class="col-lg-8">
                            <?php $border = (session()->get('msgtype') == 'success') ? 'border-color-success' : 'border-color-danger'; ?>
							<div class="card border-width-3 border-radius-0 <?= $border ?> mb-4">
								<div class="card-body text-center">
									<p class="text-color-dark text-4-5 mb-0"> <?= session()->get('msg') ?></p>
								</div>
							</div>
                            <?php if (session()->get('msgtype') == 'success') : ?>
							<div class="d-flex flex-column flex-md-row justify-content-between py-3 px-4 my-4">
								<div class="text-center">
									<span>
										Order Number <br>
										<strong class="text-color-dark"><?= $data['order_id'] ?></strong>
									</span>
								</div>
								<div class="text-center mt-4 mt-md-0">
									<span>
										Date <br>
										<strong class="text-color-dark"><?= $data['order_date'] ?></strong>
									</span>
								</div>
								<div class="text-center mt-4 mt-md-0">
									<span>
										Email <br>
										<strong class="text-color-dark"><?= $data['order_email'] ?></strong>
									</span>
								</div>
								<div class="text-center mt-4 mt-md-0">
									<span>
										Total <br>
										<strong class="text-color-dark">$<?= $data['order_total'] ?></strong>
									</span>
								</div>
							</div>
							<div class="card border-width-3 border-radius-0 border-color-hover-dark mb-4">
								<div class="card-body">
									<h4 class="font-weight-bold text-uppercase text-4 mb-3">Your Order</h4>
									<table class="shop_table cart-totals mb-0">
										<tbody>
                                        <tr>
												<td colspan="2" class="border-top-0">
													<strong class="text-color-dark">Product</strong>
												</td>
										</tr>
                                            <?php foreach ($data['order_data'] as $item) : ?>
                                                <tr>
                                                    <td class="border-top-0">
                                                        <strong class="d-block text-color-dark line-height-1 font-weight-semibold"><?= $item['product_name'] ?></strong>
                                                        <span class="text-1">
                                                            <?= $item['color_name'] ?>
                                                            <?= ($item['product_extra']) ? ' - ' . $item['product_extra'] : '' ?>
                                                        </span>
                                                        <span class="text-1">Rental Duration: <?= $item['rent_duration'] ?> days</span>
                                                    </td>
                                                    <td class="text-end align-top">
                                                        <span class="amount font-weight-medium text-color-grey">$<?= $item['subtotal'] ?></span>
                                                    </td>
                                                </tr>
											
                                            <?php endforeach; ?>
										</tbody>
									</table>
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
	});
	</script>
<?=$this->endSection()?>