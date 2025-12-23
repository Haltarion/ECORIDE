// Fonction pour appliquer l'état de validation à un champ de formulaire
function applyValidationState(input, isValid) {
    const errorDiv = input
        .closest(".form-group")
        ?.querySelector(".error-message");

    if (isValid) {
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

// Fonction de validation pour les chaînes de caractères (non vides après nettoyage)
export function validateString(input) {
    const rawValue = input.value;

    const sanitizedValue = sanitizeString(rawValue);

    if (sanitizedValue !== rawValue) {
        input.value = sanitizedValue;
    }

    const isValid = input.value !== "";

    return applyValidationState(input, isValid);
}

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

/**
 * Valider un email avec une expression régulière
 * Si l'email n'est pas valide, retourne false
 * @param email
 * @return Boolean
 */
function isEmailValid(mailUser) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(mailUser);
}

// Fonction de validation de l'email
export function validateMail(input) {
    const mailUser = input.value;
    const isValid = isEmailValid(mailUser);
    return applyValidationState(input, isValid);
}

/**
 * Valider un mot de passe avec une expression régulière
 * Si le mot de passe n'est pas valide, retourne false
 * @param password
 * @return Boolean
 */
function isPasswordValid(passwordUser) {
    const passwordRegex =
        /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_])[A-Za-z\d\W_]{8,}$/;
    return passwordRegex.test(passwordUser);
}

// Fonction de validation du mot de passe
export function validatePassword(input) {
    const passwordUser = input.value;
    const isValid = isPasswordValid(passwordUser);
    return applyValidationState(input, isValid);
}

// Fonction de validation du format de la confirmation du mot de passe
export function validateConfirmationPassword(inputPwd, inputConfirmPwd) {
    const isValid = inputPwd.value == inputConfirmPwd.value;
    return applyValidationState(inputConfirmPwd, isValid);
}

// Fonction de validation des champs requis
export function validateRequired(input) {
    const isValid = input.value !== "";
    return applyValidationState(input, isValid);
}

/**
 * Valider une plaque d'immatriculation avec une expression régulière
 * Si la plaque n'est pas valide, retourne false
 * @param plaque
 * @return Boolean
 */
function isPlaqueValid(plaque) {
    const plaqueRegex = /^[A-Z]{2}-[0-9]{3}-[A-Z]{2}$/;
    return plaqueRegex.test(plaque);
}

// Fonction de validation de la plaque d'immatriculation
export function validatePlaque(input) {
    const plaque = input.value;
    const isValid = isPlaqueValid(plaque);
    return applyValidationState(input, isValid);
}

/**
 * Valider une date avec une expression régulière
 * Si la date n'est pas valide, retourne false
 * @param date
 * @return Boolean
 */
function isDateValid(date) {
    const dateRegex =
        /^(000[1-9]|00[1-9]\d|0[1-9]\d\d|100\d|10[1-9]\d|1[1-9]\d{2}|[2-9]\d{3}|[1-9]\d{4}|1\d{5}|2[0-6]\d{4}|27[0-4]\d{3}|275[0-6]\d{2}|2757[0-5]\d|275760)-(0[1-9]|1[012])-(0[1-9]|[12]\d|3[01])$/gm;
    return dateRegex.test(date);
}

// Fonction de validation de la date
export function validateDate(input) {
    const date = input.value;
    const isValid = isDateValid(date);
    return applyValidationState(input, isValid);
}
