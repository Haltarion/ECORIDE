<?php include '../common/head.php'; ?>

<body>

  <?php include '../common/header.php'; ?>

  <h1>Rechercher un covoiturages</h1>

  <div class="covoiturages w-100 g-15 p-15 container">
    <fieldset class="covoiturages__depart">
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
    <fieldset class="covoiturages__arrivee">
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
  <div class="covoiturages__container__button w-100 f-row-r container">
    <?php
    $buttonText = "Valider";
    $class = "btn-main";
    include '../components/clicable/button.php'
    ?>
  </div>

</body>
<?php include '../common/footer.php'; ?>