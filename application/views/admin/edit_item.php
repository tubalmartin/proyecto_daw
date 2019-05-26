<?php $this->load->view('admin/nav', $data) ?>

<div class="row">
    <div class="col">
        <?php if(!is_null($this->session->flashdata('success_message'))): ?>
            <div class="alert alert-success" role="alert">
                <?php echo $this->session->flashdata('success_message') ?>
            </div>
        <?php endif; ?>

        <h4>Asignar precios a película y publicar en la tienda</h4>

        <?php $this->load->view('common/validation_errors') ?>
        <?php echo form_open('/admin/createitem/'.$movie['id'], ['class' => 'needs-validation', 'novalidate' => '']); ?>
            <div class="form-group">
                <label for="dvdprice">Precio DVD</label>
                <div class="input-group">
                    <input type="text" class="form-control" name="dvdprice" id="dvdprice" value="<?php echo set_value('dvdprice', $prices['dvd']); ?>" required>
                    <div class="input-group-append">
                        <div class="input-group-text">€</div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="blurayprice">Precio Blu-Ray</label>
                <div class="input-group">
                    <input type="text" class="form-control" name="blurayprice" id="blurayprice" value="<?php echo set_value('blurayprice', $prices['bluray']); ?>" required>
                    <div class="input-group-append">
                        <div class="input-group-text">€</div>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Publicar</button>
        </form>

    </div>
</div>
