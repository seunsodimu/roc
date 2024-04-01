<div class="col-lg-3">
        <aside class="sidebar">
            <form action="page-search-results.html" method="get">
                <div class="input-group mb-3 pb-1">
                    <input class="form-control text-1" placeholder="Search..." name="s" id="s" type="text">
                    <button type="submit" class="btn btn-dark text-1 p-2"><i class="fas fa-search m-2"></i></button>
                </div>
            </form>
            <h5 class="font-weight-semi-bold pt-4">Categories</h5>
            <ul class="nav nav-list flex-column mb-5">
                <?php foreach ($data['blog_data']['categories'] as $category) : ?>
                <li class="nav-item"><a class="nav-link" href="<?= base_url('blog/category/'.$category['id']) ?>"><?= $category['name'] ?></a></li>
                <?php endforeach; ?>
                <li class="nav-item"><a class="nav-link" href="<?= base_url('blog') ?>">All Categories</a></li>
            </ul>
            </aside>
    </div>