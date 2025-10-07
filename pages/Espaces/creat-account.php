<?php include '../../common/head.php'; ?>

<body>

  <?php include '../../common/header.php'; ?>
  <h1>Créer un compte</h1>
  <div class=" f-col g-20 al-center">
    <?php
    $inputId = "pseudo";
    $label = "Pseudo";
    $placeholder = "Entrez votre pseudonyme";
    $required = "required";
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
    <button class="btn btn-main maxw-400">Valider et créditer 20 crédits</button>
  </div>

</body>

<?php include '../../common/footer.php'; ?>