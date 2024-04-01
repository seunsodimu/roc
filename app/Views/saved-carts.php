<?= $this->extend("layouts/app") ?>

<?= $this->section("meta") ?>
<?php
if ($data['meta_tags']):
    foreach ($data['meta_tags']['tags'] as $tag) {
        if ($tag['enabled']):
            echo "<meta {$tag['type']}='{$tag['type_value']}' content='{$tag['content']}'>";
        endif;
    }
endif;
?>
<?= $this->endSection() ?>

<?= $this->section("topscripts") ?>
<!-- datatable -->
<link rel="stylesheet" href="//cdn.datatables.net/2.0.3/css/dataTables.dataTables.min.css">
<?= $this->endSection() ?>

<?= $this->section("page_top_promo") ?>
<?php if ($data['page_top_promo']['enabled']): ?>
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
                    <p class="text-color-light mb-0">
                        <?= $data['page_top_promo']['text'] ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<?= $this->endSection() ?>

<?= $this->section("body") ?>
<div role="main" class="main">



    <div class="container pt-3 pb-2">

        <div class="row pt-2">
            <?php include ('partials/member-sidebar.php'); ?>
            <div class="col-lg-9">
                <div class="col">
                    <h2 class="font-weight-bold text-6 mb-0">My Saved Carts</h2>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="cartTable" class="table table-hover table-bordered table-striped mb-5">
                                <thead>
                                    <tr>
                                        <th class="text-2">Created on</th>
                                        <th class="text-2">Total</th>
                                        <th class="text-2">No of Items</th>
                                        <th class="text-2"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($data['savedCarts']): ?>
                                        <?php foreach ($data['savedCarts'] as $cart): ?>
                                            <tr>
                                                <td class="text-2">
                                                    <?= date('M d, Y', strtotime($cart['created_at'])) ?>
                                                </td>
                                                <td class="text-2">$
                                                    <?= $cart['cart_total'] ?>
                                                </td>
                                                <td class="text-2">
                                                    <?= $cart['cart_count'] ?>
                                                </td>
                                                <td class="text-2">
                                                    <div class="btn-group" role="group">
                                                        <button id="btnGroupDrop1" type="button"
                                                            class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown"
                                                            aria-haspopup="true" aria-expanded="false">Actions</button>
                                                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                                            <a class="dropdown-item cartView" href="javascript:void(0)"
                                                                data-cart-id="<?= $cart['id'] ?>"> <i class="fa fa-search"></i>
                                                                View</a>
                                                            <a class="dropdown-item cartRemove" href="javascript:void(0)"
                                                                data-cart-id="<?= $cart['id'] ?>"><i class="fa fa-trash"></i>
                                                                Delete</a>

                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    
                                    <?php endif; ?>
                                </tbody>
                            </table>
                            <div class="mt-5"></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
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
                    <button type="button" class="btn btn-primary" id="loadCart" data-cart-id="">Load Cart</button>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section("bottomscripts") ?>
<!-- datatable -->
<script src="//cdn.datatables.net/2.0.3/js/dataTables.min.js"></script>
<script>
    let table = new DataTable('#cartTable', {
        searchable: true,
        sortable: true,
        iDisplayLength: 100,
        oLanguage: {
            sSearch: "Search Saved Cart",
            sEmptyTable: "<i>No saved carts found!</i>",
            sZeroRecords: "<i>No saved carts found!</i>",
            sInfo: "Showing _START_ to _END_ of _TOTAL_ saved carts",
            sInfoEmpty: "Showing 0 to 0 of 0 saved carts",
            sInfoFiltered: "(filtered from _MAX_ total saved carts)",
            sLengthMenu: "Show _MENU_ saved carts",
        }
    });
    $(document).ready(function () {
        $('.cartRemove').click(function (e) {
            e.preventDefault();
            var cartId = $(this).data('cart-id');
            var url = '<?= base_url('delete-saved-cart') ?>';
            var data = {
                cart_id: cartId
            };
            $.ajax({
                url: url,
                type: 'POST',
                data: data,
                success: function (response) {
                    if (response.status) {
                        alert('Cart removed successfully');
                        window.location.reload();
                    }
                }
            });
        });

        $('.cartView').click(function (e) {
            e.preventDefault();
            var cartId = $(this).data('cart-id');
            var url = '<?= base_url('get-saved-cart') ?>';
            var data = {
                id: cartId
            };
            $.ajax({
                url: url,
                type: 'GET',
                data: data,
                success: function (response) {
                    var response = JSON.parse(response);
                    var cart = response.cart;
                    cart = JSON.parse(cart);
                    var table = '<table class="table table-hover table-bordered table-striped"><thead><tr><th class="text-2">Product</th><th class="text-2">Price</th><th class="text-2">Quantity</th><th class="text-2">Duration</th><th class="text-2">Total</th></tr></thead><tbody>';
                    cart.forEach(function (item) {
                        table += '<tr><td class="text-2">' + item.product_name + ' ' + item.color_name + ' ' + item.product_extra + '</td><td class="text-2">$' + item.product_price + '</td><td class="text-2">' + item.productQty + '</td><td class="text-2">' + item.rent_duration + ' days<br>(starting from: ' + item.rental_start + ')</td><td class="text-2">$' + item.subtotal + '</td></tr>';
                    });
                    table += '</tbody></table>';
                    table += '<div class="text-end"><strong>Total: $' + response.cart_total + '</strong></div>';
                    $('#loadCart').data('cart-id', cartId);
                    $('#defaultModalLabel').text('Cart Items');
                    $('.modal-body').html(table);
                    $('#defaultModal').modal('show');
                    // }
                }
            });
        });
        $('#loadCart').click(function (e) {
            console.log('clicked');
            // e.preventDefault();
            var cartId = $(this).data('cart-id');
            var url = '<?= base_url('load-saved-cart') ?>';
            var data = {
                id: cartId
            };
            $.ajax({
                url: url,
                type: 'GET',
                data: data,
                success: function (response) {
                    
                    var response = JSON.parse(response);
                    if (response.status) {
                       alert('Cart loaded successfully');
                        window.location.href = '<?= base_url('cart') ?>';
                    }
                }
            });
        });
    });
</script>
<?= $this->endSection() ?>