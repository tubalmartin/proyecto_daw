<form action="<?php echo site_url($moviedb_search_form['action']) ?>" method="POST">
    <div class="input-group mb-3">
        <input name="query" type="text" class="form-control" value="<?php echo $moviedb_search_form['query']; ?>" placeholder="Busca por nombre de película, actor o director">
        <div class="input-group-append">
            <button class="btn btn-outline-secondary" type="submit">Buscar</button>
        </div>
    </div>
</form>