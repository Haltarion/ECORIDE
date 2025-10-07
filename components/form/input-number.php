<div class="f-col al-start w-100 mb-8">
  <label for="<?= $inputId ?>"><?php echo $label ?></label>
  <input type="number" id="<?= $inputId ?>" value="<?= $value ?>" min="<?= $min ?>" max="<?= $max ?>" <?= $required ?>>
  <?php include 'error-alerte.php'; ?>
</div>