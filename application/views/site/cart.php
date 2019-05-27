<div class="row align-items-center ">
    <div class="col d-none d-md-block"></div>
    <div class="col-12 col-md-6 align-self-center">
        <?php $this->load->view('common/flash_messages') ?>

        <h4 class="mb-3">Contenido de la cesta</h4>

        <?php if(empty($this->cart->contents())): ?>
            <div class="alert alert-info" role="alert">
                Tu cesta está vacía
            </div>
        <?php else: ?>
            <?php foreach ($this->cart->contents() as $item): ?>
                <div class="row border-top py-2">
                    <div class="col-3">
                        <img src="<?php echo $item['image'] ?>" width="110">
                    </div>
                    <div class="col-9">
                        <p class="mb-1">Título: <a href="<?php echo site_url('/site/movie/'.$item['movie_id']) ?>"><?php echo $item['name'] ?></a></p>
                        <p class="mb-1">Formato: <?php echo $item['format'] ?></p>
                        <p class="mb-1">Precio unidad: <b><?php echo $this->cart->format_number($item['price']) ?>€</b></p>
                        <form action="<?php echo site_url('/site/updatecart') ?>" method="POST" class="form-inline mb-1">
                            <input type="hidden" name="rowid" value="<?php echo $item['rowid'] ?>">
                            <label class="mr-2">Cantidad:</label>
                            <select name="qty" class="custom-select mr-2">
                                <?php for($i = 0; $i <= 10; $i++): ?>
                                    <option value="<?php echo $i ?>" <?php if($item['qty'] == $i): ?>selected<?php endif; ?>><?php echo $i ?></option>
                                <?php endfor; ?>
                            </select>
                            <button type="submit" class="btn btn-warning btn-sm">Actualizar</button>
                        </form>
                        <p class="mb-0">Subtotal: <b><?php echo $this->cart->format_number($item['subtotal']) ?>€</b></p>
                    </div>
                </div>
            <?php endforeach; ?>
            <div class="row border-top py-2">
                <div class="col-9 offset-3">
                    <p><b>Total: <?php echo $this->cart->format_number($this->cart->total()); ?>€</b></p>
                    <p>
                        <a class="btn btn-warning btn-lg" href="<?php echo site_url('/site/checkout') ?>">Pasar por caja</a> o <a class="btn btn-light btn-sm" href="<?php echo site_url('/site/store'); ?>">Seguir comprando</a>
                    </p>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <div class="col d-none d-md-block"></div>
</div>