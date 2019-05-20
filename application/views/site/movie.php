<?php $this->load->view('site/search_form', $data); ?>

<div class="movie-data row">
    <div class="col-12 col-md-3 mb-3">
        <h2 class="mt-0 d-md-none"><?php echo $movie['title'] ?> (<?php echo nice_date($movie['release_date'], 'Y') ?>)</h2>
        <img src="<?php echo $movie['poster_path'] ?>" class="align-self-start mr-4">
    </div>
    <div class="col-12 col-md-9">
        <h2 class="mt-0 d-none d-md-block"><?php echo $movie['title'] ?> (<?php echo nice_date($movie['release_date'], 'Y') ?>)</h2>
        <p class="muted-text">
            <small>
            <?php if(!empty($movie['release_date'])): ?>
                Fecha estreno: <?php echo nice_date($movie['release_date'], 'd-m-Y'); ?>
            <?php endif; ?>
            <?php if(!empty($movie['runtime'])): ?>
                <br>
                Duración: <?php echo $movie['runtime'] ?> minutos
            <?php endif; ?>
            </small>
        </p>

        <?php if(!empty($movie['overview'])): ?>
            <h4>Sinopsis</h4>
            <p><?php echo $movie['overview'] ?></p>
        <?php endif; ?>

        <?php if(!empty($movie['genres'])): ?>
            <h4>Género</h4>
            <ul>
            <?php foreach($movie['genres'] as $genre): ?>
                <li><?php echo $genre['name'] ?></li>
            <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <?php if(!empty($movie['credits']['crew'])): ?>
            <h4>Directores</h4>
            <div class="row">
                <?php foreach($movie['credits']['crew'] as $director): ?>
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="media mb-3">
                            <img src="<?php echo $director['profile_path'] ?>" class="rounded mr-3" width="64">
                            <div class="media-body">
                                <a href="<?php echo site_url('/site/person/'.$director['id']) ?>">
                                    <?php echo $director['name'] ?>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if(!empty($movie['credits']['cast'])): ?>
            <h4>Reparto principal</h4>
            <div class="row">
                <?php foreach($movie['credits']['cast'] as $cast): ?>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                        <div class="media mb-3">
                            <img src="<?php echo $cast['profile_path'] ?>" class="rounded mr-3" width="64">
                            <div class="media-body">
                                <a href="<?php echo site_url('/site/person/'.$cast['id']) ?>"><?php echo $cast['name'] ?></a><br>
                                <small><?php echo $cast['character'] ?></small>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php if(!empty($movie['similar']['results'])): ?>
    <div class="row mt-3">
        <div class="col">
            <h4>Películas similares</h4>
        </div>
    </div>
    <div class="row">
        <?php
        foreach($movie['similar']['results'] as $similarMovie): ?>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-2">
                <div class="card">
                    <a href="<?php echo site_url('/site/movie/'.$similarMovie['id']) ?>">
                        <img src="<?php echo $similarMovie['poster_path'] ?>" class="card-img-top">
                    </a>
                    <span class="card-body">
                        <span class="card-text">
                            <a href="<?php echo site_url('/site/movie/'.$similarMovie['id']) ?>"><small><?php echo $similarMovie['title'] ?></small></a>
                        </span>
                    </span>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>