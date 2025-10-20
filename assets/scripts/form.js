// Verification des formulaires

// Vérification des champs requis

// Search-ride.html.twig
// Récupération des champs
const inputAdresseDepart = document.getElementById("adresseDepart");
const inputDateDepart = document.getElementById("dateDepart");
const inputAdresseArrivee = document.getElementById("adresseArrivee");
const inputDateArrivee = document.getElementById("dateArrivee");
const btnSearchRide = document.getElementById("btnSearchRide");
const formInscription = document.getElementById("formSearchRide");

// Ajout des écouteurs sur chaque input text
inputAdresseDepart.addEventListener("keyup", validateRequired);
inputAdresseArrivee.addEventListener("keyup", validateRequired);
inputDateDepart.addEventListener("input", validateRequired);
inputDateArrivee.addEventListener("input", validateRequired);

// Fonction de validation d'un champ
function validateRequired(event) {
    const input = event.target;
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
