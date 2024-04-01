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
						<div class="background-image-wrapper custom-background-style-2 position-absolute top-0 left-0 right-0 bottom-0 animated kenBurnsToRight" style="background-image: url(<?= base_url($data['banner']['bg_image']) ?>); background-position: center right; animation-duration: 30s;"></div>
					</div>
					<div class="container">
						<div class="row">
							<div class="col-md-12 align-self-center p-static order-2 text-center">
								<h1 class="font-weight-bold text-light"><?= $data['banner']['title'] ?></h1>
                                <p class="text-light position-relative"><?= $data['banner']['intro_text'] ?></p>
							</div>
						</div>
					</div>
				</section>

			<div class="container pt-3 pb-2">

					<div class="row pt-2">

						<div class="col">

							<h2 class="font-weight-normal text-7 mb-2"><?= $data['page_body']['title'] ?></h2>
							<p class="lead"><?= $data['page_body']['text'] ?></p>

						</div>

					</div>

			</div>

<?php if ($data['videos']['enabled']): ?>
    <section id="videoSection" class="section section-height-1 mt-0 border-0 bg-color-white">
    <div class="row">
        <?php foreach ($data['videos']['videos'] as $video) : ?>
										<div class="col-lg-6 mb-6 mb-lg-0">
											<div class="ratio ratio-4x3 mb-0">
												<iframe frameborder="0" allowfullscreen="" src="//www.youtube.com/embed/<?= $video['code'] ?>?showinfo=0&amp;wmode=opaque"></iframe>
											</div>
											<h4><?= $video['video_title'] ?></h4>
										</div>
        <?php endforeach; ?>
									</div>
    </section>

<?php endif; ?>

<?php if ($data['contact_form']['enabled']): ?>
    <section id="contactSection" class="section section-height-1 mt-0 border-0 bg-color-white">
    <div class="container">

					<div class="row">
						<div class="col">
							<form class="contact-form-recaptcha-v3" action="php/contact-form-recaptcha-v3.php" method="POST">
								<div class="contact-form-success alert alert-success d-none mt-4">
									<strong>Success!</strong> Your message has been sent to us.
								</div>

								<div class="contact-form-error alert alert-danger d-none mt-4">
									<strong>Error!</strong> There was an error sending your message.
									<span class="mail-error-message text-1 d-block"></span>
								</div>

								<div class="row">
									<div class="form-group col-lg-6">
										<label class="form-label mb-1 text-2 text-dark">First Name</label>
										<input type="text" value="" data-msg-required="Please enter your first name." maxlength="100" class="form-control text-3 h-auto py-2" name="fname" required>
									</div>
									<div class="form-group col-lg-6">
										<label class="form-label mb-1 text-2 text-dark">Last Name</label>
										<input type="text" value="" data-msg-required="Please enter your last name." maxlength="100" class="form-control text-3 h-auto py-2" name="lname" required>
									</div>
									<div class="form-group col-lg-6">
										<label class="form-label mb-1 text-2 text-dark">Email Address</label>
										<input type="email" value="" data-msg-required="Please enter your email address." data-msg-email="Please enter a valid email address." maxlength="100" class="form-control text-3 h-auto py-2" name="email" required>
									</div>
									<div class="form-group col-lg-6">
										<label class="form-label mb-1 text-2 text-dark">Phone Number</label>
										<input type="tel" value="" data-msg-required="Please enter your phone number." data-msg-email="Please enter a valid phone number." maxlength="100" class="form-control text-3 h-auto py-2" name="phone">
									</div>
								</div>
								<div class="row">
									<div class="form-group col">
										<label class="form-label mb-1 text-2 text-dark">Subject</label>
										<input type="text" value="" data-msg-required="Please enter the subject." maxlength="100" class="form-control text-3 h-auto py-2" name="subject" required>
									</div>
								</div>
								<div class="row">
									<div class="form-group col">
										<label class="form-label mb-1 text-2 text-dark">Message</label>
										<textarea maxlength="5000" data-msg-required="Please enter your message." rows="5" class="form-control text-3 h-auto py-2" name="message" required></textarea>
									</div>
								</div>
								<div class="row">
									<div class="form-group col">
										<input type="submit" value="Send Message" class="btn btn-primary btn-modern" data-loading-text="Loading...">
									</div>
								</div>
							</form>

						</div>
					</div>
				</div>
    </section>
<?php endif; ?>


<?php if ($data['product_carousel']['enabled']): ?>
    <section id="productcarouselSection" class="section section-height-4 mt-0 mb-3 border-0">
    <div id="examples" class="container py-2">

<div class="row">
    <div class="col">
        <h4><?= $data['product_carousel']['title'] ?></h4>
        <div class="owl-carousel owl-theme stage-margin" data-plugin-options="{'items': 3, 'margin': 40, 'loop': false, 'nav': true, 'dots': false, 'stagePadding': 10}">
        <?php foreach ($data['product_carousel']['products'] as $product) : ?>
        <div>
                <img alt="$product['product_name']" class="img-fluid rounded" src="<?= base_url($product['product_image']) ?>">
                <h4 class="font-weight-bold text-4 mt-3 mb-1 center"><?= $product['product_name'] ?></h4>
        </div>
        <?php endforeach; ?>
        </div>
    </div>
</div>
</div>
    </section>
<?php endif; ?>
			</div>
<?=$this->endSection()?>

<?=$this->section("bottomscripts")?>

<?=$this->endSection()?>