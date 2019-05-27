<div class="header row p-2 mb-3 border-bottom">
    <div class="col-12 col-md-4">
        <h1>
            <a class="logo-link text-white" href="<?php echo site_url() ?>">CineManía</a>
        </h1>
    </div>
    <div class="col-12 col-md-8 clearfix">
        <ul class="nav nav-pills float-left float-sm-right mt-2">
            <li class="nav-item">
                <a class="nav-link <?php if($page_id === 'home'): ?>active<?php endif; ?>" href="<?php echo site_url() ?>"><i class="fas fa-home"></i></a>
            </li>
            <?php if($this->session->userdata('is_admin') !== true): ?>
            <li class="nav-item">
                <a class="nav-link <?php if($page_id === 'store'): ?>active<?php endif; ?>" href="<?php echo site_url('/site/store') ?>"><i class="fas fa-store"></i> Tienda</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php if($page_id === 'cart'): ?>active<?php endif; ?>" href="<?php echo site_url('/site/cart') ?>"><i class="fas fa-shopping-cart"></i> Cesta</a>
            </li>
            <?php endif; ?>
            <?php if(is_null($this->session->userdata('user_id'))): ?>
                <li class="nav-item">
                    <a class="nav-link <?php if($page_id === 'login'): ?>active<?php endif; ?>" href="<?php echo site_url('/site/login') ?>"><i class="fas fa-sign-in-alt"></i> Iniciar sesión</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if($page_id === 'register'): ?>active<?php endif; ?>" href="<?php echo site_url('/site/register') ?>"><i class="fas fa-user-plus"></i> Registrarse</a>
                </li>
            <?php else: ?>
                <li class="nav-item">
                    <a class="nav-link <?php if($page_id === 'account'): ?>active<?php endif; ?>" href="<?php echo site_url('/'.$this->session->userdata('user_type')) ?>"><i class="fas fa-user"></i> <?php echo $this->session->userdata('user_name') ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo site_url('/site/logout') ?>"><i class="fas fa-sign-out-alt"></i> Cerrar sesión</a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</div>