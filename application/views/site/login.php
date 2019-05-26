<div class="row align-items-center mt-5 mb-5">
    <div class="col d-none d-md-block"></div>
    <div class="col-12 col-md-6 align-self-center">
        <?php $this->load->view('common/validation_errors') ?>
        <?php echo form_open('/site/login', ['class' => 'needs-validation', 'novalidate' => '']); ?>
            <div class="form-group">
                <label for="inputEmail1">Email</label>
                <input type="email" name="email" value="<?php echo set_value('email'); ?>" required class="form-control" id="inputEmail1" placeholder="Introduce tu correo electrónico">
            </div>
            <div class="form-group">
                <label for="inputPassword1">Contraseña</label>
                <input type="password" name="password" value="<?php echo set_value('password'); ?>" required class="form-control" id="inputPassword1" placeholder="Introduce tu contraseña">
            </div>
            <button type="submit" class="btn btn-primary">Iniciar sesión</button>
        </form>
    </div>
    <div class="col d-none d-md-block"></div>
</div>