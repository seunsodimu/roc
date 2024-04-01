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

				<section id="bannerSection" class="page-header page-header-modern bg-color-grey page-header-lg">
                <div class="position-absolute top-0 left-0 right-0 bottom-0 animated fadeIn" style="animation-delay: 600ms;">
						<div class="background-image-wrapper custom-background-style-2 position-absolute top-0 left-0 right-0 bottom-0 animated kenBurnsToRight" style="background-image: url(<?= base_url($data['banner']['bg_image']) ?>); background-position: center right; animation-duration: 30s;"></div>
					</div>
					<div class="container">
						<div class="row">
							<div class="col-md-12 align-self-center p-static order-2 text-center">
								<h1 class="font-weight-bold text-light"><?= $data['banner']['title'] ?></h1>
                                <p class="text-light position-relative"><?= $data['banner']['intro_text'] ?></p>
							</div>
						</div>
					</div>
				</section>

                <div class="container py-4">

<div class="row">
    <?= $this->include('partials/blog_sidebar') ?>
    <div class="col-lg-9">
        <div class="blog-posts">
<?php foreach ($data['blog_data']['posts'] as $post) : ?>
            <article class="post post-medium">
                <div class="row mb-3">
                    <div class="col-lg-5">
                        <div class="post-image">
                            <a href="<?= base_url('blog/'.$post['slug']) ?>">
                                <img src="<?= base_url($post['banner']) ?>" class="img-fluid img-thumbnail img-thumbnail-no-borders rounded-0" alt="<?= $post['title'] ?>" />
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="post-content">
                            <h2 class="font-weight-semibold pt-4 pt-lg-0 text-5 line-height-4 mb-2"><a href="<?= base_url('blog/'.$post['slug']) ?>"><?= $post['title'] ?></a></h2>
                            <p class="mb-0"><?= $post['short_description'] ?> [...]</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="post-meta">
                            <span><i class="far fa-calendar-alt"></i> <?= date('M j, Y', strtotime($post['created_at'])) ?> </span>
                            <span><i class="far fa-user"></i> By <a href="#"><?= $post['author'] ?></a> </span>
                            <span><i class="far fa-folder"></i> <a href="<?= base_url('blog/category/'.$post['category_id']) ?>"><?= $post['category'] ?></a> </span>
                            <span class="d-block d-sm-inline-block float-sm-end mt-3 mt-sm-0"><a href="<?= base_url('blog/'.$post['slug']) ?>" class="btn btn-xs btn-light text-1 text-uppercase">Read More</a></span>
                        </div>
                    </div>
                </div>
            </article>
<?php endforeach; ?>

<?php if(isset($data['blog_data']['posts']) && count($data['blog_data']['posts']) <= 0): ?>
    <center><small class="text-muted"><i>No post has been published yet.</i></small></center>
<?php endif; ?>
<div class="bg-light pt-4 px-3 my-3">
    <?= $data['blog_data']['pager']->makeLinks($data['blog_data']['page'], $data['blog_data']['perPage'], $data['blog_data']['total'], 'blog_pagination') ?>
</div>
            

        </div>
    </div>
</div>

</div>

			</div>
<?=$this->endSection()?>

<?=$this->section("bottomscripts")?>

<?=$this->endSection()?>