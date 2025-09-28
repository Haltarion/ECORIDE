<div class="f-col al-start w-100 mb-8">
  <label for="<?= $inputDateId ?>"><?php echo $labelDate ?></label>
  <input
    type="date"
    id="<?= $inputDateId ?>"
    name="<?= $inputDateName ?>"
    required
  >
  <!-- Message d'alerte --------------------------------------------->
  <?php include 'C:/Users/micha/OneDrive/Documents/GitHub/ECORIDE/components/form/error-alerte.php'; ?>
</div>
