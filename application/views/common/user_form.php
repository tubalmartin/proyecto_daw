<?php $this->load->view('common/validation_errors') ?>

<?php echo form_open($user_form['action'], array_merge(['class' => 'needs-validation', 'novalidate' => ''], $user_form['attributes'])) ?>

    <fieldset>
        <legend>Datos acceso</legend>
        <div class="form-group">
            <label>Email</label>
            <input type="email" class="form-control" name="email" value="<?php echo set_value('email', isset($user['email']) ? $user['email'] : '') ?>" required>
        </div>
        <?php if($user_form['registration_form'] === true): ?>
        <div class="form-group">
            <label>Contraseña</label>
            <input type="password" class="form-control" name="password" value="<?php echo set_value('password') ?>" required>
        </div>
        <?php endif; ?>
    </fieldset>

    <fieldset>
        <legend>Datos personales</legend>
        <div class="form-group">
            <label>Nombre</label>
            <input type="text" class="form-control" name="name" value="<?php echo set_value('name', isset($user['name']) ? $user['name'] : '') ?>" required>
        </div>
        <div class="form-group">
            <label>Apellidos</label>
            <input type="text" class="form-control" name="surname" value="<?php echo set_value('surname', isset($user['surname']) ? $user['surname'] : '') ?>" required>
        </div>
        <div class="form-group">
            <label>Teléfono</label>
            <input type="text" class="form-control" name="phone" value="<?php echo set_value('phone', isset($user['phone']) ? $user['phone'] : '') ?>" required minlength="9" maxlength="12">
        </div>
        <div class="form-group">
            <label>Dirección</label>
            <input type="text" class="form-control" name="address" value="<?php echo set_value('address', isset($user['address']) ? $user['address'] : '') ?>" required>
        </div>
        <div class="form-group">
            <label>Código postal</label>
            <input type="text" class="form-control" name="postal_code" value="<?php echo set_value('postal_code', isset($user['postal_code']) ? $user['postal_code'] : '') ?>" required minlength="5" maxlength="5">
        </div>
        <div class="form-group">
            <label>Ciudad</label>
            <input type="text" class="form-control" name="city" value="<?php echo set_value('city', isset($user['city']) ? $user['city'] : '') ?>" required>
        </div>
    </fieldset>

    <button type="submit" class="btn btn-primary"><?php echo $user_form['submit_button_text'] ?></button>

</form>