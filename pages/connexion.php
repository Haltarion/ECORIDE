<?php include '../common/head.php'; ?>

<body class="connexion__body">
  
  <?php include '../common/header.php'; ?>

  <h1 class="connexion__title">Se connecter</h1>
  
  <div class="connexion">
    <div class="connexion__existingCount">
      <?php
        $alertMessage = "Merci de rentrer un email valide.";
        include '../components/form/input-email.php';
      ?>

      <?php include '../components/form/input-mdp.php'; ?>

      <div class="container__button">
        <?php
          $buttonText = "Valider";
          include '../components/clicable/button.php'
        ?>
      </div>
    </div>

    <div class="connexion__separateur">
      <p class="connexion__separateur__text">OU</p>
    </div>

    <div class="connexion__newCount">
      <?php
        $buttonText = "Créer un compte";
        include '../components/clicable/button.php'
      ?>
    </div>
  </div>

</body>
<?php include '../common/footer.php'; ?>
