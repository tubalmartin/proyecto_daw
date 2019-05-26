<?php
    $verrors = validation_errors('<li>', '</li>');
    if (!empty($verrors)):
?>
    <div class="alert alert-warning" role="alert">
        <p class="mb-1"><strong>Revisa los datos introducidos</strong></p>
        <ul class="mb-0">
            <?php echo $verrors; ?>
        </ul>
    </div>
<?php endif; ?>