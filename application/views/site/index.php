<?php $this->load->view('site/search_form', $data); ?>

<div class="row mb-4">
    <div class="col">
        <ul class="nav nav-pills">
            <li class="nav-item">
                <a class="nav-link <?php if($subpage_id === 'nowplaying'): ?>active<?php endif; ?>" href="<?php echo site_url('/site/nowplaying') ?>">En cines</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php if($subpage_id === 'upcoming'): ?>active<?php endif; ?>" href="<?php echo site_url('/site/upcoming') ?>">Próximamente</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php if($subpage_id === 'popular'): ?>active<?php endif; ?>" href="<?php echo site_url('/site/popular') ?>">Populares</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php if($subpage_id === 'toprated'): ?>active<?php endif; ?>" href="<?php echo site_url('/site/toprated') ?>">Top valoradas</a>
            </li>
        </ul>
    </div>
</div>

<div class="row">
<?php
    $i = 0;
    foreach($movies as $movie): $i++; ?>
        <div class="col-6">
            <?php $this->load->view('common/movie_card', ['movie' => $movie]); ?>
        </div>
    <?php if ($i % 2 === 0): ?>
        <div class="w-100"></div>
    <?php endif; ?>
<?php endforeach; ?>
</div>

<?php $this->load->view('site/pagination'); ?>