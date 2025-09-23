<?php include '../../common/head.php'; ?>

<body class="body__admin">

  <?php include '../../common/header.php'; ?>

  <h1 class="acces-covoit__title__title">Espace administrateur</h1>

  <div class="admin__container">
    <button class="btn btn-main">Nouveau compte employé</button>
    <span class="admin__container__credit">
      <p class="admin__container__credit__text">10</p>
      <p class="admin__container__credit__text">Crédits</p>
    </span>
  </div>
  <div class="admin__graph__nbCovParJour">
    <canvas id="nbCovParJour"></canvas>
  </div>
  <div class="admin__graph__gains">
    <canvas id="gains"></canvas>
  </div>

</body>

<?php include '../../common/footer.php'; ?>
