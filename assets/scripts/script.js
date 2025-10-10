// Script pour le menu burger
var openMenu = false;

function actionMenu() {
  openMenu = !openMenu;

  if (openMenu) {
    openMenuMobile();
  } else {
    closeMenuMobile();
  }
  // Alterne les icônes
  document.querySelector(
    ".header__nav__burger_menu__burger-icon"
  ).style.display = openMenu ? "none" : "inline";
  document.querySelector(
    ".header__nav__burger_menu__close-icon"
  ).style.display = openMenu ? "inline" : "none";
}

function openMenuMobile() {
  document
    .querySelector(".header__nav__burger_menu")
    .classList.add("header__nav__burger_menu_open");
  document.querySelector(".header__nav").classList.add("open");
}

function closeMenuMobile() {
  document
    .querySelector(".header__nav__burger_menu")
    .classList.remove("header__nav__burger_menu_open");
  document.querySelector(".header__nav").classList.remove("open");
}

// Script pour la note
// On récupère toutes les étoiles
var toutesLesEtoiles = $(".stars .stars__list__stargrey");
// console.log(toutesLesEtoiles);

// On rajoute l'écouteur au clic;
// toutesLesEtoiles.click(onStarClick)
toutesLesEtoiles.click(onStarClick);

// On gère ce qui se passe lors du clic d'une étoile
function onStarClick(event) {
  // On récupère l'objet cliqué, AU FORMAT JQUERY
  var etoileCliquée = $(this);
  // console.log(etoileCliquée);

  // On récupère son index ("Quelle étoile a été cliquée ?") depuis sont attribut data-index
  var indexCliqué = etoileCliquée.data("index");
  // console.log(indexCliqué);

  // On récupère son parent (afin de rendre ça réutilisable pour d'autres groupes)
  var parent = $(this).parent();

  // Style : "Vider" toutes les étoiles.. de ce groupe
  parent.find(".star").addClass("stargrey");
  parent.find(".star").removeClass("yellow");

  //// Style : "Remplir" le bon nombre d'étoiles
  // Pour ce groupe, pour chaque étoile de 0 jusqu'à celle cliquée..
  for (var i = 0; i <= indexCliqué; i++) {
    var etoile = parent.find(".star[data-index=" + i + "]");
    // console.log( etoile );

    // Je remplie
    etoile.addClass("yellow");
    etoile.removeClass("stargrey");
  }
}
