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


				<div class="container py-4">

					<div class="row justify-content-center">
						<?php if (session()->getFlashdata('validation')) : ?>
								<div class="alert alert-danger alert-dismissible" role="alert">
								<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
									<?= session()->getFlashdata('validation')->listErrors() ?>
								</div>
							<?php endif; ?>
							<?php if (session()->getFlashdata('msg')) : ?>
								<div class="alert alert-<?= session()->getFlashdata('msgtype') ?> alert-dismissible" role="alert">
								<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
									<?= session()->getFlashdata('msg') ?>
								</div>
							<?php endif; ?>
							<div class="card col-md-12 m-auto" id="resetPasswordDiv">
							<div class="card-body">
							<h2 class="font-weight-bold text-5 mb-0">Reset Password</h2>
							<form action="<?= base_url('member-reset-password') ?>" id="frmForgotPassword" method="post">
								<div class="row">
									<div class="form-group col">
										<label class="form-label text-color-dark text-3">Email Address <span class="text-color-danger">*</span></label>
										<input name="EmailAddress" type="email" value="" class="form-control form-control-lg text-4" id="resetEmail" required>
									</div>
								</div>
								<div class="row">
									<div class="form-group col">
										<button type="submit" class="btn btn-dark btn-modern w-100 text-uppercase rounded-0 font-weight-bold text-3 py-3" data-loading-text="Loading...">Reset Password</button>
									</div>
									<center><a class="text-decoration-none text-color-dark text-color-hover-primary font-weight-semibold text-2 backToLogin" href="#">Back to Login</a></center>
								</div>
							</form>
						</div>
						</div>
						<div class="card col-md-5 m-auto" id="signInDiv">
							<div class="card-body">
							<h2 class="font-weight-bold text-5 mb-0">Login</h2>
							
							<form action="<?= base_url('member-login') ?>" id="frmSignIn" method="post" class="needs-validation">
								<div class="row">
									<div class="form-group col">
										<label class="form-label text-color-dark text-3">Email address <span class="text-color-danger">*</span></label>
										<input name="username" type="text" value="" class="form-control form-control-lg text-4" required>
									</div>
								</div>
								<div class="row">
									<div class="form-group col">
										<label class="form-label text-color-dark text-3">Password <span class="text-color-danger">*</span></label>
										<input name="password" type="password" value="" class="form-control form-control-lg text-4" required>
									</div>
								</div>
								<div class="row justify-content-between">
									<div class="form-group col-md-auto">
										<div class="custom-control custom-checkbox">
											<input type="checkbox" class="custom-control-input" id="rememberme">
											<label class="form-label custom-control-label cur-pointer text-2" for="rememberme">Remember Me</label>
										</div>
									</div>
									<div class="form-group col-md-auto">
										<a class="text-decoration-none text-color-dark text-color-hover-primary font-weight-semibold text-2 showreset" href="#">Forgot Password?</a>
									</div>
								</div>
								<div class="row">
									<div class="form-group col">
										<button type="submit" class="btn btn-dark btn-modern w-100 text-uppercase rounded-0 font-weight-bold text-3 py-3" data-loading-text="Loading...">Login</button>
										</div>
								</div>
							</form>
							</div>
						</div>
						<div class="card col-md-6 m-auto" id="registerDiv">
						<div class="card-body">
							<h2 class="font-weight-bold text-5 mb-0">Register</h2>
							<form action="<?= base_url('member-register') ?>" id="frmSignUp" method="post">
								<div class="row">
										<div class="form-group col-lg-6">
										<label class="form-label text-color-dark text-3">First Name <span class="text-color-danger">*</span></label>
										<input name="FirstName" type="text" value="" class="form-control form-control-lg text-4" required>
										</div>
										<div class="form-group col-lg-6">
										<label class="form-label text-color-dark text-3">Last Name <span class="text-color-danger">*</span></label>
										<input name="LastName" type="text" value="" class="form-control form-control-lg text-4" required>
										</div>
								<div class="row">
									<div class="form-group col">
										<label class="form-label text-color-dark text-3">Email Address <span class="text-color-danger">*</span></label>
										<input name="EmailAddress" type="email" value="" class="form-control form-control-lg text-4" required>
									</div>
								</div>
								<div class="row">
									<div class="form-group col-lg-6">
										<label class="form-label text-color-dark text-3">Password <span class="text-color-danger">*</span></label>
										<input name="Password" type="password" value="" class="form-control form-control-lg text-4" required>
									</div>
									<div class="form-group col-lg-6">
										<label class="form-label text-color-dark text-3">Confirm Password <span class="text-color-danger">*</span></label>
										<input name="ConfirmPassword" type="password" value="" class="form-control form-control-lg text-4" required>
									</div>
								</div>
								<div class="row">
									<div class="form-group col">
										<p class="text-2 mb-2">Your personal data will be used to support your experience throughout this website, to manage access to your account, and for other purposes described in our <a href="<?= base_url('privacy-policy') ?>" class="text-decoration-none">privacy policy.</a></p>
									</div>
								</div>
								<div class="row">
									<div class="form-group col">
										<button type="submit" class="btn btn-dark btn-modern w-100 text-uppercase rounded-0 font-weight-bold text-3 py-3" data-loading-text="Loading...">Register</button>
									</div>
								</div>
							</form>
						</div>
						</div>
					</div>

				</div>

			</div>
<?=$this->endSection()?>

<?=$this->section("bottomscripts")?>
<script type="text/javascript">
		$(document).ready(function() {
			
				$('#signInDiv').show();
				$('#registerDiv').show();
				$('#resetPasswordDiv').hide();
			
			$('.showreset').click(function() {
				$('#signInDiv').hide();
				$('#registerDiv').hide();
				$('#resetPasswordDiv').show();
			});
			$('.backToLogin').click(function() {
				$('#signInDiv').show();
				$('#registerDiv').show();
				$('#resetPasswordDiv').hide();
			});
			//if url has reset = 1 then show reset password div, if url has email then populate email field
			var url = window.location.href;
			if (url.indexOf("reset=1") != -1) {
				$('#signInDiv').hide();
				$('#registerDiv').hide();
				$('#resetPasswordDiv').show();
			}
			if (url.indexOf("email") != -1) {
				var email = url.split('email=')[1];
				$('#resetEmail').val(email);
			}
			
		});
	</script>
<?=$this->endSection()?>