<div class="card-covoit">
  <!-- Partie haute de la carte  -->
  <div class="infos-voyage">
    <!-- Départ / arrivée -->
    <div class="infos-voyage__depart-arrivee">
      <!-- Départ -->
      <div class="infos-voyage__depart">
        <p id="villeDepart" class="infos-voyage__depart__ville">Paris</p>
        <p class="infos-voyage__depart__date">12/12/24</p>
        <p class="infos-voyage__depart__heure">14:30</p>
      </div>
      <!-- Fleche entre le départ et la destination -->
      <div class="infos-voyage__depart-arrivee__fleche" role="img" aria-label="flèche allant de la gauche vers la droite"></div>
      <!-- Arrivée -->
      <div class="infos-voyage__arrivee">
        <p id="villeArrivee" class="infos-voyage__arrivee__ville">Lyon</p>
        <p class="infos-voyage__arrivee__date">12/12/24</p>
        <p class="infos-voyage__arrivee__heure">14:30</p>
      </div>
    </div>
    <!-- Prix -->
    <div class="infos-voyage__prix">
      <p class="infos-voyage__prix__montant">25</p>
      <p class="infos-voyage__prix__unite">Crédits</p>
    </div>
  </div>
  <!-- Séparateur -->
  <div class="infos-voyage__separator" role="img" aria-label="separateur"></div>
  <!-- Partie basse de la carte -->
  <div class="infos-voiture">
    <!-- Infos sur le conducteur -->
    <div class="infos-voiture__conducteur">
      <img class="infos-voiture__photo" src="../../media/Photo de profil.jpg" alt="Photo de profil du conducteur">
      <p class="infos-voiture__nom">Bonport</p>
    </div>
    <?php
      $starClass = "infos-voiture__star";
      $textClass = "infos-voiture__text";
      include '../../components/icone/note.php';
    ?>
    <!-- Icone voiture électrique -->
    <?php
      $class = "icone-electricalCarCovoit";
      include '../../components/icone/electricalCar.php';
    ?>
    <!-- Places restantes -->
    <?php include '../../components/icone/nbPlacesRestantes.php'; ?>
    <!-- Bouton détail -->
    <button class="infos-voiture__button-detail">Détail</button>
</div>