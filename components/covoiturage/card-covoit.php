<div class="card-covoit">
  <div class="infos-voyage">
    <div class="infos-voyage__depart-arrivee">
      <div class="infos-voyage__depart">
        <p id="villeDepart" class="infos-voyage__depart__ville">Paris</p>
        <p class="infos-voyage__depart__date">12/12/24</p>
        <p class="infos-voyage__depart__heure">14:30</p>
      </div>
      
      <div class="infos-voyage__depart-arrivee__fleche" role="img" aria-label="flèche allant de la gauche vers la droite"></div>

      <div class="infos-voyage__arrivee">
        <p id="villeArrivee" class="infos-voyage__arrivee__ville">Lyon</p>
        <p class="infos-voyage__arrivee__date">12/12/24</p>
        <p class="infos-voyage__arrivee__heure">14:30</p>
      </div>
    </div>

    <div class="infos-voyage__prix">
      <p class="infos-voyage__prix__montant">25</p>
      <p class="infos-voyage__prix__unite">Crédits</p>
    </div>
  </div>

  <div class="infos-voyage__separator" role="img" aria-label="separateur"></div>

  <div class="infos-voiture">
    <div class="infos-voiture__conducteur">
      <img class="infos-voiture__photo" src="../../assets/images/voiture.jpg" alt="Photo du voiture">
      <p class="infos-voiture__nom">Jean Dupont</p>
    </div>

    <?php include '../../components/icone/note.php'; ?>

    <?php include '../../components/icone/electricalCar.php'; ?>

    <?php include '../../components/icone/nbPlacesRestantes.php'; ?>

    <button class="infos-voiture__button-detail">Détail</button>
</div>