<?php $this->load->view('admin/nav', $data) ?>

<div class="row">
    <div class="col">
        <?php $this->load->view('common/flash_messages') ?>

        <h4 class="mb-3">Pedidos realizados</h4>

        <?php if(empty($orders)): ?>
            <div class="alert alert-warning" role="alert">
                No se ha realizado ningún pedido aún
            </div>
        <?php else: ?>
            <table class="table">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Fecha</th>
                    <th>Cliente</th>
                    <th>Estado</th>
                    <th colspan="2">Cantidad pagada</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($orders as $order): ?>
                    <tr>
                        <td><?php echo $order['id'] ?></td>
                        <td><?php echo date('d-m-Y g:i A', strtotime($order['date'])) ?></td>
                        <td><?php echo $order['user_name'] ?> <?php echo $order['user_surname'] ?></td>
                        <td><?php echo $order['status'] ?></td>
                        <td><?php echo $order['total_price'] ?>€</td>
                        <td><a href="<?php echo site_url('/admin/order/'.$order['id']) ?>">Ver pedido</a></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>