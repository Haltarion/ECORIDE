<div class="f-col al-start w-100">
    <!-- Label principal ---------------------------------------->
    <label for="<?= $inputIdMain ?>"><?php echo $labelMain ?></label>
    <!-- Conteneur des 3 champs --------------------------------->
    <div class="component__input-date__container w-100">
        <!-- Champ jour --------------------------------------------->
        <div class="component__input-date__container__day">
            <label for="<?= $inputIdDay ?>"><?php echo $labelDay ?></label>
            <input type="text" id="<?= $inputIdDay ?>" placeholder="<?= $placeholderDay ?>" required>
        </div>
        <!-- Champ mois --------------------------------------------->
        <div class="component__input-date__container__month">
            <label for="<?= $inputIdMonth ?>"><?php echo $labelMonth ?></label>
            <input type="text" id="<?= $inputIdMonth ?>" placeholder="<?= $placeholderMonth ?>" required>
        </div>
        <!-- Champ année -------------------------------------------->
        <div class="component__input-date__container__year">
            <label for="<?= $inputIdYear ?>"><?php echo $labelYear ?></label>
            <input type="text" id="<?= $inputIdYear ?>" placeholder="<?= $placeholderYear ?>" required>
        </div>
    </div>
    <!-- Message d'alerte --------------------------------------------->
    <?php include 'C:/Users/micha/OneDrive/Documents/GitHub/ECORIDE/components/form/error-alerte.php'; ?>
</div>