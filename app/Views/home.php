<?= $this->extend("layouts/app") ?>

<?=$this->section("meta")?>
<?php
foreach ($data['meta_tags']['tags'] as $tag) {
    if ($tag['enabled']) :
        echo "<meta {$tag['type']}='{$tag['type_value']}' content='{$tag['content']}'>";
endif;
    }
?>
<meta name="description" content="This is a test description">
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
<?php if ($data['banner']['enabled']) : ?>
				<section class="section custom-section-background position-relative border-0 overflow-hidden m-0 p-0">
					<div class="position-absolute top-0 left-0 right-0 bottom-0 animated fadeIn" style="animation-delay: 600ms;">
						<div class="background-image-wrapper custom-background-style-1 position-absolute top-0 left-0 right-0 bottom-0 animated kenBurnsToRight" style="background-image: url(<?= base_url($data['banner']['bg_image']) ?>); background-position: center right; animation-duration: 30s;"></div>
					</div>
					<div class="container position-relative py-sm-5 my-5">
						<svg class="custom-svg-1 d-none d-sm-block" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 649 578">
							<path fill="#FFF" d="M-225.5,154.7l358.45,456.96c7.71,9.83,21.92,11.54,31.75,3.84l456.96-358.45c9.83-7.71,11.54-21.92,3.84-31.75
								L267.05-231.66c-7.71-9.83-21.92-11.54-31.75-3.84l-456.96,358.45C-231.49,130.66-233.2,144.87-225.5,154.7z"/>
							<path class="animated customLineAnim" fill="none" stroke="#1C5FA8" stroke-width="1.5" stroke-miterlimit="10" d="M416-21l202.27,292.91c5.42,7.85,3.63,18.59-4.05,24.25L198,603" style="animation-delay: 300ms; animation-duration: 5s;"/>
						</svg>
						<div class="row mb-5 p-relative z-index-1">
							<div class="col-md-8 col-lg-6 col-xl-5">
								<div class="overflow-hidden mb-1">
									<h2 class="font-weight-bold text-color-grey text-4-5 line-height-2 line-height-sm-7 mb-0 appear-animation" data-appear-animation="maskUp" data-appear-animation-delay="800"><?= $data['banner']['intro_text'] ?></h2>
								</div>
								<h1 class="text-color-dark font-weight-bold text-8 pb-2 mb-4 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="1100"><?= $data['banner']['title'] ?></h1>
								<a href="<?= $data['banner']['btn1_link'] ?>" class="btn btn-primary custom-btn-border-radius custom-btn-arrow-effect-1 font-weight-bold text-3 px-5 btn-py-3 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="1300">
                                <?= $data['banner']['btn1_text'] ?> 
									<svg class="ms-2" version="1.1" viewBox="0 0 15.698 8.706" width="17" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
										<polygon stroke="#FFF" stroke-width="0.1" fill="#FFF" points="11.354,0 10.646,0.706 13.786,3.853 0,3.853 0,4.853 13.786,4.853 10.646,8 11.354,8.706 15.698,4.353 "/>
									</svg>
								</a>
								<a href="<?= $data['banner']['btn2_link'] ?>" class="btn btn-info custom-btn-border-radius custom-btn-arrow-effect-1 font-weight-bold text-3 px-5 btn-py-3 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="1300">
                                <?= $data['banner']['btn2_text'] ?>
									<svg class="ms-2" version="1.1" viewBox="0 0 15.698 8.706" width="17" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
										<polygon stroke="#FFF" stroke-width="0.1" fill="#FFF" points="11.354,0 10.646,0.706 13.786,3.853 0,3.853 0,4.853 13.786,4.853 10.646,8 11.354,8.706 15.698,4.353 "/>
									</svg>
								</a>
							</div>
						</div>
					</div>
				</section>
<?php endif; ?>
			
