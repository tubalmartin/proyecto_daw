<div class="row mb-3">
    <div class="col">
        <?php $this->load->view('common/flash_messages') ?>

        <h4>Confirmación de pedido</h4>
    </div>
</div>
<div class="row">
    <div class="col-12 col-md-6">
        <h5 class="mb-3">Tus datos de envío y facturación</h5>
        <p>Nombre: <?php echo $user['name'] ?> <?php echo $user['surname'] ?></p>
        <p>Dirección: <?php echo $user['address'] ?></p>
        <p>Código postal: <?php echo $user['postal_code'] ?></p>
        <p>Ciudad: <?php echo $user['city'] ?></p>
        <p>Teléfono: <?php echo $user['phone'] ?></p>
        <p>Email: <?php echo $user['email'] ?></p>
    </div>
    <div class="col-12 col-md-6">
        <h5>Artículos</h5>
        <?php foreach ($this->cart->contents() as $item): ?>
            <div class="row border-top py-2">
                <div class="col-3">
                    <img src="<?php echo $item['image'] ?>" width="90">
                </div>
                <div class="col-9">
                    <p class="mb-1">Título: <a href="<?php echo site_url('/site/movie/'.$item['movie_id']) ?>"><?php echo $item['name'] ?></a></p>
                    <p class="mb-1">Formato: <?php echo $item['format'] ?></p>
                    <p class="mb-1">Precio unidad: <b><?php echo $this->cart->format_number($item['price']) ?>€</b></p>
                    <p class="mb-1">Cantidad: <?php echo $item['qty'] ?></p>
                    <p class="mb-0">Subtotal: <b><?php echo $this->cart->format_number($item['subtotal']) ?>€</b></p>
                </div>
            </div>
        <?php endforeach; ?>
        <div class="row border-top py-2">
            <div class="col-9 offset-3">
                <p><b>Total: <?php echo $this->cart->format_number($this->cart->total()); ?>€</b></p>
                <p>
                    <a class="btn btn-warning btn-lg" href="<?php echo site_url('/site/order') ?>">Confirmar pedido</a> o <a class="btn btn-light btn-sm" href="<?php echo site_url('/site/cart'); ?>">Modificar cesta</a>
                </p>
            </div>
        </div>
    </div>
</div>