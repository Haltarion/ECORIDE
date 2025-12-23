import { validateDate, validatePlaque, validateString } from "../security.js";

const plaqueInput = document.getElementById("immatriculation");
const premiereImmat = document.getElementById("premiereImmatriculation");
const marqueInput = document.getElementById("marque");
const modeleInput = document.getElementById("modele");
const couleurInput = document.getElementById("couleur");

function formatPlaque(value) {
    const cleaned = value.replace(/[^A-Za-z0-9]/g, "").toUpperCase();
    const part1 = cleaned.slice(0, 2);
    const part2 = cleaned.slice(2, 5);
    const part3 = cleaned.slice(5, 7);
    let formatted = part1;
    if (part2) {
        formatted += `-${part2}`;
    }
    if (part3) {
        formatted += `-${part3}`;
    }
    return formatted;
}

function verifPlaqueInput() {
    if (!plaqueInput) return;
    const formatted = formatPlaque(plaqueInput.value);
    if (plaqueInput.value !== formatted) {
        plaqueInput.value = formatted;
    }
    validatePlaque(plaqueInput);
}

function verifDateInput() {
    if (!premiereImmat) return;
    validateDate(premiereImmat);
}

function verifTextInput(event) {
    const input = event.target;
    if (!input) return;
    validateString(input);
}

if (plaqueInput) {
    plaqueInput.addEventListener("input", verifPlaqueInput);
}

if (premiereImmat) {
    premiereImmat.addEventListener("input", verifDateInput);
}

if (marqueInput) {
    marqueInput.addEventListener("keyup", verifTextInput);
}

if (modeleInput) {
    modeleInput.addEventListener("keyup", verifTextInput);
}

if (couleurInput) {
    couleurInput.addEventListener("keyup", verifTextInput);
}
