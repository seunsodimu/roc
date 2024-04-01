<?= $this->extend("layouts/app") ?>

<?=$this->section("meta")?>
<?php
foreach ($data['meta_tags']['tags'] as $tag) {
    if ($tag['enabled']) :
        echo "<meta {$tag['type']}='{$tag['type_value']}' content='{$tag['content']}'>";
endif;
    }
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
<div role="main" class="main shop pt-4">

<div class="container">

    <div class="row">
        <div class="col-lg-3 order-2 order-lg-1">
            <?php include('partials/product_sidebar.php'); ?>
        </div>
        <div class="col-lg-9 order-1 order-lg-2">
<div>
</div>
            <div class="table-responsive">
                <table id="searcResultTable" class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th><?= $data['page_title']['title'] ?></th>
                        </tr>
                    </thead>
                    <tbody>
                  <?php foreach ($data['products'] as $product) : ?>
                    <tr>
                        <td>
                            <h4>
                            <a href="<?= base_url('product/'.$product['slug']) ?>"><?= $product['name'] ?></a>
                  </h4>
                            <p class="text-3-5 mb-3"><?php
                                $description = $product['description'];
                                if (strlen($description) > 200) {
                                    echo substr($description, 0, 200)."...";
                                } else {
                                    echo $description;
                                }
                                ?></p>
                                <p class="text-3-5 mb-3"><a href="<?= base_url('products/collections/'.$product['collection_slug']) ?>"><?= $product['collection_name']?></a>
                                <br>Rental price from <span class="text-bold">$<?= $product['sales_price'] ?></span>
                                </p>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
        </div>
    </div>
</div>

</div>
<?=$this->endSection()?>

<?=$this->section("bottomscripts")?>
<!-- datatable -->
<script src="//cdn.datatables.net/2.0.3/js/dataTables.min.js"></script>
<script>
    let table = new DataTable('#searcResultTable', {
        searchable: false,
        searchin: false,
        sortable: false,
        oLanguage: {
            sEmptyTable: "<i>No search results!</i>",
            sInfo: "Showing _START_ to _END_ of _TOTAL_ results",
            sInfoEmpty: "Showing 0 to 0 of 0 results",
            sInfoFiltered: "(filtered from _MAX_ total results)",
            sLengthMenu: "Show _MENU_ results",

        }
    });

    </script>

<?=$this->endSection()?>