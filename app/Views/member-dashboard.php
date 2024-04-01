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
            <h2 class="font-weight-bold text-6 mb-0">My Profile</h2>
        </div>
		<div class="left-col col-lg-3">
			<div class="card border-width-3 border-radius-0 border-color-primary">
				<button class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#passwordChangeModal">Change Password</button>
			</div>
		</div>
							<form role="form" class="needs-validation" id="profileUpdateForm" method="POST">
							    <div class="form-group row">
							        <label class="col-lg-3 col-form-label form-control-label line-height-9 pt-2 text-2 required">First name</label>
							        <div class="col-lg-9">
							            <input class="form-control text-3 h-auto py-2" type="text" name="FirstName" value="<?= $data['user_data']['first_name'] ?>" required>
							        </div>
							    </div>
							    <div class="form-group row">
							        <label class="col-lg-3 col-form-label form-control-label line-height-9 pt-2 text-2 required">Last name</label>
							        <div class="col-lg-9">
							            <input class="form-control text-3 h-auto py-2" type="text" name="LastName" value="<?= $data['user_data']['last_name'] ?>" required>
							        </div>
							    </div>
							    <div class="form-group row">
							        <label class="col-lg-3 col-form-label form-control-label line-height-9 pt-2 text-2 required">Email</label>
							        <div class="col-lg-9">
							            <input class="form-control text-3 h-auto py-2" type="email" name="Email" value="<?= $data['user_data']['email'] ?>" required>
							        </div>
							    </div>
							    <div class="form-group row">
							        <label class="col-lg-3 col-form-label form-control-label line-height-9 pt-2 text-2">Phone Number</label>
							        <div class="col-lg-9">
							            <input class="form-control text-3 h-auto py-2" type="tel" name="Phone" value="<?= $data['user_data']['phone'] ?>">
							        </div>
							    </div>
							    <div class="form-group row">
							        <label class="col-lg-3 col-form-label form-control-label line-height-9 pt-2 text-2">Address</label>
							        <div class="col-lg-9">
							            <input class="form-control text-3 h-auto py-2" type="text" name="Address" value="<?= $data['user_data']['address'] ?>" placeholder="Street">
							        </div>
							    </div>
							    <div class="form-group row">
							        <label class="col-lg-3 col-form-label form-control-label line-height-9 pt-2 text-2"></label>
							        <div class="col-lg-4">
							            <input class="form-control text-3 h-auto py-2" type="text" name="City" value="<?= $data['user_data']['city'] ?>" placeholder="City">
							        </div>
							        <div class="col-lg-3">
							            <input class="form-control text-3 h-auto py-2" type="text" name="State" value="<?= $data['user_data']['state'] ?>" placeholder="State">
							        </div>
							        <div class="col-lg-2">
							            <input class="form-control text-3 h-auto py-2" type="text" name="Zip" value="<?= $data['user_data']['state'] ?>" placeholder="Zip">
							        </div>
							    </div>
							    <div class="form-group row">
							        <label class="col-lg-3 col-form-label form-control-label line-height-9 pt-2 text-2">Time Zone</label>
							        <div class="col-lg-9">
							            <div class="custom-select-1">
							                <select id="user_time_zone" class="form-control text-3 h-auto py-2" name="Timezone" size="0">
                                                <option value="">Select Time Zone</option>
							                    <option value="Hawaii" <?php if ($data['user_data']['timezone'] == 'Hawaii') : ?>selected<?php endif; ?>>(GMT-10:00) Hawaii</option>
							                    <option value="Alaska" <?php if ($data['user_data']['timezone'] == 'Alaska') : ?>selected<?php endif; ?>>(GMT-09:00) Alaska</option>
							                    <option value="Pacific Time (US &amp; Canada)" <?php if ($data['user_data']['timezone'] == 'Pacific Time (US & Canada)') : ?>selected<?php endif; ?>>(GMT-08:00) Pacific Time (US &amp; Canada)</option>
							                    <option value="Arizona" <?php if ($data['user_data']['timezone'] == 'Arizona') : ?>selected<?php endif; ?>>(GMT-07:00) Arizona</option>
							                    <option value="Mountain Time (US &amp; Canada)" <?php if ($data['user_data']['timezone'] == 'Mountain Time (US & Canada)') : ?>selected<?php endif; ?>>(GMT-07:00) Mountain Time (US &amp; Canada)</option>
							                    <option value="Central Time (US &amp; Canada)" <?php if ($data['user_data']['timezone'] == 'Central Time (US & Canada)') : ?>selected<?php endif; ?>>(GMT-06:00) Central Time (US &amp; Canada)</option>
							                    <option value="Eastern Time (US &amp; Canada)" <?php if ($data['user_data']['timezone'] == 'Eastern Time (US & Canada)') : ?>selected<?php endif; ?>>(GMT-05:00) Eastern Time (US &amp; Canada)</option>
							                    <option value="Indiana (East)" <?php if ($data['user_data']['timezone'] == 'Indiana (East)') : ?>selected<?php endif; ?>>(GMT-05:00) Indiana (East)</option>
							                </select>
							            </div>
							        </div>
							    </div>
							    <div class="form-group row">
									<div class="form-group col-lg-9">

									</div>
									<div class="form-group col-lg-3">
										<input type="submit" value="Save" class="btn btn-primary btn-modern float-end" data-loading-text="Loading...">
									</div>
							    </div>
							</form>

						</div>
					</div>

				</div>
