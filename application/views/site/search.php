<?php $this->load->view('site/search_form', $data); ?>

<h2>Resultados</h2>
<div class="row">
    <?php
    $i = 0;
    foreach($results as $result): $i++; ?>
        <div class="col-6">
            <?php
                $result['media_type'] === 'movie'
                    ? $this->load->view('common/movie_card', ['movie' => $result])
                    : $this->load->view('common/person_card', ['person' => $result])
            ?>
        </div>
        <?php if ($i % 2 === 0): ?>
            <div class="w-100"></div>
        <?php endif; ?>
    <?php endforeach; ?>
</div>

<?php $this->load->view('site/pagination'); ?>