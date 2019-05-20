<div class="header row p-2 mb-3 border-bottom">
    <div class="col-12 col-md-4">
        <h1>
            <a class="logo-link text-white" href="<?php echo site_url() ?>">CineManía</a>
        </h1>
    </div>
    <div class="col-12 col-md-8 clearfix">
        <ul class="nav nav-pills float-left float-sm-right mt-2">
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