<div class="row mb-3">
    <div class="col">
        <?php $this->load->view('common/flash_messages') ?>

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
                                <p class="mt-2 mb-1">Precio: <b><?php echo $this->cart->format_number($item['price']) ?>€</b>/ud</p>
                                <label class="mr-2">Cantidad:</label>
                                <select name="qty" class="custom-select">
                                    <?php for($i = 1; $i <= 10; $i++): ?>
                                        <option value="<?php echo $i ?>"><?php echo $i ?></option>
                                    <?php endfor; ?>
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
<?php else: ?>
    <div class="row">
        <div class="col">
            <div class="alert alert-info" role="alert">
                No hay artículos en venta por ahora
            </div>
        </div>
    </div>
<?php endif; ?>
