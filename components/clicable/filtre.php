<div class="filtre">
  <header class="filtre__header">
    <span class="filtre__header__title">Filtre</span>
  </header>
  <form action="" method="post" class="filtre__form">
    <ul class="filtre__form__list">
      <li class="filtre__form__list__item" aria-expanded="false">
        <button type="button" class="filtre__form__list__item__button" onclick="actionElec()">
          <span class="filtre__form__list__item__button__text">Ecologique</span>
          <span class="filtre__form__list__item__button__icon">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
              <path stroke-linecap="round" stroke-linejoin="round" d="m3.75 13.5 10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75Z" />
            </svg>
          </span>
        </button>
      </li>
      <li class="filtre__form__list__item" aria-expanded="false">
        <button type="button" class="filtre__form__list__item__button" onclick="actionPrix()">
          <span class="filtre__form__list__item__button__text">Prix max</span>
          <label for="prixMax" class="offSrean">Prix maximal</label>
          <input type="text" id="prixMax" placeholder="10 c" required>
        </button>
      </li>
      <li class="filtre__form__list__item" aria-expanded="false">
        <button type="button" class="filtre__form__list__item__button" onclick="actionDuree()">
          <span class="filtre__form__list__item__button__text">Durée max</span>
          <label for="dureeMax" class="offSrean">Durée maximal</label>
          <input type="text" id="dureeMax" placeholder="1h" required>
        </button>
      </li>
      <li class="filtre__form__list__item" aria-expanded="false">
          <?php include '../../components/icone/note' ?>
      </li>
</span>