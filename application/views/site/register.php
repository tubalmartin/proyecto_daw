<div class="row align-items-center mt-5 mb-5">
    <div class="col d-none d-md-block"></div>
    <div class="col-12 col-md-8 col-lg-6 align-self-center">
        <?php $this->load->view('common/flash_messages') ?>

        <h4>Registro de usuario</h4>

        <?php $this->load->view('common/user_form', $data) ?>
    </div>
    <div class="col d-none d-md-block"></div>
</div>
