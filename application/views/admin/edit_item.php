<?php $this->load->view('admin/nav', $data) ?>

<div class="row align-items-center">
    <div class="col d-none d-md-block"></div>
    <div class="col-12 col-md-6 align-self-center">
        <?php $this->load->view('common/flash_messages') ?>

        <h4 class="mb-3">Asignar precios a película y publicar en la tienda</h4>

        <?php $this->load->view('common/validation_errors') ?>

        <h6><?php echo $movie['name'] ?></h6>
        <?php echo form_open('/admin/createitem/'.$movie['id'], ['class' => 'needs-validation', 'novalidate' => '']); ?>
            <div class="form-group">
                <label for="dvdprice">Precio DVD</label>
                <div class="input-group">
                    <input type="text" class="form-control" name="dvdprice" id="dvdprice" value="<?php echo set_value('dvdprice', $prices['dvd']); ?>" >
                    <div class="input-group-append">
                        <div class="input-group-text">€</div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="blurayprice">Precio Blu-Ray</label>
                <div class="input-group">
                    <input type="text" class="form-control" name="blurayprice" id="blurayprice" value="<?php echo set_value('blurayprice', $prices['bluray']); ?>" >
                    <div class="input-group-append">
                        <div class="input-group-text">€</div>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Publicar</button>
        </form>
    </div>
    <div class="col d-none d-md-block"></div>
</div>
