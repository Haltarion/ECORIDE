<?php include '../../common/head.php'; ?>

<body>

  <?php include '../../common/header.php'; ?>

  <h1>Gestion de mes véhicules</h1>
  <div class="container f-col just-start w-100 g-10 p-20 al-sb">
    <h2>Modification du véhicule</h2>
    <?php
    $inputId = "imatriculation";
    $label = "Plaque d'immatriculation*";
    $placeholder = "AA-111-BB";
    $required = "required";
    $alertMessage = "Le format de la plaque d'immatriculation n'est pas valide";
    include '../../components/form/input-text.php';
    ?>
    <?php
    $inputDateId = "premiereImatriculation";
    $labelDate = "Date de première immatriculation*";
    $inputDateName = "premiereImatriculation";
    include '../../components/form/input-date.php';
    ?>
    <?php
    $inputId = "marque";
    $label = "Marque du véhicule*";
    $placeholder = "Marque du véhicule";
    $required = "required";
    $alertMessage = "Merci de renseigner la marque de votre véhicule";
    include '../../components/form/input-text.php';
    ?>
    <?php
    $inputId = "couleur";
    $label = "Couleur du véhicule*";
    $placeholder = "Couleur du véhicule";
    $required = "required";
    $alertMessage = "Merci de renseigner la couleur de votre véhicule";
    include '../../components/form/input-text.php';
    ?>
    <?php
    $inputId = "placesDispo";
    $label = "Nombre de places disponibles*";
    $value = "2";
    $required = "required";
    $alertMessage = "Merci de renseigner le nombre de places disponibles";
    include '../../components/form/input-number.php';
    ?>
    <div class="container f-row just-sb g-10 w-100 ">
      <a href="../../pages/espaces/user.php" class="btn btn-annul">Annuler</a>
      <?php
      $class = "btn btn-main mh-50";
      $buttonText = "Modifier";
      include '../../components/clicable/button.php';
      ?>
    </div>
  </div>
</body>

<?php include '../../common/footer.php'; ?>