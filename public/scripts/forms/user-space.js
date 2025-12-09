import { isAllowedSize, isAllowedType, sanitizeString } from "../security.js";
document.addEventListener("DOMContentLoaded", () => {
    // Script pour la modal de modification de la photo de profil
    const modal = document.getElementById("modal-edit-photo");
    const openBtn = document.getElementById("open-modal-btn");
    const closeBtn = document.getElementById("close-modal");
    const input = document.getElementById("photo-input");
    const fileName = document.getElementById("file-name");
    const img = document.getElementById("modal-photo-profil");

    openBtn.addEventListener("click", () => {
        modal.classList.add("open");
    });

    closeBtn.addEventListener("click", () => {
        modal.classList.remove("open");
    });

    // Script pour récupérer la photo
    // Variables temporaires
    let tempName = "";
    let tempSrc = "";

    const allowedTypes = ["image/jpeg", "image/png", "image/webp"];
    const maxSize = 2 * 1024 * 1024;

    // Prévisualisation de l'image sélectionnée
    if (!input) {
        console.error("input introuvable !");
        return;
    }
    input.addEventListener("change", function () {
        const file = this.files[0];
        if (!file) return;

        if (!isAllowedType(file, allowedTypes)) {
            alert("Votre image doit être au format JPG, PNG ou WEBP.");
            return;
        }

        if (!isAllowedSize(file, maxSize)) {
            alert("Fichier trop volumineux.");
            return;
        }

        tempName = sanitizeString(file.name);
        fileName.textContent = tempName;

        tempSrc = URL.createObjectURL(file);
        img.src = tempSrc;
    });

    // Script pour la gestion des radios "profil"
    const radios = Array.from(
        document.querySelectorAll('input[name="profil"]')
    );
    const errorDiv = document.getElementById("error-alerte");
    const preferences = document.getElementById("preferences");
    const vehicule = document.getElementById("vehicule");
    // Valeur initiale
    window.profil =
        document.querySelector('input[name="profil"]:checked')?.value ||
        "passager";
    // mise à jour visuelle locale + envoi au serveur quand on change
    function onProfilChange(value) {
        window.profil = value;
        // mise à jour UI locale si besoin
        document.documentElement.dataset.userProfil = value;
        if (value === "passager") {
            preferences.classList.remove("visible");
            preferences.classList.add("hidden");
            errorDiv.classList.remove("visible");
            errorDiv.classList.add("hidden");
            vehicule.classList.remove("visible");
            vehicule.classList.add("hidden");
        } else {
            preferences.classList.remove("hidden");
            preferences.classList.add("visible");
            // if (vehicule === "") {
            errorDiv.classList.remove("hidden");
            errorDiv.classList.add("visible");
            // } else {
            vehicule.classList.remove("hidden");
            vehicule.classList.add("visible");
            // }
        }

        // envoi au controller
        fetch("/user-space/profil", {
            method: "POST",
            credentials: "same-origin",
            headers: {
                "Content-Type": "application/json",
                "X-Requested-With": "XMLHttpRequest",
            },
            body: JSON.stringify({
                profil: value,
                _csrf_token: window.csrfProfileToken,
            }),
        })
            .then((r) => r.json())
            .then((json) => {
                if (!json.success) console.warn("Profil update failed", json);
            })
            .catch((err) => console.error("Profil fetch error", err));
    }
    radios.forEach((r) =>
        r.addEventListener("change", () => onProfilChange(r.value))
    );
});
