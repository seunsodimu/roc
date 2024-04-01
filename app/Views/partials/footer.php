<footer id="footer" class="border-0 mt-0">
				
				<hr class="bg-light opacity-2 my-0">
				<div class="container pb-5">
					<div class="row text-center text-md-start py-4 my-5">
						<div class="col-md-6 col-lg-3 align-self-center text-center text-md-start text-lg-center mb-5 mb-lg-0">
							<a href="<?= base_url() ?>" class="text-decoration-none">
								<img src="<?= base_url() ?>assets/img/roc-sup-q600x_210x_light.png" class="img-fluid" alt="" />
							</a>
						</div>
						<div class="col-md-6 col-lg-3 mb-5 mb-lg-0">
							<h5 class="text-transform-none font-weight-bold text-color-light text-4-5 mb-4">About Us</h5>
							<ul class="list list-unstyled">
								<li class="pb-1 mb-2">
									<span class="d-block font-weight-semibold line-height-1 text-color-grey text-3-5">ADDRESS</span> 
									<span class="font-weight-light text-3-5 text-color-light">Clearwater, FL</span>
									<a href="#" class="text-color-light custom-text-underline-1 font-weight-medium text-3-5">GET DIRECTIONS</a>
								</li>
								<li class="pb-1 mb-2">
									<span class="d-block font-weight-semibold line-height-1 text-color-grey text-3-5 mb-1">PHONE</span>
									<ul class="list list-unstyled font-weight-light text-3-5 mb-0">
										<li class="text-color-light line-height-3 mb-0">
											Sales: <a href="#" class="text-decoration-none text-color-light text-color-hover-default">+123 4567 890</a>
										</li>
										<li class="text-color-light line-height-3 mb-0">
											Services: <a href="#" class="text-decoration-none text-color-light text-color-hover-default">+123 4567 890</a>
										</li>
									</ul>
								</li>
								<li class="pb-1 mb-2">
									<span class="d-block font-weight-semibold line-height-1 text-color-grey text-3-5">EMAIL</span>
									<a href="#" class="text-decoration-none font-weight-light text-3-5 text-color-light text-color-hover-default">rentals@rocsupco.com</a>
								</li>
							</ul>
							<ul class="social-icons social-icons-medium">
								<li class="social-icons-instagram">
									<a href="https://www.instagram.com/rocpaddleboards/" class="no-footer-css" target="_blank" title="Instagram"><i class="fab fa-instagram"></i></a>
								</li>
								<li class="social-icons-youtube mx-2">
									<a href="http://www.youtube.com/@rocpaddleboards" class="no-footer-css" target="_blank" title="YouTube"><i class="fab fa-youtube"></i></a>
								</li>
								<li class="social-icons-facebook">
									<a href="https://www.facebook.com/people/ROC-SUP-Co/100088520862379/" class="no-footer-css" target="_blank" title="Facebook"><i class="fab fa-facebook-f"></i></a>
								</li>
							</ul>
						</div>
						<?php if (env('CI_ENVIRONMENT') == 'development') : ?>
						<div class="col-md-6 col-lg-2 mb-5 mb-md-0">
							<h5 class="text-transform-none font-weight-bold text-color-light text-4-5 mb-4">Get Started</h5>
							<ul class="list list-unstyled mb-0">
								<li class="mb-0"><a href="<?= base_url('products') ?>">Rent Paddle Boards</a></li>
								<li class="mb-0"><a href="<?= base_url('products/collections/10-6') ?>">Rent Paddle Boards & Accessories Bundle</a></li>
								<li class="mb-0"><a href="<?= base_url('products/collections/fins') ?>">Rent Accessories</a></li>
								<li class="mb-0"><a href="https://rocpaddleboards.com/collections/inflatable-paddle-boards" target="_blank">Buy Paddle Boards</a></li>
							</ul>
						</div>
						<div class="col-md-6 col-lg-3 offset-lg-1">
							<h5 class="text-transform-none font-weight-bold text-color-light text-4-5 mb-4">Resources</h5>
							<ul class="list list-unstyled mb-0">
								<li><a href="https://rocpaddleboards.com/pages/user-and-safety-manual" target="_blank">User and Safety Manual</a></li>
								<li><a href="<?= base_url('blog') ?>">Blog</a></li>
								<li><a href="<?= base_url('videos') ?>">Videos</a></li>
							</ul>
						</div>
						<?php endif; ?>
					</div>
				</div>
				<div class="footer-copyright bg-light py-4">
					<div class="container py-2">
						<div class="row">
							<div class="col">
								<p class="text-center text-3 mb-0">Roc Outdoors © 2024. All Rights Reserved.</p>
							</div>
						</div>
					</div>
				</div>
			</footer>