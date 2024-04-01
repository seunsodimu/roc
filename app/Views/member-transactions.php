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
            <h2 class="font-weight-bold text-6 mb-0">My Transactions</h2>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                <table id="txnTable" class="table table-hover table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-2">Order ID</th>
                                            <th class="text-2">Payment Method</th>
                                            <th class="text-2">Transaction Date</th>
                                            <th class="text-2">Total</th>
                                            <th class="text-2">Status</th>
                                            <th class="text-2">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if ($data['transactions']) : ?>
                                            <?php foreach ($data['transactions'] as $transaction) : ?>
                                                <tr>
                                                    <td class="text-2"><?= $transaction['id'] ?></td>
                                                    <td class="text-2"><?= $transaction['merchant'] ?></td>
                                                    <td class="text-2"><?= date('M d, Y', strtotime($transaction['created_date'])) ?></td>
                                                    <td class="text-2">$<?= $transaction['total_amount'] ?></td>
                                                    <td class="text-2"><?= $transaction['status'] ?></td>
                                                    <td class="text-2">
                                                        <a href="javascript:void(0)" class="btn btn-primary btn-sm viewTxn" data-bs-toggle="modal" data-bs-target="#defaultModal" data-txn-id="<?= $transaction['id'] ?>">View</a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                </div>
            </div>
        </div>
							

						</div>
					</div>

				</div>
<!-- Modal -->
<div class="modal fade" id="defaultModal" tabindex="-1" role="dialog" aria-labelledby="defaultModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel"></h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">


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
    let table = new DataTable('#txnTable', {
        searchable: true,
        sortable: true,
        iDisplayLength: 100,
        oLanguage: {
            sSearch: "Search transactions",
            sEmptyTable: "<i>No transactions!</i>",
            sZeroRecords: "<i>No transactions!</i>",
            sInfo: "Showing _START_ to _END_ of _TOTAL_ transactions",
            sInfoEmpty: "Showing 0 to 0 of 0 transactions",
            sInfoFiltered: "(filtered from _MAX_ total transactions)",
            sLengthMenu: "Show _MENU_ transactions",
        }
    });
    $(document).ready(function() {
        $('.viewTxn').click(function(e) {
            e.preventDefault();
            let txnId = $(this).data('txn-id');
            $.ajax({
                url: '<?= base_url('transaction-details') ?>',
                type: 'POST',
                data: {
                    txn_id: txnId
                },
                success: function(response) {
                    $('#defaultModalLabel').html('Transaction Details');
                    var txn_det =JSON.parse(response);
                    $('.modal-body').html('');
                    var html = '<div class="row">';
                    html += '<div class="col-md-12">';
                    html += '<table class="table table-bordered">';
                    html += '<tr><td>Order ID</td><td>' + txn_det.id + '</td></tr>';
                    html += '<tr><td>Payment Method</td><td>' + txn_det.merchant + ' Payment</td></tr>';
                    html += '<tr><td>Transaction Date</td><td>' + txn_det.created_date + '</td></tr>';
                    html += '<tr><td>Total</td><td>$' + txn_det.total_amount + '</td></tr>';
                    html += '<tr><td>Status</td><td>' + txn_det.status + '</td></tr>';
                    html += '</table>';
                    html += '</div>';
                    var cart = JSON.parse(txn_det.cart_info);
                    if(cart) {
                    html += '<div class="col-md-12">';
                    html += '<h2>Rented Items</h2>';
                    html += '<table class="table table-bordered table-striped">';
                    html += '<tr><th>Product</th><th>Duration</th><th>Subtotal</th></tr>';
                    cart.forEach(function(item) {
                        html += '<tr>';
                        html += '<td>' + item.product_name + ' - ' +item.color_name + ' - ' + item.product_extra + '</td>';
                        html += '<td>' + item.rent_duration + ' days</td>';
                        html += '<td>$' + item.subtotal + '</td>';
                        html += '</tr>';
                    });
                    html += '</table>';
                    html += '</div>';
                    }
                    html += '</div>';
                    $('.modal-body').html(html);

                }
            });
        });
    });

    </script>
<?=$this->endSection()?>