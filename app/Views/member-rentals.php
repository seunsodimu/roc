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
<!-- datatable -->
<link rel="stylesheet" href="//cdn.datatables.net/2.0.3/css/dataTables.dataTables.min.css">


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
            <h2 class="font-weight-bold text-6 mb-0">Rentals</h2>
        </div>
					<div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="rentalsTable" class="table table-hover table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-2">Rental ID</th>
                                            <th class="text-2">Product</th>
                                            <th class="text-2">Rental Date</th>
                                            <th class="text-2">Return Date</th>
                                            <th class="text-2">Status</th>
                                            <th class="text-2"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if ($data['rentals']) :
                                            //var_dump($data['rentals']); exit;
                                            ?>
                                            <?php foreach ($data['rentals'] as $rental) : ?>
                                                <tr>
                                                    <td class="text-2"><?= $rental->id ?></td>
                                                    <td class="text-2"><?= $rental->product_name.'<br>'. $rental->rental_detail ?></td>
                                                    <td class="text-2"><?= date('d-m-Y', strtotime($rental->rent_start_date)) ?></td>
                                                    <td class="text-2"><?= date('d-m-Y', strtotime($rental->rent_end_date)) ?></td>
                                                    <td class="text-2"><?= $rental->status ?></td>
                                                    <td class="text-2">
                                                    <div class="btn-group" role="group">
									    <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Actions</button>
									    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
									      
									      	<a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#defaultModal" data-rental-id="<?= $rental->id ?>" data-product-name="<?= $rental->product_name ?>" data-support-type="Rental Issue">Report an issue</a>
                                            <?php if($rental->status == 'Late') : ?>
                                                <a class="dropdown-item" href="#">Pay late fee</a>
                                                <a class="dropdown-item" href="#" data-rental-id="<?= $rental->id ?>" data-product-name="<?= $rental->product_name ?>" data-support-type="Rental Extension Request">Request an extension</a>
                                            <?php endif; ?>
									    </div>
									</div>
                                                    
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else : ?>
                                            <tr>
                                                <td colspan="6" class="text-center">No rentals found</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                    </div>

						</div>
					</div>

				</div>
                <div class="modal fade" id="defaultModal" tabindex="-1" role="dialog" aria-labelledby="defaultModalLabel" aria-hidden="true">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<h4 class="modal-title" id="defaultModalLabel"></h4>
													<button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true">&times;</button>
												</div>
												<div class="modal-body">
													<form method="post" action="#">
                                                        <input type="hidden" name="rentalId" id="rentalId" value="">
                                                        <input type="hidden" name="supportType" id="supportType" value="">
                                                        <input type="hidden" name="subject" value="" id="subject">
                                                        <div class="form-group">
                                                            <label for="message">Message</label>
                                                            <textarea class="form-control" id="message" name="message" rows="3"></textarea>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary">Send</button>
                                                    </form>
                                                
												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
												</div>
											</div>
										</div>
									</div>
			</div>
<?=$this->endSection()?>

<?=$this->section("bottomscripts")?>
<!-- datatable -->
<script src="//cdn.datatables.net/2.0.3/js/dataTables.min.js"></script>
<script>
    let table = new DataTable('#rentalsTable', {
        searchable: true,
        sortable: true,
        oLanguage: {
            sSearch: "Search rentals",
            sEmptyTable: "<i>No rentals!</i>",
            sInfo: "Showing _START_ to _END_ of _TOTAL_ rentals",
            sInfoEmpty: "Showing 0 to 0 of 0 rentals",
            sInfoFiltered: "(filtered from _MAX_ total rentals)",
            sLengthMenu: "Show _MENU_ rentals",

        },
        iDisplayLength: 100,
    });
    $(document).ready(function() {
        $('.dropdown-item').click(function(e) {
            $('#defaultModalLabel').text('');
            var productName = $(this).data('product-name');
            $('#defaultModalLabel').text('Request support for ' + productName);
            var rentalId = $(this).data('rental-id');
            var supportType = $(this).data('support-type');
            $('#rentalId').val(rentalId);
            $('#supportType').val(supportType);
            $('#subject').val('Support request for ' + productName);
            $('#defaultModal').modal('show');
            if(supportType == 'Rental Extension Request') {
                $('#message').attr('placeholder', 'Please provide information about your request and the date you would like to extend the rental to');
            }else {
                $('#message').attr('placeholder', 'Please provide details of the issue you are experiencing');
            }
        });

        $('#defaultModal form').submit(function(e) {
            e.preventDefault();
            var data = $(this).serialize();
            $.ajax({
                url: '<?= base_url('support-request') ?>',
                type: 'post',
                data: data,
                success: function(response) {
                   console.log(response);
                    if(JSON.parse(response).status == 'success') {
                        $('#defaultModal').modal('hide');
                        alert('Support request sent successfully');
                    }else {
                        alert('An error occurred. Please try again');
                    }
                }
            });
        });
    });
    </script>
<?=$this->endSection()?>