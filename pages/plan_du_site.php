<?php include '../common/head.php'; ?>

<body class="body__plan_du_site">

  <?php include '../common/header.php'; ?>

  <ul>
    <li><a href="../../index.php">Accueil</a></li>
    <li><a href="../../pages/covoiturages.php">Rechercher un covoiturages</a></li>
    <ul>
      <li><a href="../../pages/covoiturage/acces-covoit.php">Voyages proposés</a></li>
      <li><a href="../../pages/covoiturage/detail-voyage.php">Détail du voyage</a></li>
    </ul>
    <li><a href="../../pages/connexion.php">Connexion</a></li>
    <ul>
      <li><a href="../../pages/espaces/creat-account.php">Créer un compte</a></li>
      <li><a href="../../pages/espaces/admin.php">Admin</a></li>
      <li><a href="../../pages/espaces/user.php">Mon compte</a></li>
      <ul>
        <li><a href="../../pages/espaces/user-vehicle.php">Gestion de mes véhicules</a></li>
        <ul>
          <li><a href="../../pages/espaces/modif-vehicle.php">Modifier un véhicule</a></li>
        </ul>
        <li><a href="../../pages/espaces/suggest-trip.php">Proposer un voyage</a></li>
      </ul>
    </ul>
    <li><a href="../../pages/contact.php">Contact</a></li>
  </ul>

</body>

<?php include '../common/footer.php'; ?>