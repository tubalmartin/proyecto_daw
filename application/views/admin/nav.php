<div class="row mb-4">
    <div class="col">
        <ul class="nav nav-pills">
            <li class="nav-item">
                <a class="nav-link <?php if($subpage_id === 'orders'): ?>active<?php endif; ?>" href="<?php echo site_url('/admin/orders') ?>">Pedidos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php if($subpage_id === 'storeitems'): ?>active<?php endif; ?>" href="<?php echo site_url('/admin/storeitems') ?>">Artículos tienda</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php if($subpage_id === 'users'): ?>active<?php endif; ?>" href="<?php echo site_url('/admin/users') ?>">Populares</a>
            </li>
        </ul>
    </div>
</div>