<!-- password change modal -->
<div class="modal fade" id="passwordChangeModal" tabindex="-1" role="dialog" aria-labelledby="passwordChangeModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="passwordChangeModalLabel">Change Password</h4>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body">
				<div class="text-danger" id="passwordChangeMsg"></div>
				<form method="post" action="" id="passwordChangeForm">
					<div class="form-group">
						<label for="currentPassword">Current Password</label>
						<input type="password" class="form-control" id="currentPassword" name="CurrentPassword">
						<div class="invalid-feedback">Please provide your current password.</div>
						<div class="valid-feedback">Looks good!</div>
						<input type="checkbox" onclick="showPassword('currentPassword')"> Show Password
					</div>
					<div class="form-group">
						<label for="newPassword">New Password</label>
						<input type="password" class="form-control" id="newPassword" name="NewPassword">
						<div class="invalid-feedback">Please provide a new password.</div>
						<div class="valid-feedback">Looks good!</div>
						<div class="form-text">Password must be at least 8 characters long.</div>
						<input type="checkbox" onclick="showPassword('newPassword')"> Show Password
					</div>
					<div class="form-group">
						<label for="confirmPassword">Confirm Password</label>
						<input type="password" class="form-control" id="confirmPassword" name="ConfirmPassword">
						<div class="invalid-feedback">Please confirm your new password.</div>
						<div class="valid-feedback">Looks good!</div>
						<input type="checkbox" onclick="showPassword('confirmPassword')"> Show Password
					</div>
					<button type="submit" class="btn btn-primary">Change Password</button>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>	
			</div>
		</div>
	</div>
			</div>
<?=$this->endSection()?>

<?=$this->section("bottomscripts")?>
<script>
	function showPassword(id) {
		var x = document.getElementById(id);
		if (x.type === "password") {
			x.type = "text";
		} else {
			x.type = "password";
		}
	}
	$(document).ready(function() {
		$('#profileUpdateForm').submit(function(e) {
			e.preventDefault();
			let form = $(this);
			let url = '<?= base_url('profile-update') ?>';
			let data = form.serialize();
			$.ajax({
				type: 'POST',
				url: url,
				data: data,
				success: function(response) {
					 response =JSON.parse(response);
					if (response.status == 'success') {
						alert('Profile updated successfully');
					}else{
						alert('Profile update failed');
						
					}
				}
			});
		});

		$('#passwordChangeForm').submit(function(e) {
			e.preventDefault();
			let form = $(this);
			let url = '<?= base_url('change-password') ?>';
			let data = form.serialize();
			$.ajax({
				type: 'POST',
				url: url,
				data: data,
				success: function(response) {
					response =JSON.parse(response);
					if (response.status == 'success') {
						alert('Password changed successfully');
						$('#passwordChangeModal').modal('hide');
					}else{
						//alert(response.msg);
						var msg = "<span class='text-danger'>"+response.msg+"</span>";
						$('#passwordChangeMsg').html(msg);
					}
				}
			});
			
		});
	});
</script>
<?=$this->endSection()?>