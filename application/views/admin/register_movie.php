<?php $this->load->view('admin/nav', $data) ?>

<div class="row">
    <div class="col">
        <?php if(!is_null($this->session->flashdata('error_message'))): ?>
            <div class="alert alert-error" role="alert">
                <?php echo $this->session->flashdata('error_message') ?>
            </div>
        <?php endif; ?>

        <h4>Registrar película</h4>

        <?php $this->load->view('common/validation_errors') ?>

        <p>Busca la película:</p>
        <?php $this->load->view('common/search_form', $data) ?>

        <div class="mt-3">
            <?php echo form_open('/admin/registermovie', ['class' => 'needs-validation', 'novalidate' => '']); ?>
                <div class="form-group">
                    <label for="movie">Selecciona la película</label>
                    <select name="id" id="movie" class="custom-select" disabled required></select>
                </div>
                <button type="submit" class="btn btn-primary">Registrar</button>
            </form>
        </div>
    </div>
</div>
