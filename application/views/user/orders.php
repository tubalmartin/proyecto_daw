<?php $this->load->view('user/nav', $data) ?>

<div class="row align-items-center">
    <div class="col d-none d-lg-block"></div>
    <div class="col-12 col-lg-8 align-self-center">
        <?php $this->load->view('common/flash_messages') ?>

        <h4 class="mb-3">Pedidos realizados</h4>

        <?php if(empty($orders)): ?>
            <div class="alert alert-warning" role="alert">
                No has realizado ningún pedido
            </div>
        <?php else: ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                        <th colspan="2">Cantidad pagada</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($orders as $order): ?>
                        <tr>
                            <td><?php echo $order['id'] ?></td>
                            <td><?php echo date('d-m-Y g:i A', strtotime($order['date'])) ?></td>
                            <td><?php echo $order['status'] ?></td>
                            <td><?php echo $order['total_price'] ?>€</td>
                            <td><a href="<?php echo site_url('/user/order/'.$order['id']) ?>">Ver pedido</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
    <div class="col d-none d-lg-block"></div>
</div>