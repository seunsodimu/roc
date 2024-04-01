<div class="col-lg-3 mt-4 mt-lg-0">

							<aside class="sidebar mt-2" id="sidebar">
                                <p class="text-3 text-dark">Welcome, <?= session()->get('firstname') ?></p>
								<ul class="nav nav-list flex-column mb-5">
									<li class="nav-item"><a class="nav-link text-3 <?= $data['active'] == 'dashboard' ? 'text-dark active' : '' ?>" href="<?= base_url('dashboard') ?>">My Profile</a></li>
									<li class="nav-item"><a class="nav-link text-3 <?= $data['active'] == 'my-rentals' ? 'text-dark active' : '' ?>" href="<?= base_url('my-rentals') ?>">My Rentals</a></li>
									<li class="nav-item"><a class="nav-link text-3 <?= $data['active'] == 'my-transactions' ? 'text-dark active' : '' ?>" href="<?= base_url('my-transactions') ?>">My Transactions</a></li>
									<li class="nav-item"><a class="nav-link text-3 <?= $data['active'] == 'my-saved-carts' ? 'text-dark active' : '' ?>" href="<?= base_url('my-saved-items') ?>">My Saved Products</a></li>
								</ul>
							</aside>

						</div>