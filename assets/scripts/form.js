// Verification des formulaires

// Search-ride.html.twig
// Récupération des inputs du formulaire
const inputAdresseDepart = document.getElementById("adresseDepart");
const inputDateDepart = document.getElementById("dateDepart");
const inputAdresseArrivee = document.getElementById("adresseArrivee");
const inputDateArrivee = document.getElementById("dateArrivee");

const btnSearchRide = document.getElementById("btnSearchRide");
const formSearchRide = document.getElementById("formSearchRide");

// Ajout d'écoute des événements sur les inputs et le bouton
inputAdresseDepart.addEventListener("keyup", validateForm);
inputAdresseArrivee.addEventListener("keyup", validateForm);
inputDateDepart.addEventListener("input", validateForm);
inputDateArrivee.addEventListener("input", validateForm);

btnSearchRide.addEventListener("click", AfficherCovoiturages);

//Function permettant de valider tout le formulaire et d'activer le bouton si tout est ok
function validateForm() {
    const adresseDepartOk = validateRequired(inputAdresseDepart);
    const AdresseArriveeOk = validateRequired(inputAdresseArrivee);
    const DateDepartOk = validateRequired(inputDateDepart);
    const DateArriveeOk = validateRequired(inputDateArrivee);

    if (adresseDepartOk && AdresseArriveeOk && DateDepartOk && DateArriveeOk) {
        btnSearchRide.disabled = false;
    } else {
        btnSearchRide.disabled = true;
    }
}

// Fonction de validation d'un champ
function validateRequired(input) {
    if (input.value.trim() != "") {
        input.classList.remove("is-invalid");
        input.classList.add("is-valid");
        return true;
    } else {
        input.classList.remove("is-valid");
        input.classList.add("is-invalid");
        return false;
    }
}
