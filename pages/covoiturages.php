<?php include '../common/head.php'; ?>

<body>

  <?php include '../common/header.php'; ?>

  <h1>Rechercher un covoiturage</h1>

  <div class="covoiturageForm w-100 g-15 p-15 container">
    <fieldset>
      <legend>Départ</legend>
      <?php
      $label = "Quelle est votre adresse de départ ?";
      $placeholder = "Adresse de départ";
      $alertMessage = "Veuillez entrer une adresse de départ valide.";
      $inputId = "adresseDepart";
      $required = "required";
      include '../components/form/input-text.php';
      ?>

      <?php
      $labelDate = "Quelle est votre date de départ ?";
      $inputDateId = "dateDepart";
      $inputDateName = "DateDepart";
      $alertMessage = "Merci de sélectionner une date de départ";
      include '../components/form/input-date.php';
      ?>
    </fieldset>
    <fieldset class="covoiturage__arrivee">
      <legend>Arrivée</legend>
      <?php
      $label = "Quelle est votre adresse d'arrivée ?";
      $placeholder = "Adresse d'arrivée";
      $alertMessage = "Veuillez entrer une adresse d'arrivée valide.";
      $inputId = "adresseArrivee";
      $required = "required";
      // $value = htmlspecialchars($_GET['searchTextDestination']);
      include '../components/form/input-text.php';
      ?>

      <?php
      $labelDate = "Quelle est votre date d'arrivée ?";
      $inputDateId = "dateArrivee";
      $inputDateName = "DateArrivee";
      $alertMessage = "Merci de sélectionner une date d'arrivée";
      include '../components/form/input-date.php';
      ?>
    </fieldset>

  </div>
  <div class="covoiturage__container__button w-100 f-row-r container">
    <button class="btn btn-main">Valider</button>
  </div>

</body>
<?php include '../common/footer.php'; ?>