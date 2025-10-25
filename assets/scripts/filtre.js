// On attend que le DOM soit chargé
document.addEventListener("DOMContentLoaded", () => {
    // --- On récupère les éléments du DOM ---
    const toggleBtn = document.getElementById("filtre__toggle");
    const filtreForm = document.getElementById("filtre__form");
    const ecologique = document.getElementById("ecologique");
    const prixSlider = document.getElementById("prixMax");
    const prixDisplay = document.getElementById("prixMaxValeur");
    const applyBtn = document.getElementById("filtre__button");

    // --- Gestion du toggle (ouverture/fermeture) ---
    if (toggleBtn && filtreForm) {
        toggleBtn.addEventListener("click", () => {
            // On récupère l'état actuel
            const isExpanded =
                toggleBtn.getAttribute("aria-expanded") === "true";
            if (isExpanded) {
                // On ferme le formulaire
                toggleBtn.setAttribute("aria-expanded", "false");
                filtreForm.setAttribute("aria-hidden", "true");
                filtreForm.classList.remove("open");
            } else {
                // On ouvre le formulaire
                toggleBtn.setAttribute("aria-expanded", "true");
                filtreForm.setAttribute("aria-hidden", "false");
                filtreForm.classList.add("open");
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
