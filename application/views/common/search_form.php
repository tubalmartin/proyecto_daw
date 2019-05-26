<?php echo form_open($search_form['action'], array_merge(['id' => 'search_form', 'class' => 'needs-validation', 'novalidate' => ''], $search_form['attributes'])) ?>
    <div class="input-group">
        <input name="query" type="text" class="form-control" value="<?php echo set_value('query'); ?>" required placeholder="Busca por nombre de película, actor o director">
        <div class="input-group-append">
            <button class="btn btn-outline-secondary" type="submit">
                <span class="spinner-border spinner-border-sm" role="status"></span>
                Buscar
            </button>
        </div>
    </div>
</form>