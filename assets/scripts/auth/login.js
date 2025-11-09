console.trace("Script login.js chargé depuis:");

// Récupération des inputs du formulaire
const inputLoginEmail = document.getElementById("loginEmail");
const inputLoginPassword = document.getElementById("loginPassword");

const btnLogin = document.getElementById("btnLogin");

// Tableau de tous les inputs
const inputs = [inputLoginEmail, inputLoginPassword];

// Map pour savoir si un input a été touché
const touched = new Map();
inputs.forEach((input) => touched.set(input, false));

// Ajout des écouteurs sur chaque input
inputs.forEach((input) => {
    input.addEventListener("input", () => {
        touched.set(input, true); // marque le champ comme modifié
        validateForm();
    });
    input.addEventListener("keyup", () => {
        touched.set(input, true); // idem pour keyup
        validateForm();
    });
});

// Ajout de l'écouteur sur le bouton
btnLogin.addEventListener("click", AfficherCovoiturages);

// Fonction globale pour activer/désactiver le bouton
function validateForm() {
    let allValid = true;

    inputs.forEach((input) => {
        // On fait la validation globale pour tous les champs
        const isFieldValid = input.value.trim() !== "";

        if (!isFieldValid) allValid = false;

        // On met à jour le visuel et message seulement si le champ a été touché
        if (touched.get(input)) {
            validateRequired(input);
        }
    });

    btnLogin.disabled = !allValid;
}

// Fonction de validation d'un champ
function validateRequired(input) {
    // Recherche du message d'erreur associé (dans la même div parente)
    const errorDiv = input
        .closest(".form-group")
        ?.querySelector(".error-message");

    if (input.value.trim() != "") {
        input.classList.remove("is-invalid");
        input.classList.add("is-valid");
        // Si un message d'erreur est présent, on le cache
        if (errorDiv) {
            errorDiv.classList.remove("visible");
            errorDiv.classList.add("hide");
        }
        return true;
    } else {
        input.classList.remove("is-valid");
        input.classList.add("is-invalid");
        // Si un message d'erreur est présent, on l'affiche'
        if (errorDiv) {
            errorDiv.classList.remove("hide");
            errorDiv.classList.add("visible");
        }
        return false;
    }
}
