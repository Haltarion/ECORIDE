<div class="card-covoit container b-1 b-secondary r-15 g-1">
  <!-- Partie haute de la carte  -->
  <div class="infos-voyage f-row f-w al-center just-sa g-25">
    <!-- Départ / arrivée -->
    <?php include '../../components/covoiturage/depart-arrive.php' ?>
    <!-- Prix -->
    <?php
      $valeur ="10";
      include '../../components/covoiturage/prix.php'
    ?>
  </div>
  <!-- Séparateur -->
  <div class="infos-voyage__separator w-100 bg-secondary" role="img" aria-label="separateur"></div>
  <!-- Partie basse de la carte -->
  <div class="infos-voiture f-row al-center just-sa g-20 h-100">
    <!-- Infos sur le conducteur -->
    <?php
      $pseudo ="Bonport";
      include "../../components/covoiturage/info-conducteur.php";
    ?>
    <?php
      $starClass = "infos-voiture__star main f-row g-5 h-25";
      $textClass = "infos-voiture__text secondary";
      include '../../components/icone/note.php';
    ?>
    <!-- Icone voiture électrique -->
    <?php
      $class = "secondary";
      include '../../components/icone/electricalCar.php';
    ?>
    <!-- Places restantes -->
    <?php include '../../components/icone/nbPlacesRestantes.php'; ?>
    <!-- Bouton détail -->
    <button class="btn btn-main">Détail</button>
  </div>
</div>