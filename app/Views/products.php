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
        <div class="col-lg-3 order-2 order-lg-1">
        <?php include('partials/product_sidebar.php'); ?>
        </div>
        <div class="col-lg-9 order-1 order-lg-2">
<div>
<h2><?= $data['page_title']['title'] ?></h2>
<p><?= $data['page_body']['text'] ?></p>
</div>
            <div class="masonry-loader masonry-loader-showing">
                <div class="row products product-thumb-info-list" data-plugin-masonry data-plugin-options="{'layoutMode': 'fitRows'}">
<?php foreach ($data['products'] as $product) : ?>
                    <div class="col-sm-6 col-lg-4">
                        <div class="product mb-0">
                            <div class="product-thumb-info border-0 mb-3">

                                <div class="product-thumb-info-badges-wrapper">
<?php if ($product['discount_perc'] > 0) : ?>
<span class="badge badge-ecommerce text-bg-danger"><?= $product['discount_perc'] ?>% OFF</span>
<?php endif; ?>
                                </div>
                                <div class="addtocart-btn-wrapper">
                                    <a href="<?= base_url('product/'.$product['slug']) ?>" class="text-decoration-none addtocart-btn" title="View">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                </div>
                                <a href="<?= base_url('product/'.$product['slug']) ?>">
                                    <div class="product-thumb-info-image product-thumb-info-image-effect">
                                        <img alt="" class="img-fluid" src="<?= base_url($product['display_image']) ?>">

                                        <img alt="" class="img-fluid" src="<?= base_url($product['display_image']) ?>">

                                    </div>
                                </a>
                            </div>
                            <div class="d-flex justify-content-between">
                                <div>
                                    <a href="<?= base_url('products/collections/'.$product['collection_slug']) ?>" class="d-block text-uppercase text-decoration-none text-color-default text-color-hover-primary line-height-1 text-0 mb-1"><?= $product['collection_name'] ?></a>
                                    <h3 class="text-3-5 font-weight-medium font-alternative text-transform-none line-height-3 mb-0"><a href="<?= base_url('product/'.$product['slug']) ?>" class="text-color-dark text-color-hover-primary"><?= $product['name'] ?></a></h3>
                                </div>
                                
                            </div>
                            <div title="Rated 5 out of 5">
                                <input type="text" class="d-none" value="5" title="" data-plugin-star-rating data-plugin-options="{'displayOnly': true, 'color': 'default', 'size':'xs'}">
                            </div>
                            <p class="price text-5 mb-3">
                                
                                <span class="sale text-color-dark font-weight-semi-bold">$<?= $product['sales_price'] ?></span>
                                <?php if ($product['discount_perc'] > 0) :
                                    $original_price = "$".round($product['sales_price'] + ($product['sales_price'] * $product['discount_perc'] / 100), 2);
                                    ?>
                                <span class="amount"><?= $original_price ?></span>
                                <?php endif; ?>
                            </p>
                        </div>
                    </div>
<?php endforeach; ?>

                </div>
                <!-- <div class="row mt-4">
                    <div class="col">
                        <ul class="pagination float-end">
                            <li class="page-item"><a class="page-link" href="#"><i class="fas fa-angle-left"></i></a></li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#"><i class="fas fa-angle-right"></i></a></li>
                        </ul>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
</div>

</div>
<?=$this->endSection()?>

<?=$this->section("bottomscripts")?>

<?=$this->endSection()?>