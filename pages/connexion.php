<?php include '../common/header.php'; ?>
    <h1 class="connexion">Se connecter</h1>
    <?php
      $alertMessage = "Merci de rentrer un email valide.";
      include '../components/form/input-email.php';
    ?>
    <?php include '../components/form/input-mdp.php'; ?>
    <div class="container__button">
        <?php include '../components/clicable/button.php' ?>
    </div>
<?php include '../common/footer.php'; ?>
