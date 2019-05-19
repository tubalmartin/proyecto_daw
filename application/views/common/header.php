<div class="header row mb-3 border-bottom">
    <div class="col">
        <h1>
            <a class="logo-link" href="<?php echo site_url() ?>">Todo Cine</a>
        </h1>
    </div>
    <div class="col">
        <ul class="nav nav-pills justify-content-end mt-2">
            <li class="nav-item">
                <a class="nav-link <?php if($page_id === 'home'): ?>active<?php endif; ?>" href="<?php echo site_url() ?>">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php if($page_id === 'store'): ?>active<?php endif; ?>" href="<?php echo site_url('/store') ?>">Tienda</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php if($page_id === 'login'): ?>active<?php endif; ?>" href="<?php echo site_url('/login') ?>">Iniciar sesión</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php if($page_id === 'register'): ?>active<?php endif; ?>" href="<?php echo site_url('/register') ?>">Registrarse</a>
            </li>
        </ul>
    </div>
</div>