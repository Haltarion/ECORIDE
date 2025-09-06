<div class="filtre">

  <h2 class="filtre__title">Filtre</h2>

  <form action="" method="post" class="filtre__form">
    <ul class="filtre__form__list">
      <button type="button" class="filtre__form__list__button" onclick="actionElec()">
        <span class="filtre__form__list__button__text">Ecologique</span>
        <span class="filtre__form__list__button__icon">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="m3.75 13.5 10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75Z" />
          </svg>
        </span>
      </button>
      <button type="button" class="filtre__form__list__button" onclick="actionPrix()">
        <span class="filtre__form__list__button__text">Prix max</span>
        <label for="prixMax" class="offSrean">Prix maximal</label>
        <input type="text" id="prixMax" placeholder="10 c" required>
      </button>
      <button type="button" class="filtre__form__list__button" onclick="actionDuree()">
        <span class="filtre__form__list__button__text">Durée max</span>
        <label for="dureeMax" class="offSrean">Durée maximal</label>
        <input type="text" id="dureeMax" placeholder="1h" required>
      </button>
      <button type="button" class="filtre__form__list__button" onclick="actionNote()">
        <span class="filtre__form__list__button__text">Note minimale</span>
        <label for="noteMin" class="offSrean">Note minimale</label>
        <span class="filtre__form__list__button__icon">
          <svg xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 24 24"  fill="currentColor"  class="size-6">
            <path  fill-rule="evenodd"  d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z"  clip-rule="evenodd"/>
          </svg>
          <p class="filtre__form__list__button__icon__text">5</p>
        </span>
      </button>
    </ul>
  </form>
</div>