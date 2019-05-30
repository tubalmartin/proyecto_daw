<?php $this->load->view('admin/nav', $data) ?>

<div class="row align-items-center">
    <div class="col d-none d-md-block"></div>
    <div class="col-12 col-md-6 align-self-center">
        <?php $this->load->view('common/flash_messages') ?>

        <h4 class="mb-3">Registrar película</h4>

        <?php $this->load->view('common/validation_errors') ?>

        <p>Busca la película:</p>
        <?php $this->load->view('common/search_form', $data) ?>

        <div class="mt-3">
            <?php echo form_open('/admin/registermovie', ['class' => 'needs-validation', 'novalidate' => '']); ?>
                <div class="form-group">
                    <label for="movie">Selecciona la película</label>
                    <select name="id" id="movie" class="custom-select" disabled required></select>
                </div>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Registrar</button>
            </form>
        </div>
    </div>
    <div class="col d-none d-md-block"></div>
</div>
