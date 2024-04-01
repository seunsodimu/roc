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
<div role="main" class="main">

<section id="bannerSection" class="page-header page-header-modern bg-color-grey page-header-lg">
<div class="position-absolute top-0 left-0 right-0 bottom-0 animated fadeIn" style="animation-delay: 600ms;">
						<div class="background-image-wrapper custom-background-style-2 position-absolute top-0 left-0 right-0 bottom-0 animated kenBurnsToRight" style="background-image: url(<?= base_url($data['post_data']['post']['banner']) ?>); background-position: center right; animation-duration: 30s;"></div>
					</div>
					<div class="container">
						<div class="row">
							<div class="col-md-12 align-self-center p-static order-2 text-center">
								<h1 class="text-light font-weight-bold text-8"><?= $data['post_data']['post']['title'] ?></h1>
								
							</div>
						</div>
					</div>
				</section>

				<div class="container py-4">

					<div class="row">
						<div class="col">
							<div class="blog-posts single-post">

								<article class="post post-large blog-single-post border-0 m-0 p-0">


									<div class="post-date ms-0">
										<span class="day"><?= date('d', strtotime($data['post_data']['post']['created_at'])) ?></span>
										<span class="month"><?= date('M', strtotime($data['post_data']['post']['created_at'])) ?></span>
									</div>

									<div class="post-content ms-0">

										

										<div class="post-meta">
											<span><i class="far fa-user"></i> By <a href="#"><?= $data['post_data']['post']['author'] ?></a> </span>
											<span><i class="far fa-folder"></i> <a href="<?= base_url('blog/category/'.$data['post_data']['post']['category_id']) ?>"><?= $data['post_data']['post']['category'] ?></a> </span>
											
										</div>

										<?= $data['post_data']['post']['content'] ?>
										<div class="post-block mt-5 post-share">
											<h4 class="mb-3">Share this Post</h4>

											<!-- Go to www.addtoany.com to customize -->
											<!-- AddToAny BEGIN -->
											<div class="a2a_kit a2a_kit_size_32 a2a_default_style">
											    <a class="a2a_dd" href="https://www.addtoany.com/share"></a>
											    <a class="a2a_button_facebook"></a>
											    <a class="a2a_button_x"></a>
											    <a class="a2a_button_copy_link"></a>
											</div>
											<script async src="https://static.addtoany.com/menu/page.js"></script>
											<!-- AddToAny END -->

										</div>
									</div>
								</article>

							</div>
						</div>
					</div>

				</div>

			</div>
<?=$this->endSection()?>

<?=$this->section("bottomscripts")?>

<?=$this->endSection()?>