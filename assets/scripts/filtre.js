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
