<?php include '../../common/head.php'; ?>

<body>

  <?php include '../../common/header.php'; ?>

  <h1>Détail du voyage</h1>
  <div class="container f-col g-20">
    <h2>Voyage</h2>
    <div class="f-col al-center g-20 p-20 r-15 b-1 b-secondary">
      <?php include '../../components/covoiturage/depart-arrive.php' ?>
      <div class="f-row just-sb w-100">
        <?php include '../../components/covoiturage/prix.php' ?>
        <?php
        $class = "secondary";
        include '../../components/icone/electricalCar.php';
        ?>
      </div>
      <?php include '../../components/icone/nbPlacesRestantes.php'; ?>
    </div>
    <h2>Conducteur</h2>
    <div class="f-row just-sb p-20 g-20 r-15 b-1 b-secondary">
      <?php include '../../components/covoiturage/info-conducteur.php' ?>
      <?php
      $starClass = "infos-voiture__star main f-row g-5 h-25";
      $textClass = "infos-voiture__text secondary";
      include '../../components/icone/note.php';
      ?>
    </div>
    <h2>Véhicule</h2>
    <div class="f-row just-sb p-20 g-20 r-15 b-1 b-secondary">
      <?php include '../../components/covoiturage/info-vehicule.php' ?>
    </div>
    <h2>Préférence du conducteur</h2>
    <div class="f-row just-sb p-20 g-20 r-15 b-1 b-secondary">
      <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Similique enim quia sint voluptate quisquam ea sunt eius nobis corporis beatae officiis cumque harum amet fuga incidunt placeat, voluptas ad numquam?</p>
    </div>
    <h2>Avis</h2>
    <div class="f-row just-sb p-20 g-20 r-15 b-1 b-secondary">
      <?php include '../../components/covoiturage/avis.php' ?>
    </div>
  </div>
</body>

<?php include '../../common/footer.php'; ?>
