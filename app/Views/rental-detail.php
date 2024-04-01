<?= $this->extend("layouts/app") ?>

<?=$this->section("meta")?>
<?php
if ($data['meta_tags']) :
foreach ($data['meta_tags']['tags'] as $tag) {
    if ($tag['enabled']) :
        echo "<meta {$tag['type']}='{$tag['type_value']}' content='{$tag['content']}'>";
endif;
    }
endif;
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

				

				<div class="container pt-3 pb-2">

					<div class="row pt-2">
						<?php include('partials/member-sidebar.php'); ?>
						<div class="col-lg-9">
        <div class="col">
            <h2 class="font-weight-bold text-6 mb-0"><?= $data['page_title']['title'] ?></h2>
        </div>
		<div class="row justify-content-center">
						<div class="col-lg-8">
							<div class="d-flex flex-column flex-md-row justify-content-between py-3 px-4 my-4">
								<div class="text-center">
									<span>
										Order Number <br>
										<a href="<?= base_url('my-transactions/'.$data['rental']->order_id) ?>" class="text-color-dark"><?= $data['rental']->order_id ?></a>
									</span>
								</div>
								<div class="text-center mt-4 mt-md-0">
									<span>
										Rent Start Date <br>
										<strong class="text-color-dark"><?= $data['rental']->rent_start_date ?></strong>
									</span>
								</div>
								<div class="text-center mt-4 mt-md-0">
									<span>
										Rent End Date <br>
										<strong class="text-color-dark"><?= $data['rental']->rent_end_date ?></strong>
									</span>
								</div>
								<div class="text-center mt-4 mt-md-0">
									<span>
										Status <br>
										<strong class="text-color-dark"><?= $data['rental']->status ?></strong>
									</span>
								</div>
							</div>
							
							
						</div>
					</div>
					</div>

				</div>

			</div>
<?=$this->endSection()?>

<?=$this->section("bottomscripts")?>

<?=$this->endSection()?>