<div class="row">
    <div class="col">
        <?php $this->load->view('common/search_moviedb_form', $data); ?>
    </div>
</div>
<h2>Estrenos populares</h2>
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