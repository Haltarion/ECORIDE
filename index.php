<?php include './common/head.php'; ?>

<body>

  <?php include './common/header.php'; ?>

  <h1>Accueil</h1>

  <form action="pages/covoiturages.php" method="GET" id="searchFormDestination" class="searchForm f-row w-100 r-50" role="search">
    <label class="offScreen" for="searchText">
      Où souhaitez-vous aller ?
    </label>
    <input
      type="text"
      id="searchTextDestination"
      class="searchText"
      autocomplete="off"
      role="searchbox"
      placeholder="Où souhaitez-vous aller ?"
      required>
    <button type="submit" class="searchButton h-100">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
      </svg>
    </button>
  </form>

  <img class="index__image-accueil" src="./media/photo_covoiturage.png" alt="Image d'accueil covoiturage">

  <div class="f-col g-2">
    <p>Bienvenue chez ECORIDE 🚗⚡</p>
    <p>Chez ECORIDE, nous croyons qu’il est possible de voyager autrement : plus écologique, plus économique et surtout plus humain.</p>
    <p>Notre idée est simple : connecter conducteurs et passagers pour partager des trajets en voiture électrique ou hybride, et ainsi réduire ensemble notre impact sur l’environnement.</p>
    <p>En choisissant ECORIDE, vous participez à un covoiturage nouvelle génération, où chaque kilomètre parcouru est une petite victoire pour la planète.</p>
    <p>Mais ECORIDE, ce n’est pas seulement une question de transport.C’est aussi l’occasion de rencontrer de nouvelles personnes, d’échanger un sourire, une discussion… et parfois même de créer des liens durables.</p>
    <p>Parce que se déplacer peut rimer avec respect et convivialité, nous vous invitons à rejoindre la communauté ECORIDE dès aujourd’hui.</p>
    <p>Roulez vert, roulez ensemble ! 🌍</p>
  </div>
</body>

<?php include './common/footer.php'; ?>