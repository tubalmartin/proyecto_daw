<div class="row mb-3">
    <div class="col">
        <?php if(!is_null($this->session->flashdata('item_added_message'))): ?>
            <div class="alert alert-success" role="alert">
                <?php echo $this->session->flashdata('item_added_message') ?>
            </div>
        <?php endif; ?>
        <?php if(!is_null($this->session->flashdata('item_not_added_message'))): ?>
            <div class="alert alert-warning" role="alert">
                <?php echo $this->session->flashdata('item_not_added_message') ?>
            </div>
        <?php endif; ?>

        <h4>Películas en venta</h4>
    </div>
</div>
<div class="row mb-4">
    <div class="col">
        <ul class="nav nav-pills">
            <li class="nav-item">
                <a class="nav-link <?php if($subpage_id === 'bluray'): ?>active<?php endif; ?>" href="<?php echo site_url('/site/store/bluray') ?>">Blu-Ray</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php if($subpage_id === 'dvd'): ?>active<?php endif; ?>" href="<?php echo site_url('/site/store/dvd') ?>">DVD</a>
            </li>
        </ul>
    </div>
</div>
<?php if(!empty($items)): ?>
    <div class="row">
        <?php
        foreach($items as $item): ?>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-2">


                <div class="card">
                    <a href="<?php echo site_url('/site/movie/'.$item['movie_id']) ?>">
                        <img src="<?php echo $item['image'] ?>" class="card-img-top">
                    </a>
                    <span class="card-body">
                        <span class="card-text">
                            <a href="<?php echo site_url('/site/movie/'.$item['movie_id']) ?>"><small><?php echo $item['name'] ?></small></a>
                        </span>
                        <form action="<?php echo site_url('/site/addtocart') ?>" method="POST">
                            <input type="hidden" name="id" value="<?php echo $item['id'] ?>">
                            <div class="form-inline">
                                <p class="mt-2 mb-1">Precio: <b><?php echo $item['price'] ?>€</b>/ud</p>
                                <label class="mr-2">Cantidad:</label>
                                <select name="qty" class="custom-select">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-warning btn-sm mt-2">
                                <i class="fas fa-shopping-cart"></i> Añadir a la cesta
                            </button>
                        </form>
                    </span>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>