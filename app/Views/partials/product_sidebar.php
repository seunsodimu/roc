<aside class="sidebar">
                <form action="<?= base_url('search') ?>" method="get">
                    <div class="input-group mb-3 pb-1">
                        <input class="form-control text-1" placeholder="Search..." name="q" id="s" type="text">
                        <button type="submit" class="btn btn-dark text-1 p-2"><i class="fas fa-search m-2"></i></button>
                    </div>
                </form>
                <h5 class="font-weight-semi-bold pt-3">Categories</h5>
                <ul class="nav nav-list flex-column">
                    <?php foreach ($data['collections'] as $collection) : ?>
                        <li class="nav-item"><a class="nav-link" href="<?= base_url('products/collections/'.$collection['slug']) ?>"><?= $collection['name']."(".$collection['product_count'].")" ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </aside>