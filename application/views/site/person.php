<?php $this->load->view('site/search_form', $data); ?>

<div class="person-data row">
    <div class="col">
        <div class="media">
            <img src="<?php echo $person['profile_path'] ?>" class="main-img align-self-start mr-4">
            <div class="media-body">
                <h2 class="mt-0"><?php echo $person['name'] ?></h2>

                <p class="muted-text">
                    <small>
                        <strong>Conocido por:</strong> <?php echo $person['known_for_department'] ?>
                        <br>
                        <strong>Género:</strong> <?php echo $person['gender'] ?>
                        <br>
                        <strong>Fecha nacimiento:</strong> <?php echo nice_date($person['birthday'], 'd-m-Y') ?>
                        <br>
                        <strong>Lugar nacimiento:</strong> <?php echo $person['place_of_birth'] ?>
                        <br>
                    </small>
                </p>

                <?php if(!empty($person['biography'])): ?>
                    <h4>Biografía</h4>
                    <p><?php echo $person['biography'] ?></p>
                <?php endif; ?>

                <?php if(!empty($person['movie_credits']['cast'])): ?>
                    <h4>Últimos trabajos de interpretación</h4>
                    <div class="row">
                        <?php foreach($person['movie_credits']['cast'] as $cast): ?>
                            <?php if(!empty($cast['poster_path'])): ?>
                                <div class="col-3">
                                    <div class="media mb-3">
                                        <img src="<?php echo $cast['poster_path'] ?>" class="rounded mr-3" width="64">
                                        <div class="media-body">
                                            <a href="<?php echo site_url('/site/movie/'.$cast['id']) ?>">
                                                <small><?php echo $cast['title'] ?> <?php if(!empty($cast['release_date'])): echo '('.nice_date($cast['release_date'], 'Y').')'; endif; ?></small>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                <?php endif;  ?>

                <?php if(!empty($person['movie_credits']['crew']['directing'])): ?>
                    <h4>Últimos trabajos de dirección</h4>
                    <div class="row">
                        <?php foreach($person['movie_credits']['crew']['directing'] as $crew): ?>
                            <div class="col-3">
                                <div class="media mb-3">
                                    <img src="<?php echo $crew['poster_path'] ?>" class="rounded mr-3" width="64">
                                    <div class="media-body">
                                        <a href="<?php echo site_url('/site/movie/'.$crew['id']) ?>">
                                            <small><?php echo $crew['title'] ?> <?php if(!empty($crew['release_date'])): echo '('.nice_date($crew['release_date'], 'Y').')'; endif; ?></small>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <?php if(!empty($person['movie_credits']['crew']['production'])): ?>
                    <h4>Últimos trabajos de producción</h4>
                    <div class="row">
                        <?php foreach($person['movie_credits']['crew']['production'] as $crew): ?>
                            <div class="col-3">
                                <div class="media mb-3">
                                    <img src="<?php echo $crew['poster_path'] ?>" class="rounded mr-3" width="64">
                                    <div class="media-body">
                                        <a href="<?php echo site_url('/site/movie/'.$crew['id']) ?>">
                                            <small><?php echo $crew['title'] ?> <?php if(!empty($crew['release_date'])): echo '('.nice_date($crew['release_date'], 'Y').')'; endif; ?></small>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>