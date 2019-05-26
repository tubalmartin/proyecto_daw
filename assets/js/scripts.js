$(function(){
    // Form validation
    $('form.needs-validation').on('submit', function(e) {
        var $form = $(this);
        if ($form.get(0).checkValidity() === false) {
            e.preventDefault();
            e.stopPropagation();
        }
        $form.addClass('was-validated');
    });

    $('#search_form[data-async]').on('submit', function(e){
        var $form = $(this);
        var $submitButton = $form.find('[type="submit"]');

        e.preventDefault();
        e.stopPropagation();

        if ($form.get(0).checkValidity() === false) {
            return false;
        }

        $submitButton.attr('disabled', true);

        $.post($form.attr('action'), {query: $form.find('input[name=query]').val()}, function(data){
            var opts = [];
            var $targetDropwdown = $($form.attr('data-results-dropdown'));
            var resultsType = $form.attr('data-results-type');

            Array.isArray(data) && data.reduce(function(acc, cur) {
                if (cur['media_type'] === resultsType) {
                    var optName = cur['media_type'] === 'movie'
                        ? cur.title + (cur.release_date ? ' ('+ cur.release_date.substring(0, 4) +')' : '')
                        : cur.name;
                    acc.push('<option value="'+ cur.id +'">'+ optName +'</option>');
                }
                return acc;
            }, opts);

            $targetDropwdown.html(opts.join('')).attr('disabled', false);
            $submitButton.attr('disabled', false);
        }, 'json');
    });
});