<?php $this->load->view('admin/nav', $data) ?>

<div class="row mb-3">
    <div class="col">
        <?php $this->load->view('common/flash_messages') ?>

        <h4>Películas en venta <a class="btn btn-success btn-sm ml-3" href="<?php echo site_url('/admin/registermovie') ?>"><i class="fas fa-plus"></i> Vender nueva película</a></h4>
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
                            <hr>
                            <small><b><?php echo $item['price'] ?>€</b> · <?php echo $item['format_name'] ?></small>
                            <br>
                            <a class="btn btn-primary btn-sm mt-1" href="<?php echo site_url('/admin/edititem/'.$item['movie_id']) ?>"><small><i class="fas fa-edit"></i> Editar</small></a>
                        </span>
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