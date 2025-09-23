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
        include '../components/form/input-text.php';
      ?>

      <?php
        $labelMain = "Quelle est votre date de départ ?";
        $labelDay = "Jour";
        $placeholderDay = "DD";
        $labelMonth = "Mois";
        $placeholderMonth = "MM";
        $labelYear = "Année";
        $placeholderYear = "AAAA";
        $alertMessage = "Merci de rentrer la date au format DD MM AAAA.";
        $inputId = "dateDepart";
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
        // $value = htmlspecialchars($_POST['searchTextDestination']);
        include '../components/form/input-text.php';
      ?>

      <?php
        $labelMain = "Quelle est votre date d'arrivée ?";
        $labelDay = "Jour";
        $placeholderDay = "DD";
        $labelMonth = "Mois";
        $placeholderMonth = "MM";
        $labelYear = "Année";
        $placeholderYear = "AAAA";
        $alertMessage = "Merci de rentrer la date au format DD MM AAAA.";
        $inputId = "dateArrivee";
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
