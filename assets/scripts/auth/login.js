// Récupération des inputs du formulaire
const inputLoginEmail = document.getElementById("email");
const inputLoginPassword = document.getElementById("password");

const btnLogin = document.getElementById("btnLogin");

// Ajout d'écoute des événements sur les inputs et le bouton
inputLoginEmail.addEventListener("keyup", validateForm);
inputLoginPassword.addEventListener("keyup", validateForm);

//Function permettant de valider tout le formulaire et d'activer le bouton si tout est ok
function validateForm() {
    const mailOk = validateMail(inputLoginEmail);
    const passwordOk = validatePassword(inputLoginPassword);

    if (mailOk && passwordOk) {
        btnLogin.disabled = false;
    } else {
        btnLogin.disabled = true;
    }
}

// Fonction de validation de l'email
function validateMail(input) {
    //Définir mon regex
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const mailUser = input.value;
    const errorDiv = input
        .closest(".form-group")
        ?.querySelector(".error-message");

    if (mailUser.match(emailRegex)) {
        input.classList.add("is-valid");
        input.classList.remove("is-invalid");

        // Si un message d'erreur est présent, on le cache
        if (errorDiv) {
            errorDiv.classList.remove("visible");
            errorDiv.classList.add("hidden");
        }
        return true;
    } else {
        input.classList.remove("is-valid");
        input.classList.add("is-invalid");
        // Si un message d'erreur est présent, on l'affiche'
        if (errorDiv) {
            errorDiv.classList.remove("hidden");
            errorDiv.classList.add("visible");
        }
        return false;
    }
}

// Fonction de validation du mot de passe
function validatePassword(input) {
    //Définir mon regex
    const passwordRegex =
        /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_])[A-Za-z\d\W_]{8,}$/;
    const passwordUser = input.value;
    const errorDiv = input
        .closest(".form-group")
        ?.querySelector(".error-message");
    if (passwordUser.match(passwordRegex)) {
        input.classList.add("is-valid");
        input.classList.remove("is-invalid");
        // Si un message d'erreur est présent, on le cache
        if (errorDiv) {
            errorDiv.classList.remove("visible");
            errorDiv.classList.add("hidden");
        }
        return true;
    } else {
        input.classList.remove("is-valid");
        input.classList.add("is-invalid");
        // Si un message d'erreur est présent, on l'affiche'
        if (errorDiv) {
            errorDiv.classList.remove("hidden");
            errorDiv.classList.add("visible");
        }
        return false;
    }
}

// Fonction de validation des champs requis
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
            errorDiv.classList.add("hidden");
        }
        return true;
    } else {
        input.classList.remove("is-valid");
        input.classList.add("is-invalid");
        // Si un message d'erreur est présent, on l'affiche'
        if (errorDiv) {
            errorDiv.classList.remove("hidden");
            errorDiv.classList.add("visible");
        }
        return false;
    }
}
