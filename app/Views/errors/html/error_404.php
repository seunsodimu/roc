<?= $this->extend("layouts/app") ?>

<?=$this->section("meta")?>

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
						<div class="background-image-wrapper custom-background-style-2 position-absolute top-0 left-0 right-0 bottom-0 animated kenBurnsToRight" style="background-image: url(<?= base_url('assets/img/Roc_Paddleboards.webp') ?>); background-position: center right; animation-duration: 30s;"></div>
					</div>
					<div class="container">
						<div class="row">
							<div class="col-md-12 align-self-center p-static order-2 text-center">
								<h1 class="text-light font-weight-bold text-8">404 - Page Not Found</h1>
								
							</div>
						</div>
					</div>
				</section>

				<div class="container py-4">

					<div class="row">
						<div class="col">
							<div class="blog-posts single-post">

                            <?php if (ENVIRONMENT !== 'production') : ?>
                                <center>
                                    <h2 class="text-blue"><?= $title ?></h2>
                <p class="text-dark"><?= $message ?></p>
                                </center>
            <?php else : ?>
                <?= lang('Errors.sorryCannotFind') ?>
            <?php endif; ?>

							</div>
						</div>
					</div>

				</div>

			</div>
<?=$this->endSection()?>

<?=$this->section("bottomscripts")?>

<?=$this->endSection()?>