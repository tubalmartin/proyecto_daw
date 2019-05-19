<form action="<?php echo site_url($search_form['action']) ?>" method="POST">
    <div class="input-group">
        <input name="query" type="text" class="form-control" value="<?php echo $search_form['query']; ?>" placeholder="Busca por nombre de película, actor o director">
        <div class="input-group-append">
            <button class="btn btn-outline-secondary" type="submit">Buscar</button>
        </div>
    </div>
</form>