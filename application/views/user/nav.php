<div class="row mb-4">
    <div class="col">
        <ul class="nav nav-pills">
            <li class="nav-item">
                <a class="nav-link <?php if($subpage_id === 'personal_data'): ?>active<?php endif; ?>" href="<?php echo site_url('/user') ?>">Datos personales</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php if($subpage_id === 'orders'): ?>active<?php endif; ?>" href="<?php echo site_url('/user/orders') ?>">Pedidos</a>
            </li>
        </ul>
    </div>
</div>