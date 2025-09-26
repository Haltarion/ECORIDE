<?php include '../common/head.php'; ?>

<body>

  <?php include '../common/header.php'; ?>

  <h1>Se connecter</h1>

  <div class="connexion f-col w-100 g-30 p-15 container">
    <div class="connexion__existingCount f-col g-15 w-100">
      <?php
        $alertMessage = "Merci de rentrer un email valide.";
        $required ="required";
        include '../components/form/input-email.php';
      ?>

      <?php include '../components/form/input-mdp.php'; ?>

      <div>
        <?php
          $buttonText = "Valider";
          $class = "btn btn-main";
          include '../components/clicable/button.php'
        ?>
      </div>
    </div>

    <div class="connexion__separateur al-center just-center g-20 w-100">
      <p class="connexion__separateur__text">OU</p>
    </div>

    <div class="connexion__newCount f-col just-center w-100">
      <?php
        $buttonText = "Créer un compte";
        $class = "btn btn-connect";
        include '../components/clicable/button.php'
      ?>
    </div>
  </div>

</body>
<?php include '../common/footer.php'; ?>
