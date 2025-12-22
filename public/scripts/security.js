// Fonction de sécurité pour nettoyer les entrées utilisateur
export function sanitizeString(str) {
    str = str.replace(/^.*[\\/]/, "");
    str = str.replace(/[<>:"'|?*]/g, "_");
    str = str
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
    return str;
}

// Fonction de validation pour les types de fichiers autorisés
export function isAllowedType(file, allowedTypes) {
    return allowedTypes.includes(file.type);
}

// Fonction de validation pour la taille maximale des fichiers
export function isAllowedSize(file, maxSize) {
    return file.size <= maxSize;
}

// Fonction de validation de l'email
export function validateMail(input) {
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
export function validatePassword(input) {
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

// Fonction de validation de la confirmation du mot de passe
export function validateConfirmationPassword(inputPwd, inputConfirmPwd) {
    const errorDiv = inputConfirmPwd
        .closest(".form-group")
        ?.querySelector(".error-message");
    if (inputPwd.value == inputConfirmPwd.value) {
        inputConfirmPwd.classList.add("is-valid");
        inputConfirmPwd.classList.remove("is-invalid");
        // Si un message d'erreur est présent, on le cache
        if (errorDiv) {
            errorDiv.classList.remove("visible");
            errorDiv.classList.add("hidden");
        }
        return true;
    } else {
        inputConfirmPwd.classList.add("is-invalid");
        inputConfirmPwd.classList.remove("is-valid");
        // Si un message d'erreur est présent, on l'affiche'
        if (errorDiv) {
            errorDiv.classList.remove("hidden");
            errorDiv.classList.add("visible");
        }
        return false;
    }
}

// Fonction de validation des champs requis
export function validateRequired(input) {
    const errorDiv = input
        .closest(".form-group")
        ?.querySelector(".error-message");
    if (input.value != "") {
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
