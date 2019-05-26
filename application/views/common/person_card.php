<div class="person_card card mb-3">
    <div class="row no-gutters">
        <div class="col-4">
            <a href="<?php echo site_url('/site/person/'.$person['id']) ?>">
                <img class="card-img" src="<?php echo $person['profile_path'] ?>" title="Imagen de <?php echo $person['name'] ?>" alt="Imagen de <?php echo $person['name'] ?>">
            </a>
        </div>
        <div class="col-8">
            <div class="card-body">
                <h5 class="card-title"><a href="<?php echo site_url('/site/person/'.$person['id']) ?>"><?php echo $person['name'] ?></a></h5>
                <p class="card-text"><a href="<?php echo site_url('/site/person/'.$person['id']) ?>"><small>Más información</small></a></p>
            </div>
        </div>
    </div>
</div>
