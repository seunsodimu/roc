<!DOCTYPE html>
<html lang="en">
    <head>
    
    <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>Roc Outdoors Rentals | <?= $data['page_title']['title'] ?? '' ?></title>
    
    <!-- allow pages their own meta tags -->
    <?= $this->renderSection('meta') ?>
    
    <!-- favicons -->
    <link rel="shortcut icon" href="<?= base_url() ?>/assets/img/favicon.ico" type="image/x-icon" />
	<link rel="apple-touch-icon" href="<?= base_url() ?>/assets/img/apple-touch-icon.png">

	<!-- Mobile Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0, shrink-to-fit=no">

    <!-- Vendor CSS -->
    <?= $this->include('partials/home_styles') ?>
    
    <!-- additional header scripts -->
    <?= $this->renderSection('topscripts') ?>
    </head>
    <body>
    <div class="body">
			<?= $this->renderSection('page_top_promo') ?>
			<?= $this->include('partials/header') ?>

			<?= $this->renderSection('body') ?>

			<?= $this->include('partials/footer') ?>

		</div>
   <?= $this->include('partials/home_scripts') ?>
    <?= $this->renderSection('bottomscripts') ?>
<script>
function removeCartItem(id) {
    console.log(id);
        $.ajax({
            url: '<?= base_url('cart/remove') ?>',
            type: 'POST',
            data: {id: id},
            success: function(response) {
                alert('Item removed from cart');
                location.reload();
            }
        });
}
    </script>

    </body>
</html>