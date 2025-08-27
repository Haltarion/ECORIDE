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
