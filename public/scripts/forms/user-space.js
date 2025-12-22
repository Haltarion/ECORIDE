import {
    isAllowedSize,
    isAllowedType,
    sanitizeString,
    validateConfirmationPassword,
    validateMail,
    validatePassword,
    validateRequired,
} from "../security.js";
document.addEventListener("DOMContentLoaded", () => {
    // Script pour la modal de modification de la photo de profil
    const photoModal = document.getElementById("modal-edit-photo");
    const photoOpenBtn = document.getElementById("photo-open-modal-btn");
    const closePhotoBtn = document.getElementById("close-photo-modal");
    const photoInput = document.getElementById("photo-input");
    const fileName = document.getElementById("file-name");
    const img = document.getElementById("modal-photo-profil");

    photoOpenBtn.addEventListener("click", () => {
        photoModal.classList.add("open");
    });

    closePhotoBtn.addEventListener("click", () => {
        photoModal.classList.remove("open");
    });

    // ------------------------------------
    // Script pour récupérer la photo
    // ------------------------------------
    // Variables temporaires
    let tempName = "";
    let tempSrc = "";

    const allowedTypes = ["image/jpeg", "image/png", "image/webp"];
    const maxSize = 2 * 1024 * 1024;

    // Prévisualisation de l'image sélectionnée
    if (!photoInput) {
        console.error("input introuvable !");
        return;
    }
    photoInput.addEventListener("change", function () {
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

    // ------------------------------------
    // Fonction de mise à jour des informations utilisateur
    // ------------------------------------
    function updateUserInfos() {
        // Vérifier si des changements ont été effectués
        const pseudoChanged = inputPseudo.value !== initialValues.pseudo;
        const emailChanged = inputMail.value !== initialValues.email;
        const passwordsEntered =
            inputOldPassword.value ||
            inputNewPassword.value ||
            inputValidationPassword.value;

        // Si rien n'a changé, fermer la modale sans faire d'appel serveur
        if (!pseudoChanged && !emailChanged && !passwordsEntered) {
            infoModal.classList.remove("open");
            return;
        }

        const data = {
            pseudo: inputPseudo.value,
            email: inputMail.value,
            oldPassword: inputOldPassword.value,
            newPassword: inputNewPassword.value,
            _csrf_token: window.csrfInfosToken,
        };

        fetch("/user-space/infos", {
            method: "POST",
            credentials: "same-origin",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(data),
        })
            .then((r) => r.json())
            .then((json) => {
                if (json.success) {
                    alert("Informations mises à jour avec succès");
                    // Réinitialiser les inputs de mot de passe
                    inputOldPassword.value = "";
                    inputNewPassword.value = "";
                    inputValidationPassword.value = "";
                    infoModal.classList.remove("open");
                    // Si le contrôleur fournit une URL de redirection, rafraîchir la page
                    if (json.redirect) {
                        window.location.href = json.redirect;
                        return;
                    }
                    // Fallback : recharger la page si pas d'URL
                    window.location.reload();
                } else {
                    alert(
                        "Erreur : " +
                            (json.message ||
                                "Impossible de mettre à jour les informations")
                    );
                    console.warn("Info update failed", json);
                }
            })
            .catch((err) => {
                alert("Erreur réseau : " + err.message);
                console.error("Info update error", err);
            });
    }

    // Script pour la modal de modification des informations du profil
    const infoModal = document.getElementById("modal-edit-info");
    const infoOpenBtn = document.getElementById("edit-info-btn");
    const closeInfoBtn = document.getElementById("close-info-modal");
    const formEditInfo = document.getElementById("editInfoForm");

    infoOpenBtn.addEventListener("click", () => {
        infoModal.classList.add("open");
    });

    closeInfoBtn.addEventListener("click", (e) => {
        e.preventDefault(); // Empêcher la soumission du formulaire
        infoModal.classList.remove("open");
    });

    // Gérer la soumission du formulaire (empêcher l'envoi HTML classique, mais permettre Enter)
    if (formEditInfo) {
        formEditInfo.addEventListener("submit", (e) => {
            e.preventDefault();
            // Appeler la fonction de mise à jour au lieu de soumettre le formulaire
            updateUserInfos();
        });

        // Permettre la validation avec la touche Enter sur n'importe quel champ
        formEditInfo.addEventListener("keydown", (e) => {
            if (e.key === "Enter") {
                e.preventDefault();
                updateUserInfos();
            }
        });
    }

    // Récupération des inputs du formulaire
    const inputPseudo = document.getElementById("pseudo");
    const inputMail = document.getElementById("email");
    const inputOldPassword = document.getElementById("oldPassword");
    const inputNewPassword = document.getElementById("newPassword");
    const inputValidationPassword =
        document.getElementById("confirmNewPassword");

    const btnValidationModif = document.getElementById("btnValidationModif");

    // Stocker les valeurs initiales pour détecter les changements
    const initialValues = {
        pseudo: inputPseudo?.value || "",
        email: inputMail?.value || "",
    };

    // Ajout d'écoute des événements sur les inputs pour ne valider que le champ concerné
    function updateSubmitState() {
        // Vérifier si tous les champs de mot de passe sont vides
        const allPasswordFieldsEmpty =
            (!inputOldPassword.value || inputOldPassword.value.trim() === "") &&
            (!inputNewPassword.value || inputNewPassword.value.trim() === "") &&
            (!inputValidationPassword.value ||
                inputValidationPassword.value.trim() === "");

        // Si tous les champs sont vides, activer le bouton (permet de modifier pseudo/email uniquement)
        if (allPasswordFieldsEmpty) {
            btnValidationModif.disabled = false;
            return;
        }

        // Sinon, tous les champs de mot de passe doivent être valides
        const allPasswordsValid = [
            inputOldPassword,
            inputNewPassword,
            inputValidationPassword,
        ].every((el) => el?.classList.contains("is-valid"));

        btnValidationModif.disabled = !allPasswordsValid;
    }

    inputPseudo.addEventListener("keyup", () => {
        validateRequired(inputPseudo);
        updateSubmitState();
    });

    inputMail.addEventListener("keyup", () => {
        validateMail(inputMail);
        updateSubmitState();
    });

    if (
        inputOldPassword !== null ||
        inputNewPassword !== null ||
        inputValidationPassword !== null
    ) {
        inputOldPassword.addEventListener("keyup", () => {
            validatePassword(inputOldPassword);
            updateSubmitState();
        });

        inputNewPassword.addEventListener("keyup", () => {
            validatePassword(inputNewPassword);
            // Mettre à jour la confirmation si l'utilisateur modifie le nouveau mot de passe
            validateConfirmationPassword(
                inputNewPassword,
                inputValidationPassword
            );
            updateSubmitState();
        });

        inputValidationPassword.addEventListener("keyup", () => {
            validateConfirmationPassword(
                inputNewPassword,
                inputValidationPassword
            );
            updateSubmitState();
        });

        // Soumission du formulaire d'infos
        btnValidationModif.addEventListener("click", (e) => {
            e.preventDefault();
            updateUserInfos();
        });
    }
    if (
        inputOldPassword === null &&
        inputNewPassword === null &&
        inputValidationPassword === null
    ) {
        btnValidationModif.disabled = false;
    }

    // ------------------------------------
    // Script pour la gestion des radios "profil"
    // ------------------------------------
    // Initialiser l'état du bouton en fonction des valeurs déjà présentes
    updateSubmitState();

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

    // ------------------------------------
    // Script pour la gestion des préférences
    // ------------------------------------
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