<?php if ($data['top_products']['enabled']) : ?>
				<section class="shop section section-height-4 border-0 m-0">
					<div class="container">
						<div class="row justify-content-center pb-3 mb-4">
							<div class="col-lg-8 text-center">
								<div class="overflow-hidden">
									<h2 class="font-weight-bold text-color-dark line-height-1 mb-0 appear-animation" data-appear-animation="maskUp" data-appear-animation-delay="250"><?= $data['top_products']['title'] ?></h2>
								</div>
								<div class="d-inline-block custom-divider divider divider-primary divider-small my-3">
									<hr class="my-0 appear-animation" data-appear-animation="customLineProgressAnim" data-appear-animation-delay="600">
								</div>
								<p class="font-weight-light text-3-5 mb-0 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="500"><?= $data['top_products']['intro_text'] ?></p>
							</div>
						</div>
						<div class="products row row-gutter-sm mb-4 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="750">
						<?php foreach ($data['top_products']['products'] as $product) : ?>	
                        <div class="col-sm-6 col-lg-3 mb-4 mb-lg-0">
								<div class="product mb-0">
									<div class="product-thumb-info border-0 mb-3">
									<?php if ($product['discount_perc']) : ?>	
                                    <div class="product-thumb-info-badges-wrapper">
											<span class="badge badge-ecommerce text-bg-danger"><?= $product['discount_perc'] ?> OFF</span>
									</div>
									<?php endif; ?>
                                    <div class="addtocart-btn-wrapper">
											<a href="<?= base_url('product/'.$product['slug']) ?>" data-productid="<?= $product['product_id'] ?>" class="text-decoration-none" title="View">
												<i class="fa fa-eye"></i>
											</a>
										</div>
										<a href="<?= base_url('product/'.$product['slug']) ?>">
											<div class="product-thumb-info-image bg-light">
												<img alt="<?= base_url($product['product_name']) ?>" class="img-fluid" src="<?= base_url($product['product_img']) ?>">
											</div>
										</a>
									</div>
									<div class="d-flex justify-content-between">
										<div>
											<a href="product/<?= $product['product_id'] ?>" class="d-block text-uppercase text-decoration-none text-color-default text-color-hover-primary line-height-1 text-0 mb-1"><?= $product['product_cat'] ?></a>
											<h3 class="text-3-5 font-weight-medium font-alternative text-transform-none line-height-3 mb-0"><a href="#" class="text-color-dark text-color-hover-primary"><?= $product['product_name'] ?></a></h3>
										</div>
									</div>
									<div title="Rated <?= $product['product_rate'] ?> out of 5">
										<input type="text" class="d-none" value="<?= $product['product_rate'] ?>" title="" data-plugin-star-rating data-plugin-options="{'displayOnly': true, 'color': 'default', 'size':'xs'}">
									</div>
									<p class="price text-5 mb-3">
										<span class="sale text-color-dark font-weight-medium"><?= $product['sales_price'] ?></span>
										<span class="amount"><?= $product['original_price'] ?></span>
									</p>
								</div>
						</div>
						<?php endforeach; ?>
						</div>
						<div class="row">
							<div class="col text-center">
								<a href="<?= $data['top_products']['btn_link'] ?>" class="btn btn-primary custom-btn-border-radius font-weight-bold text-3 btn-px-5 btn-py-3 appear-animation" data-appear-animation="fadeInUpShorterPlus" data-appear-animation-delay="800"><?= $data['top_products']['btn_text'] ?></a>
							</div>
						</div>
					</div>
				</section>

<?php endif; ?>			
<?php if ($data['blog']['enabled']) : ?>
				<div class="container py-5 my-5">
					<div class="row justify-content-center">
						<div class="col-lg-9 col-xl-8 text-center">
							<div class="overflow-hidden">
								<h2 class="font-weight-bold text-color-dark line-height-1 mb-0 appear-animation" data-appear-animation="maskUp" data-appear-animation-delay="250"><?= $data['blog']['title'] ?></h2>
							</div>
							<div class="d-inline-block custom-divider divider divider-primary divider-small my-3">
								<hr class="my-0 appear-animation" data-appear-animation="customLineProgressAnim" data-appear-animation-delay="600">
							</div>
							<p class="font-weight-light text-3-5 mb-5 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="500"><?= $data['blog']['intro_text'] ?></p>
						</div>
					</div>
					<div class="row row-gutter-sm mb-5 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="750">
					<?php foreach ($data['blog']['titles '] as $title) : ?>	
					<div class="col-sm-6 col-lg-3 text-center mb-4 mb-lg-0">
							<a href="<?= base_url($title['link']) ?>" class="text-decoration-none">
								<div class="custom-thumb-info-style-1 thumb-info thumb-info-no-borders thumb-info-no-borders-rounded thumb-info-lighten">
									<div class="thumb-info-wrapper">
										<img src="<?= base_url($title['blog_image']) ?>" class="img-fluid" alt="">
									</div>
									<h3 class="text-transform-none font-weight-bold text-5 mt-2 mb-0"><?= $title['blog_title'] ?></h3>
									<p class="text-3-5 mb-0"><?= $title['blog_excerpt'] ?> ...</p>
								</div>
							</a>
						</div>
						<?php endforeach; ?>
					</div>
					<div class="row">
						<div class="col text-center">
							<a href="<?= base_url($data['blog']['btn_link']) ?>" class="btn btn-primary custom-btn-border-radius font-weight-bold text-3 btn-px-5 btn-py-3 appear-animation" data-appear-animation="fadeInUpShorterPlus" data-appear-animation-delay="850"><?= $data['blog']['btn_text'] ?></a>
						</div>
					</div>
				</div>
