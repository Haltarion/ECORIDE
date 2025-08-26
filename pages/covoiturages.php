<?php include '../common/header.php'; ?>

  <h1>Rechercher un covoiturages</h1>

  <div class="covoiturages">
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
      <div class="container__button">
        <?php include '../components/clicable/button.php' ?>
      </div>
    </div>
    
    
<?php include '../common/footer.php'; ?>
