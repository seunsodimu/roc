<header id="header"
	data-plugin-options="{'stickyEnabled': true, 'stickyEnableOnBoxed': true, 'stickyEnableOnMobile': false, 'stickyStartAt': 54, 'stickySetTop': '-54px', 'stickyChangeLogo': false}">
	<div class="header-body header-body-bottom-border-fixed box-shadow-none border-top-0">
		<div class="header-top header-top-small-minheight header-top-simple-border-bottom">
			<div class="container py-2">
				<div class="header-row justify-content-between">
					<div class="header-column col-auto px-0">
						<div class="header-row">
							<div class="header-nav-top">
								<ul class="nav nav-pills position-relative">
									<li class="nav-item d-none d-sm-block">
										<span
											class="d-flex align-items-center font-weight-medium ws-nowrap text-3 ps-0"><a
												href="mailto:support@rocoutdoorsrentals.com"
												class="text-decoration-none text-color-dark text-color-hover-primary"><i
													class="icons icon-envelope font-weight-bold position-relative text-4 top-3 me-1"></i>
												support@rocoutdoorsrentals.com</a></span>
									</li>

								</ul>
							</div>
						</div>
					</div>
					<div class="header-column justify-content-end col-auto px-0 d-none d-md-flex">
						<div class="header-row">
							<nav class="header-nav-top">
								<ul
									class="header-social-icons social-icons social-icons-clean social-icons-icon-gray social-icons-medium custom-social-icons-divider">
									<li class="social-icons-facebook">
										<a href="https://www.facebook.com/people/ROC-SUP-Co/100088520862379/" target="_blank" title="Facebook"><i
												class="fab fa-facebook-f"></i></a>
									</li>
									<li class="social-icons-youtube">
										<a href="http://www.youtube.com/@rocpaddleboards" target="_blank" title="YouTube"><i class="fab fa-youtube"></i></a>
									</li>
									<li class="social-icons-instagram">
										<a href="https://www.instagram.com/rocpaddleboards/" target="_blank" title="Instagram"><i
												class="fab fa-instagram"></i></a>
									</li>
									<li>

										<div id="headerTopSearchDropdown">
											<form role="search" action="<?= base_url('search') ?>" method="get">
												<div class="simple-search input-group">
													<input class="form-control text-1 rounded" id="headerSearch"
														name="q" type="search" value="" placeholder="Search...">
													<button class="btn" type="submit" aria-label="Search">
														<i class="icons icon-magnifier header-nav-top-icon"></i>
													</button>
												</div>
											</form>
										</div>
									</li>
								</ul>
							</nav>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="header-container container">
			<div class="header-row">
				<div class="header-column w-100">
					<div class="header-row justify-content-between">
						<div class="header-logo z-index-2 col-lg-2 px-0">
							<a href="<?= base_url() ?>">
								<img alt="Roc Outdoors" width="123" height="48" data-sticky-width="82"
									data-sticky-height="40" data-sticky-top="84"
									src="<?= base_url() ?>assets/img/roc-sup-q600x_210x.avif">
							</a>
						</div>
						<div class="header-nav header-nav-links justify-content-end pe-lg-4 me-lg-3">
							<div
								class="header-nav-main header-nav-main-arrows header-nav-main-dropdown-no-borders header-nav-main-effect-3 header-nav-main-sub-effect-1">
								<nav class="collapse">
									<ul class="nav nav-pills" id="mainNav">
										<li><a href="<?= base_url() ?>"
												class="nav-link <?= $data['active'] == 'home' ? 'active' : '' ?>">Home</a>
										</li>
										<li><a href="<?= base_url('about-us') ?>"
												class="nav-link <?= $data['active'] == 'about' ? 'active' : '' ?>">About
												Us</a></li>
										<li class="dropdown">
											<a href="#" class="nav-link dropdown-toggle" <?= $data['active'] == 'products' ? 'active' : '' ?>>Products</a>
											<ul class="dropdown-menu">
												<li><a href="<?= base_url('products/collections/alliance-hd-series') ?>"
														class="dropdown-item">Alliance Series</a></li>
												<li><a href="<?= base_url('products/collections/cruiser-series') ?>"
														class="dropdown-item">Cruiser Series</a></li>
												<li><a href="<?= base_url('products/collections/explorer-series') ?>"
														class="dropdown-item">Explorer Series</a></li>
												<li><a href="<?= base_url('products/collections/kahuna-series') ?>"
														class="dropdown-item">Kahuna Series</a></li>
												<li><a href="<?= base_url('products/collections/scout-series') ?>"
														class="dropdown-item">Scout Series</a></li>
												<li><a href="<?= base_url('products/collections/polar-outdoor-series') ?>"
														class="dropdown-item">Polar Outdoor Series</a></li>
												<li><a href="<?= base_url('products') ?>" class="dropdown-item">More</a>
												</li>
											</ul>
										</li>
										<li class="dropdown">
											<a href="#"
												class="nav-link dropdown-toggle <?= $data['active'] == 'accessories' ? 'active' : '' ?>">Accessories</a>
											<ul class="dropdown-menu">
												<li><a href="<?= base_url('products/collections/paddles') ?>"
														class="dropdown-item">Paddles</a></li>
												<li><a href="<?= base_url('products/collections/fins') ?>"
														class="dropdown-item">Fins</a></li>
												<li><a href="<?= base_url('products/collections/leashes') ?>"
														class="dropdown-item">Leashes</a></li>
												<li><a href="<?= base_url('products/collections/seats') ?>"
														class="dropdown-item">Seats</a></li>
												<li><a href="<?= base_url('products/collections/wrench') ?>"
														class="dropdown-item">Wrench</a></li>
												<li><a href="<?= base_url('products/collections/air-pump') ?>"
														class="dropdown-item">Air Pump</a></li>
											</ul>
										</li>
										<li><a href="<?= base_url() ?>blog"
												class="nav-link <?= $data['active'] == 'blog' ? 'active' : '' ?>">Blog</a>
										</li>
										<li><a href="<?= base_url() ?>contact-us"
												class="nav-link <?= $data['active'] == 'contact' ? 'active' : '' ?>">Contact
												Us</a></li>
									</ul>
								</nav>
							</div>
						</div>
						<ul class="header-extra-info custom-left-border-1 d-none d-xl-block">
							<li class="d-none d-sm-inline-flex ms-0">
								<div class="header-extra-info-icon">
									<i class="icons icon-phone text-3 text-color-dark position-relative top-3"></i>
								</div>
								<div class="header-extra-info-text line-height-2">
									<span class="text-1 font-weight-semibold text-color-default">CALL US NOW</span>
									<strong class="text-4"><a href="tel:7272012459"
											class="text-color-hover-primary text-decoration-none">7272012459</a></strong>
								</div>
							</li>
						</ul>
						<div class="d-flex col-auto pe-0 ps-0 ps-xl-3">
							<div class="header-nav-features ps-0 ms-1">
							<div class="header-nav-feature header-nav-features-search d-inline-flex position-relative top-3 border border-top-0 border-bottom-0 custom-remove-mobile-border-left px-4 me-2">
									<?php if (session()->get('isLoggedIn')): ?>
										<a href="#" class="header-nav-features-toggle" aria-label="">
											<span class="text-3 position-relative top-3">My Account</span>

										</a>
										<div class="header-nav-features-dropdown" id="headerTopAcctDropdown">


											<div class="product-details pull-right">
												WELCOME,
												<?= session()->get('firstname') ?>
											</div>
											<ul style="list-style: none;">
												<li class="item">
													<a href="<?= base_url('dashboard') ?>" title="Dashboard"
														class="product-image"><i class="fa fa-user"></i> Dashboard</a>
												</li>
												<li class="item">
													<a href="<?= base_url('member-logout') ?>" title="Logout"
														class="product-image"><i class="fa fa-sign-out-alt"></i> Logout</a>
												</li>
											</ul>

										</div>
									<?php else: ?>
										<a href="#" class="header-nav-features-toggle" aria-label="">
											<i
												class="fa fa-user header-nav-top-icon text-5 font-weight-bold position-relative top-3"></i>

										</a>
										<div class="header-nav-features-dropdown" id="headerTopAcctDropdown">
											<ul style="list-style: none;">
												<li class="item">
													<div class="product-details">
														<a href="<?= base_url('member-login') ?>" title="Login"
															class="product-image"><i class="fa fa-right-to-bracket"></i>
															Signin / Signup</a>
													</div>
												</li>
											</ul>
										</div>
									<?php endif; ?>
								</div>
								<div class="header-nav-feature header-nav-features-cart header-nav-features-cart-big d-inline-flex top-2 me-2">
									<a href="#" class="header-nav-features-toggle" aria-label="">
										<i
											class="fa fa-cart-shopping header-nav-top-icon text-5 font-weight-bold position-relative top-3"></i>
										<?php if (session()->get('cart') && session()->get('cart_count') > 0): ?>
											<span class="cart-info">
												<span class="cart-qty">
													<?= session()->get('cart_count') ?>
												</span>
											</span>
										<?php endif; ?>
									</a>
									<div class="header-nav-features-dropdown" id="headerTopCartDropdown">
										<?php if (session()->get('cart') && session()->get('cart_count') > 0): ?>
											<ol class="mini-products-list">
												<?php
												$i = 0;
												foreach (session()->get('cart') as $key => $value):
													?>

													<li class="item">
														<a href="<?= base_url('cart') ?>" title="<?= $value['product_name'] ?>"
															class="product-image"><img src="<?= $value['product_image'] ?>"
																alt="<?= $value['product_name'] ?>"></a>
														<div class="product-details">
															<p class="product-name">
																<a href="<?= base_url('cart') ?>">
																	<?= $value['product_name'] ?>
																</a>
															</p>
															<span class="qty-price">
																<?= $value['color_name'] ?>
															</span>
															<p class="qty-price">
																<span class="price">$
																	<?= $value['product_price'] ?>
																</span> X
																<?= $value['rent_duration'] ?>day(s) = <span class="price">$
																	<?= $value['subtotal'] ?>
																</span>
															</p>
															<a href="javascript:void(0)" class="btn-remove"
																title="Remove This Item"
																onclick="removeCartItem(<?= $key ?>)"><i
																	class="fa fa-trash"></i></a>
														</div>
													</li>
													<?php
													$i++;
													if ($i == 3) {
														break;
													}
												endforeach; ?>
											</ol>
											<div class="totals">
												<span class="label">Total:</span>
												<span class="price-total"><span class="price">$
														<?= round(session()->get('cart_total'), 2) ?>
													</span></span>
											</div>
											<div class="actions">
												<a class="btn btn-dark" href="<?= base_url('cart') ?>">View Cart</a>
												<a class="btn btn-primary"
													href="<?= base_url('checkout') ?>">Checkout</a>
											</div>
										<?php else: ?>
											<p class="text-center">There are no items in your cart</p>
										<?php endif; ?>
									</div>
								</div>
								
							</div>
						</div>
						<button class="btn header-btn-collapse-nav ms-4" data-bs-toggle="collapse"
							data-bs-target=".header-nav-main nav">
							<i class="fas fa-bars"></i>
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</header>