<?php endif; ?>
<?php if($data['testimonials']['enabled']) : ?>
				<section class="section border-0 m-0">
					<div class="container pb-3 my-5">
						<div class="row justify-content-center pb-3 mb-4">
							<div class="col text-center">
								<h2 class="font-weight-bold text-color-dark line-height-1 mb-0"><?= $data['testimonials']['title'] ?></h2>
								<div class="d-inline-block custom-divider divider divider-primary divider-small my-3">
									<hr class="my-0">
								</div>
								<p class="font-weight-bold text-3-5 mb-1"><?= $data['testimonials']['intro_text'] ?></p>
								
							</div>
						</div>
						<div class="row">
							<div class="col">
								<div class="owl-carousel nav-outside nav-style-1 nav-dark nav-arrows-thin nav-font-size-lg custom-carousel-box-shadow-1 mb-0" data-plugin-options="{'responsive': {'0': {'items': 1}, '479': {'items': 1}, '768': {'items': 2}, '979': {'items': 2}, '1199': {'items': 3}}, 'autoplay': true, 'autoplayTimeout': 5000, 'autoplayHoverPause': true, 'dots': false, 'nav': true, 'loop': true, 'margin': 15, 'stagePadding': '75'}">
								<?php foreach($data['testimonials']['reviews'] as $review): ?>	
								<div>
										<div class="card custom-border-radius-1">
											<div class="card-body">
												<div class="custom-testimonial-style-1 testimonial testimonial-style-2 testimonial-with-quotes testimonial-remove-right-quote text-center mb-0">
													<blockquote>
														<p class="text-color-dark text-3 font-weight-light px-0 mb-2"><?= $review['review_text'] ?></p>
													</blockquote>
													<div class="testimonial-author">
														<p><strong class="font-weight-extra-bold"><?= $review['reviewer_name'] ?></strong></p>
													</div>
												</div>
											</div>
										</div>
									</div>
								<?php endforeach; ?>
								</div>
							</div>
						</div>
					</div>
				</section>
<?php endif; ?>
<?php if($data['cta2']['enabled']) : ?>
				<section class="section section-height-3 bg-primary border-0 m-0">
					<div class="container">
						<div class="row align-items-center">
							<div class="col-lg-6 col-xl-7 text-center text-lg-start mb-4 mb-lg-0">
								<h2 class="text-color-light font-weight-medium text-3-5 line-height-2 line-height-sm-1 ls-0 mb-2 mb-lg-2"><?= $data['cta2']['title'] ?></h2>
								<h2 class="text-color-light font-weight-medium text-3-5 line-height-2 line-height-sm-1 ls-0 mb-2 mb-lg-2"><?= $data['cta2']['intro_text'] ?></h2>
								
								
							</div>
							<div class="col-lg-6 col-xl-5">
								<div class="d-flex flex-column flex-lg-row align-items-center justify-content-between">
									<div class="feature-box align-items-center mb-3 mb-lg-0">
										<div class="feature-box-icon bg-transparent">
											<i class="icons icon-phone text-6 text-color-light"></i>
										</div>
									</div>
									<a href="<?= $data['cta2']['btn_link'] ?>" class="btn btn-light btn-outline custom-btn-border-radius font-weight-bold text-color-light text-color-hover-dark bg-color-hover-light btn-px-5 btn-py-3"><?= $data['cta2']['btn_text'] ?></a>
								</div>
							</div>
						</div>
					</div>
				</section>
