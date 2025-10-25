// Script pour le menu burger et le filtre sur mobile
var openMenu = false;
var openFiltre = false;

// Initialisation au chargement de la page
document.addEventListener("DOMContentLoaded", function () {
    // S'assurer que l'icône burger est visible et l'icône close est cachée au départ
    const burgerIcon = document.querySelector(
        ".header__nav__burger_menu__burger-icon"
    );
    const closeIcon = document.querySelector(
        ".header__nav__burger_menu__close-icon"
    );
    const toggleClose = document.querySelector(".toggle-close");

    if (burgerIcon) burgerIcon.style.display = "inline";
    if (closeIcon) closeIcon.style.display = "none";
    if (!toggleClose)
        document.querySelector(".filtre__form").classList.add(".toggle-close");
});

// Fonctions pour le menu mobile
function actionMenu() {
    openMenu = !openMenu;

    if (openMenu) {
        openMenuMobile();
    } else {
        closeMenuMobile();
    }
    // Alterne les icônes avec vérification de l'existence des éléments
    const burgerIcon = document.querySelector(
        ".header__nav__burger_menu__burger-icon"
    );
    const closeIcon = document.querySelector(
        ".header__nav__burger_menu__close-icon"
    );

    if (burgerIcon && closeIcon) {
        burgerIcon.style.display = openMenu ? "none" : "inline";
        closeIcon.style.display = openMenu ? "inline" : "none";
    } else {
        console.error(
            "Les icônes du menu burger n'ont pas été trouvées dans le DOM"
        );
    }
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

// Fonctions pour le filtre mobile
function actionFiltreForm() {
    openFiltre = !openFiltre;

    if (openFiltre) {
        openFiltreMobile();
    } else {
        closeFiltreMobile();
    }
}

function openFiltreMobile() {
    document.querySelector(".filtre__form").classList.add("toggle-open");
    document.querySelector(".filtre__form").classList.remove("toggle-close");
}

function closeFiltreMobile() {
    document.querySelector(".filtre__form").classList.remove("toggle-open");
    document.querySelector(".filtre__form").classList.add("toggle-close");
}
