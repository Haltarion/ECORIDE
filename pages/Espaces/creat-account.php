<?php include '../../common/head.php'; ?>

<body>

  <?php include '../../common/header.php'; ?>

  <h1>Créer un compte</h1>

  <?php
    $inputId = "pseudo";
    $label = "Pseudo";
    $placeholder = "Entrez votre pseudonyme";
    $required ="required";
    $alertMessage = "Merci de renseigner un Pseudo";
    include "../../components/form/input-text.php";
  ?>
  <?php
    $alertMessage = "Merci de rentrer un email valide";
    include "../../components/form/input-email.php";
  ?>
  <?php
    include "../../components/form/input-mdp.php";
  ?>
  <?php
    $class ="btn btn-main";
    $buttonText ="Valider et créditer 20 crédits";
    include "../../components/clicable/button.php";
  ?>

</body>

<?php include '../../common/footer.php'; ?>
