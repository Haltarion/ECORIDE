<?php include '../../common/head.php'; ?>

<body>

  <?php include '../../common/header.php'; ?>

  <h1>Proposer un voyage</h1>

  <div class="covoiturageForm w-100 g-15 p-15 container">
    <fieldset>
      <legend>Départ</legend>
      <?php
      $label = "*Quelle est votre adresse de départ ?";
      $placeholder = "Adresse de départ";
      $alertMessage = "Veuillez entrer une adresse de départ valide.";
      $inputId = "adresseDepart";
      $required = "required";
      include '../../components/form/input-text.php';
      ?>

      <?php
      $labelDate = "*Quelle est votre date de départ ?";
      $inputDateId = "dateDepart";
      $inputDateName = "DateDepart";
      $alertMessage = "Merci de sélectionner une date de départ";
      include '../../components/form/input-date.php';
      ?>
    </fieldset>
    <fieldset class="covoiturage__arrivee">
      <legend>Arrivée</legend>
      <?php
      $label = "*Quelle est votre adresse d'arrivée ?";
      $placeholder = "Adresse d'arrivée";
      $alertMessage = "Veuillez entrer une adresse d'arrivée valide.";
      $inputId = "adresseArrivee";
      $required = "required";
      // $value = htmlspecialchars($_GET['searchTextDestination']);
      include '../../components/form/input-text.php';
      ?>

      <?php
      $labelDate = "*Quelle est votre date d'arrivée ?";
      $inputDateId = "dateArrivee";
      $inputDateName = "DateArrivee";
      $alertMessage = "Merci de sélectionner une date d'arrivée";
      include '../../components/form/input-date.php';
      ?>
    </fieldset>
  </div>
  <div class="covoiturageComplement w-100 g-15 p-15 container">
    <h2>Complément</h2>
    <p>Nous vous rappelons que nous prélevons 2 crédits afin de garantir le bon fonctionnement la plateforme.</p>
    <?php
    $inputId = "prixParPassager";
    $label = "*Prix (en crédit) par passager :";
    $value = "10";
    $min = "3";
    $max = "500";
    $required = "required";
    $alertMessage = "Veuillez entrer un prix valide.";
    include '../../components/form/input-number.php';
    ?>
    <div class="w-100">
      <label>Sélectionnez un véhicule :</label>
      <div class="vehicleSelection f-row f-w al-center just-sb g-10 b-1 b-secondary r-15 ">
        <div class="plaque relative">
          <p class="imatriculation">AB-123-CD</p>
        </div>
        <div class="f-col g-5 just-center al-start">
          <h3>Citroën</h3>
          <p>C4</p>
        </div>
        <?php
        $class = "";
        include "../../components/icone/electricalCar.php"
        ?>
        <div class="f-col just-center h-100">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
          </svg>
        </div>
      </div>
    </div>

  </div>

  <div class="covoiturage__container__button w-100 f-row just-sb container">
    <a href="user.php" class="btn btn-annul">Annuler</a>
    <button class="btn btn-main">Valider</button>
  </div>

</body>
<?php include '../../common/footer.php'; ?>