<?php endif; ?>
<?php if($data['faqs']['enabled']) : ?>					

				<div class="container py-5 my-5">
					<div class="row justify-content-center pb-3 mb-4">
						<div class="col-lg-9 col-xl-8 text-center">
							<div class="overflow-hidden">
								<h2 class="font-weight-bold text-color-dark line-height-1 mb-0 appear-animation" data-appear-animation="maskUp" data-appear-animation-delay="250"><?= $data['faqs']['title'] ?>	</h2>
							</div>
							<div class="d-inline-block custom-divider divider divider-primary divider-small my-3">
								<hr class="my-0 appear-animation" data-appear-animation="customLineProgressAnim" data-appear-animation-delay="650">
							</div>
							<p class="font-weight-light text-3-5 mb-0 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="500"><?= $data['faqs']['intro_text'] ?></p>
						</div>
					</div>
					<div class="row row-gutter-sm">
						<div class="col-md-8 col-lg-9 mb-5 mb-md-0">
							<svg class="custom-svg-2 overflow-visible" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 185 151">
								<g data-plugin-float-element data-plugin-options="{'startPos': 'top', 'speed': 0.1, 'transition': true, 'transitionDuration': 2000, 'isInsideSVG': true}">
									<path fill="#F4F4F4" class="appear-animation" data-appear-animation="fadeInLeftShorterPlus" data-appear-animation-delay="850" d="M34.81,102.81L5.18,73.18c-2.13-2.13-2.13-5.59,0-7.72l29.63-29.63c2.13-2.13,5.59-2.13,7.72,0l29.63,29.63
										c2.13,2.13,2.13,5.59,0,7.72l-29.63,29.63C40.4,104.94,36.94,104.94,34.81,102.81z"/>
								</g>
								<g data-plugin-float-element data-plugin-options="{'startPos': 'top', 'speed': 0.2, 'transition': true, 'transitionDuration': 2500, 'isInsideSVG': true}">
									<path fill="#F4F4F4" class="appear-animation" data-appear-animation="fadeInLeftShorterPlus" data-appear-animation-delay="1000" d="M92.49,35.35L80.4,23.26c-1.75-1.75-1.75-4.59,0-6.34L92.49,4.83c1.75-1.75,4.59-1.75,6.34,0l12.09,12.09
										c1.75,1.75,1.75,4.59,0,6.34L98.83,35.35C97.08,37.1,94.24,37.1,92.49,35.35z"/>
								</g>
								<g data-plugin-float-element data-plugin-options="{'startPos': 'top', 'speed': 0.3, 'transition': true, 'transitionDuration': 3000, 'isInsideSVG': true}">
									<path fill="#F4F4F4" class="appear-animation" data-appear-animation="fadeInLeftShorterPlus" data-appear-animation-delay="1150" d="M129.88,148.41l-43.21-43.21c-2.13-2.13-2.13-5.59,0-7.72l43.21-43.21c2.13-2.13,5.59-2.13,7.72,0l43.21,43.21
										c2.13,2.13,2.13,5.59,0,7.72l-43.21,43.21C135.46,150.54,132.01,150.54,129.88,148.41z"/>
								</g>
							</svg>
							<div class="accordion custom-accordion-style-1 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="750" id="accordion1">
							<?php foreach($data['faqs']['faqs'] as $faq) : ?>	
							<div class="card card-default">
									<div class="card-header" id="<?= 'collapse1Heading'.$faq['id'] ?>">
										<h4 class="card-title m-0">
											<a class="accordion-toggle text-color-dark font-weight-bold collapsed" data-bs-toggle="collapse" data-bs-target="#<?= 'collapse1'.$faq['id'] ?>" aria-expanded="false" aria-controls="<?= 'collapse1'.$faq['id'] ?>">
												<?= $faq['question'] ?>
											</a>
										</h4>
									</div>
									<div id="<?= 'collapse1'.$faq['id'] ?>" class="collapse" aria-labelledby="<?= 'collapse1Heading'.$faq['id'] ?>" data-bs-parent="#accordion1">
										<div class="card-body">
											<p class="mb-0"><?= $faq['answer'] ?></p>
										</div>
									</div>
							</div>
							<?php endforeach; ?>
							</div>
						</div>
						<div class="col-md-4 col-lg-3 text-center text-md-start">
						<?php if($data['cta3']['enabled']) : ?>		
						<div class="appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="1000">
								<h3 class="font-weight-bold text-color-dark text-transform-none text-5-5 mb-3"><?= $data['cta3']['title'] ?></h3>
								<p class="pb-1 mb-2"><?= $data['cta3']['intro_text'] ?></p>
								<a href="<?= $data['cta3']['btn_link'] ?>" class="btn btn-primary custom-btn-border-radius font-weight-bold btn-px-5 py-3 mb-2"><?= $data['cta3']['btn_text'] ?></a>

								<hr class="my-4">
							</div>
						<?php endif; ?>
						<?php if($data['cta4']['enabled']) : ?>
							<div class="appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="1100">
								<h3 class="font-weight-bold text-color-dark text-transform-none text-5-5 pt-2 mb-3"><?= $data['cta4']['title'] ?></h3>
								<p class="pb-1 mb-2"><?= $data['cta4']['intro_text'] ?></p>
								<a href="<?= $data['cta4']['btn_link'] ?>" class="btn btn-primary custom-btn-border-radius font-weight-bold btn-px-5 py-3"><?= $data['cta4']['btn_text'] ?></a>
							</div>
						<?php endif; ?>
						</div>
					</div>
				</div>
<?php endif; ?>
			

				<section class="section bg-transparent position-relative border-0 z-index-1 m-0 p-0">
					
					<svg class="custom-svg-3" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 193 495">
						<path fill="#1C5FA8" d="M193,25.73L18.95,247.93c-13.62,17.39-10.57,42.54,6.82,56.16L193,435.09V25.73z"/>
						<path fill="none" stroke="#FFF" stroke-width="1.5" stroke-miterlimit="10" d="M196,53.54L22.68,297.08c-12.81,18-8.6,42.98,9.4,55.79L196,469.53V53.54z"/>
					</svg>
				</section>

			</div> 
<?=$this->endSection()?>

<?=$this->section("bottomscripts")?>

<?=$this->endSection()?>