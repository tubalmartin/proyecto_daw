<div class="movie-data row">
    <div class="col">
        <div class="media">
            <img src="<?php echo $movie['poster_path'] ?>" class="align-self-start mr-4" alt="">
            <div class="media-body">
                <h2 class="mt-0"><?php echo $movie['title'] ?> (<?php echo nice_date($movie['release_date'], 'Y') ?>)</h2>
                <p><?php echo $movie['overview'] ?></p>
                <p>Fecha estreno: <?php echo nice_date($movie['release_date'], 'd-m-Y') ?></p>
                <h4>Género</h4>
                <ul>
                <?php foreach($movie['genres'] as $genre): ?>
                    <li><?php echo $genre['name'] ?></li>
                <?php endforeach; ?>
                </ul>
                <h4>Directores</h4>
                <div class="row">
                    <?php foreach($movie['credits']['crew'] as $director): ?>
                        <div class="col-3">
                            <div class="media mb-3">
                                <img src="<?php echo $director['profile_path'] ?>" class="rounded mr-3" width="64">
                                <div class="media-body">
                                    <?php echo $director['name'] ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <h4>Reparto principal</h4>
                <div class="row">
                    <?php foreach($movie['credits']['cast'] as $cast): ?>
                        <div class="col-3">
                            <div class="media mb-3">
                                <img src="<?php echo $cast['profile_path'] ?>" class="rounded mr-3" width="64">
                                <div class="media-body">
                                    <?php echo $cast['name'] ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>