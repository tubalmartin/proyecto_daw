<?php $this->load->view('user/nav', $data) ?>

<div class="row align-items-center">
    <div class="col d-none d-md-block"></div>
    <div class="col-12 col-md-6 align-self-center">
        <?php $this->load->view('common/flash_messages') ?>

        <h4>Editar datos personales</h4>

        <?php $this->load->view('common/user_form', $data) ?>
    </div>
    <div class="col d-none d-md-block"></div>
</div>
