<?php $this->load->view('user/nav', $data) ?>

<div class="row align-items-center">
    <div class="col d-none d-lg-block"></div>
    <div class="col-12 col-lg-9 align-self-center">
        <?php $this->load->view('common/flash_messages') ?>

        <h4 class="mb-3">Pedido <?php echo $order['id'] ?></h4>
        <p>Fecha realización: <?php echo date('d-m-Y g:i A', strtotime($order['date'])) ?></p>
        <p>Cantidad total pagada: <b><?php echo $order['total_price'] ?>€</b></p>
        <p>Estado: <span class="badge badge-info p-1"><?php echo $order['status'] ?></span></p>

        <h5>Artículos del pedido</h5>
        <table class="table">
            <thead>
            <tr>
                <th>Poster</th>
                <th>Nombre</th>
                <th>Formato</th>
                <th>Cantidad</th>
                <th>Precio ud.</th>
                <th>Subtotal</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($order_items as $key => $item): ?>
                <tr>
                    <td><img src="<?php echo $item['movie_image'] ?>" width="60"></td>
                    <td><a href="<?php echo site_url('/site/movie/'.$item['movie_id']) ?>"><?php echo $item['movie_name'] ?></a></td>
                    <td><?php echo $item['movie_format'] ?></td>
                    <td><?php echo $item['item_qty'] ?></td>
                    <td><?php echo $item['item_price'] ?>€</td>
                    <td><?php echo $item['item_price'] * $item['item_qty'] ?>€</td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="col d-none d-lg-block"></div>
</div>