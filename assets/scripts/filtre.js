// Animation de l'input range
//-------------------------------------------------------------
const sliderProgress = document.querySelector(".slider-progress");
const slider = document.querySelector("input[type='range']");
// IIF to update on saved or loaded values
(function () {
    const progress = 100 - ((slider.value / slider.max) * 100).toPrecision(5);
    sliderProgress.style.left = `-${progress}%`;
})();

//Add listeners for range changes
slider.addEventListener("click", function () {
    const progress = 100 - ((this.value / this.max) * 100).toPrecision(5);
    sliderProgress.style.left = `-${progress}%`;
});
slider.addEventListener("mousemove", function () {
    const progress = 100 - ((this.value / this.max) * 100).toPrecision(5);
    sliderProgress.style.left = `-${progress}%`;
});
slider.addEventListener("change", function () {
    const progress = 100 - ((this.value / this.max) * 100).toPrecision(5);
    sliderProgress.style.left = `-${progress}%`;
});

//Programatic range change example --> press U to load to 80%
document.addEventListener("keypress", (e) => {
    if (e.key === "u") {
        slider.value = 80;
        // if updating the value programatically, dispatch an event
        slider.dispatchEvent(new CustomEvent("change"));
    }
});

// Animation du starRating
// ---- ---- Const ---- ---- //
const stars = document.querySelectorAll(".stars i");
const starsNone = document.querySelector(".rating-box");

// ---- ---- Stars ---- ---- //
stars.forEach((star, index1) => {
    star.addEventListener("click", () => {
        stars.forEach((star, index2) => {
            // ---- ---- Active Star ---- ---- //
            index1 >= index2
                ? star.classList.add("active")
                : star.classList.remove("active");
        });
    });
});

// On attend que le DOM soit chargé
document.addEventListener("DOMContentLoaded", () => {
    // --- On récupère les éléments du DOM ---
    const toggleBtn = document.getElementById("filtre__toggle");
    const filtreForm = document.getElementById("filtre__form");
    const ecologique = document.getElementById("ecologique");
    const prixSlider = document.getElementById("prixMax");
    const prixDisplay = document.getElementById("prixMaxValeur");
    const applyBtn = document.getElementById("filtre__button");

    // On vérifie que le filtre est fermé
    if (filtreForm.classList.contains("open")) {
        filtreForm.classList.remove("open");
    }
    // --- Gestion du toggle (ouverture/fermeture) ---
    if (toggleBtn && filtreForm) {
        toggleBtn.addEventListener("click", () => {
            // Vérifier si la classe "open" n'est PAS présente
            if (!filtreForm.classList.contains("open")) {
                // On ouvre le formulaire
                filtreForm.classList.add("open");
            } else {
                // On ferme le formulaire
                filtreForm.classList.remove("open");
            }
        });
    }

    // --- Mise à jour du prix du slider ---
    if (prixSlider && prixDisplay) {
        prixSlider.addEventListener("input", () => {
            prixDisplay.textContent = `${prixSlider.value} crédits`;
        });
    }

    // --- Appliquer le filtre au clic ---
    if (applyBtn) {
        applyBtn.addEventListener("click", () => {
            const filters = {
                ecologique: ecologique.checked, // true si coché, false si décoché
                prixMax: prixSlider.value,
            };

            // Événement custom que la page principale pourra écouter
            document.dispatchEvent(
                new CustomEvent("filters:apply", { detail: filters })
            );
        });
    }
});
