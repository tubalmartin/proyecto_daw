<?php if(!is_null($this->session->flashdata('success_message'))): ?>
    <div class="alert alert-success" role="alert">
        <?php echo $this->session->flashdata('success_message') ?>
    </div>
<?php endif; ?>
<?php if(!is_null($this->session->flashdata('warn_message'))): ?>
    <div class="alert alert-warning" role="alert">
        <?php echo $this->session->flashdata('warn_message') ?>
    </div>
<?php endif; ?>
<?php if(!is_null($this->session->flashdata('error_message'))): ?>
    <div class="alert alert-error" role="alert">
        <?php echo $this->session->flashdata('error_message') ?>
    </div>
<?php endif; ?>