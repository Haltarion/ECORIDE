<div class="component__input-email">
    <label for="<?= $inputId ?>"><?php echo $label ?></label>
    <input type="mail" id="<?= $inputId ?>" placeholder="<?= $placeholder ?>" required>
    <?php include '../components/form/error-alerte.php'; ?>
</div>