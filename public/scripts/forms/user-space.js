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
    const preferencesForm = document.getElementById("preferencesForm");
    const vehicule = document.getElementById("vehicule");
    // Valeur initiale depuis le serveur
    const initialSelected = window.selectedProfil ?? "passager";
    window.profil = initialSelected;

    // Envoi de la requête optionnel
    function onProfilChange(value, send = true) {
        window.profil = value;
        document.documentElement.dataset.userProfil = value;

        if (value === "passager") {
            preferencesForm.classList.add("hidden");
            errorDiv.classList.add("hidden");
            vehicule.classList.add("hidden");
        } else {
            preferencesForm.classList.remove("hidden");
            // if (vehicule === "") {
            errorDiv.classList.remove("hidden");
            // } else {
            vehicule.classList.remove("hidden");
            // }
        }

        if (!send) return; // éviter fetch au chargement

        // envoi au controller
        fetch("/user-space/profil", {
            method: "POST",
            credentials: "same-origin", // inclure les cookies
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

    // attacher événements
    radios.forEach((r) =>
        r.addEventListener("change", () => onProfilChange(r.value))
    );

    // cocher la radio correspondante et appliquer l'UI sans envoyer la requête
    const radioToCheck = document.querySelector(
        `input[name="profil"][value="${initialSelected}"]`
    );
    if (radioToCheck) radioToCheck.checked = true;
    onProfilChange(initialSelected, false);

    // Pour la soumission du formulaire photo (multipart)
    const formPhoto = document.querySelector(
        'form[action*="/user-space/photo"]'
    );
    if (formPhoto) {
        formPhoto.addEventListener("submit", (e) => {
            e.preventDefault();
            const formData = new FormData(formPhoto);
            formData.append("_csrf_token", window.csrfPhotoToken);

            fetch(formPhoto.action, {
                method: "POST",
                credentials: "same-origin",
                body: formData,
            })
                .then((r) => r.json())
                .then((json) => {
                    if (json.success) window.location.reload();
                    else console.warn("Photo upload failed", json);
                })
                .catch((err) => console.error("Photo upload error", err));
        });
    }

    // Script pour la gestion des préférences
    const fumeurCheckbox = document.getElementById("fumeur");
    const animauxCheckbox = document.getElementById("animaux");
    const preferencesTextarea = document.getElementById("preferences");
    const btnValidation = document.getElementById("valide-pref-btn");

    btnValidation?.addEventListener("click", (e) => {
        e.preventDefault();
        updatePreferences();
    });

    function updatePreferences() {
        const rawText = preferencesTextarea?.value || "";
        const safeText = sanitizeString(rawText);
        const data = {
            fumeur: fumeurCheckbox?.checked ? "fumeur" : "",
            animaux: animauxCheckbox?.checked ? "animaux" : "",
            preferences: safeText,
            _csrf_token: window.csrfProfileToken,
        };

        fetch("/user-space/preferences", {
            method: "POST",
            credentials: "same-origin",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(data),
        })
            .then((r) => r.json())
            .then((json) => {
                if (!json.success) {
                    alert(
                        "Une erreur est survenue lors de l'enregistrement des préférences."
                    );
                    console.warn("Preferences update failed", json);
                } else alert("Préférences enregistrées avec succès");
            })
            .catch((err) => console.error("Preferences update error", err));
    }
});
