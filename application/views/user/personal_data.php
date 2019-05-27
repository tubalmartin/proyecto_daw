<?php $this->load->view('user/nav', $data) ?>

<div class="row align-items-center">
    <div class="col d-none d-md-block"></div>
    <div class="col-12 col-md-6 align-self-center">
        <?php $this->load->view('common/flash_messages') ?>

        <h4 class="mb-3">Datos personales</h4>

        <p>Nombre: <?php echo $user['name'] ?></p>
        <p>Apellidos: <?php echo $user['surname'] ?></p>
        <p>Teléfono: <?php echo $user['phone'] ?></p>
        <p>Email: <?php echo $user['email'] ?></p>
        <p>Dirección: <?php echo $user['address'] ?></p>
        <p>Código postal: <?php echo $user['postal_code'] ?></p>
        <p>Ciudad: <?php echo $user['city'] ?></p>
        <hr>
        <p><a href="<?php echo site_url('/user/edit') ?>" class="btn btn-primary">Editar</a></p>
    </div>
    <div class="col d-none d-md-block"></div>
</div>
