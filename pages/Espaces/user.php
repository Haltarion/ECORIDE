<?php include '../../common/head.php'; ?>

<body>

  <?php include '../../common/header.php'; ?>

  <h1>Mon compte</h1>

  <div class="container f-row f-w al-start just-sb w-100 p-20">
    <div class="f-col g-10">
      <?php
      $pseudo = "Bonport";
      include '../../components/covoiturage/info-conducteur.php'
      ?>
      <?php
      $starClass = "infos-voiture__star main f-row g-5 h-25";
      $textClass = "infos-voiture__text secondary";
      include '../../components/icone/note.php';
      ?>
    </div>
    <?php
    $valeur = "20";
    include "../../components/covoiturage/prix.php";
    ?>
  </div>
  <div class="container f-row w-100 g-10 p-10">

    <!-- Boutons radio -->
    <div class="f-col al-start w-100">
      <h2>Vous êtes</h2>
      <div class="f-row al-center g-10 p-10">
        <input type="radio" id="passage" name="role" value="passage" checked />
        <label class="textInline" for="passage">Passagé</label>
      </div>
      <div class="f-row al-center g-10 p-10">
        <input type="radio" id="chauffeur" name="role" value="chauffeur" />
        <label class="textInline" for="chauffeur">Chauffeur</label>
      </div>
      <div class="f-row al-center g-10 p-10">
        <input type="radio" id="les2" name="role" value="les2" />
        <label class="textInline" for="les2">Les deux</label>
      </div>
      <?php
      $alertMessage = "Vous devez renseigner au moins 1 véhicule";
      $class = "hide";
      include "../../components/form/error-alerte.php";
      ?>
    </div>

    <!-- Boutons classiques -->
    <div class="f-col al-start w-100 just-sb maxw-200">
      <a href="" class="btn btn-main mh-50 w-100">Historique des covoiturages</a>
      <a href="suggest-trip.php" class="btn btn-main mh-50 w-100">Proposer un voyage</a>
      <a href="user-vehicle.php" class="btn btn-main mh-50 w-100">gérer mes véhicules</a>
    </div>
  </div>
  <div class="container f-col just-center w-100 g-10 p-20 al-sb">

    <!-- Préférences -->
    <h2>Vos préférences</h2>
    <p>Autorisez-vous les :</p>
    <div class="f-row al-center g-10">
      <input type="checkbox" id="fumeur" name="fumeur" value="fumeur" />
      <label class="textInline" for="fumeur">Fumeurs</label>
    </div>
    <div class="f-row al-center g-10">
      <input type="checkbox" id="animaux" name="animaux" value="animaux" />
      <label class="textInline" for="animaux">Animaux</label>
    </div>
    <?php
    $inputId = "preferences";
    $placeholder = "Indiquez ici vos préférences";
    $label = "Avez-vous d'autres préférences à indiquer ?";
    include "../../components/form/input-textarea.php"
    ?>
  </div>
  <div class="container f-col just-center w-100 g-10 p-20 al-sb">

    <!-- Véhicules -->
    <h2>Mes véhicules</h2>
    <?php
    $imatriculation = "AB-123-CD";
    $marque = "Citroën";
    $model = "C4";
    $class = "";
    $pencilIconVisibility = "hide";
    include "../../components/covoiturage/recap-vehicule.php"
    ?>
    <?php
    $imatriculation = "EF-456-GH";
    $marque = "Peugeot";
    $model = "208";
    $class = "";
    $pencilIconVisibility = "hide";
    include "../../components/covoiturage/recap-vehicule.php"
    ?>
  </div>
</body>

<?php include '../../common/footer.php'; ?>