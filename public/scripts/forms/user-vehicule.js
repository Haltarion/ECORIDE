import {
    validateDate,
    validateNb,
    validatePlaque,
    validateString,
} from "/scripts/security.js";

const plaqueInput = document.getElementById("immatriculation");
const premiereImmat = document.getElementById("premiereImmatriculation");
const marqueInput = document.getElementById("marque");
const modeleInput = document.getElementById("modele");
const couleurInput = document.getElementById("couleur");
const nbInput = document.getElementById("placesDispo");

const btnAddVehicule = document.getElementById("addVehicule");
const form = document.getElementById("new-vehicle-form");

let plaqueOk = false;
let dateOk = false;
let marqueOk = false;
let modeleOk = false;
let couleurOk = false;
let nbOk = true;

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
    plaqueOk = validatePlaque(plaqueInput);
}

function verifDateInput() {
    if (!premiereImmat) return;
    dateOk = validateDate(premiereImmat);
}

function verifTextInput(input) {
    if (!input) return false;
    return validateString(input);
}

function verifNbInput(input) {
    if (!input) return false;
    return validateNb(input);
}

if (plaqueInput) {
    plaqueInput.addEventListener("input", () => {
        verifPlaqueInput();
        validateForm();
    });
}

if (premiereImmat) {
    premiereImmat.addEventListener("input", () => {
        verifDateInput();
        validateForm();
    });
}

if (marqueInput) {
    marqueInput.addEventListener("input", () => {
        marqueOk = verifTextInput(marqueInput);
        validateForm();
    });
}

if (modeleInput) {
    modeleInput.addEventListener("input", () => {
        modeleOk = verifTextInput(modeleInput);
        validateForm();
    });
}

if (couleurInput) {
    couleurInput.addEventListener("input", () => {
        couleurOk = verifTextInput(couleurInput);
        validateForm();
    });
}

if (nbInput) {
    nbInput.addEventListener("input", () => {
        nbOk = verifNbInput(nbInput);
        validateForm();
    });
}

//Function permettant de valider tout le formulaire et d'activer le bouton si tout est ok
function validateForm() {
    if (!btnAddVehicule) return;
    btnAddVehicule.disabled = !(
        plaqueOk &&
        dateOk &&
        marqueOk &&
        modeleOk &&
        couleurOk &&
        nbOk
    );
}

validateForm();

btnAddVehicule.addEventListener("click", async (event) => {
    event.preventDefault();
    verifPlaqueInput();
    if (!plaqueOk) {
        alert("Veuillez corriger la plaque d'immatriculation");
        return;
    }
    const value = plaqueInput.value.trim();
    try {
        const res = await fetch("/user-vehicle/check-immatriculation", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ immatriculation: value }),
        });
        const data = await res.json();
        if (data.exists) {
            alert("Ce véhicule existe déjà. Modifiez la plaque.");
            return;
        }
        alert("Véhicule ajouté avec succès !");
        form && form.submit();
    } catch (e) {
        alert("Erreur de vérification. Réessayez.");
    }
});

// Script pour la modal d'ajout de véhicule
const vehiculeModal = document.getElementById("modal-new-vehicule");
const openModalVehicule = document.getElementById("openModalVehicule");
const closeModalVehicule = document.getElementById("closeModalVehicule");

openModalVehicule.addEventListener("click", () => {
    vehiculeModal.classList.add("open");
});

closeModalVehicule.addEventListener("click", (e) => {
    e.preventDefault(); // Empêcher la soumission du formulaire
    vehiculeModal.classList.remove("open");
});
