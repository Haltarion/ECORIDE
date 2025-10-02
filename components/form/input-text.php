<div class="f-col al-start w-100 mb-8">
  <label for="<?= $inputId ?>"><?php echo $label ?></label>
  <input type="text" id="<?= $inputId ?>" placeholder="<?= $placeholder ?>" value="" <?= $required ?>>
  <?php include 'error-alerte.php'; ?>
</div>