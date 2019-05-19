<div class="movie_card card mb-3" style="max-width: 540px;">
    <div class="row no-gutters">
        <div class="col-4">
            <a href="<?php echo site_url('/site/movie/'.$movie['id']) ?>">
                <img class="card-img" src="<?php echo $movie['poster_path'] ?>" title="Poster de <?php echo $movie['title'] ?>" alt="Poster de <?php echo $movie['title'] ?>">
            </a>
        </div>
        <div class="col-8">
            <div class="card-body">
                <h5 class="card-title"><a href="<?php echo site_url('/site/movie/'.$movie['id']) ?>"><?php echo $movie['title'] ?></a></h5>
                <p class="card-text"><small><?php echo word_limiter($movie['overview'],40) ?></small></p>
                <?php if(!empty($movie['release_date'])): ?>
                    <p class="card-text"><small class="text-muted">Fecha de estreno: <?php echo nice_date($movie['release_date'], 'd-m-Y'); ?></small></p>
                <?php endif; ?>
                <p class="card-text"><a href="<?php echo site_url('/site/movie/'.$movie['id']) ?>"><small>Más información</small></a></p>
            </div>
        </div>
    </div>
</div>
