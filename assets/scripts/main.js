// Verification des formulaires

// Vérification des champs requis

// Search-ride.html.twig
// Sélection des champs
const inputAdresseDepart = document.getElementById("adresseDepart");
const inputDateDepart = document.getElementById("dateDepart");
const inputAdresseArrivee = document.getElementById("adresseArrivee");
const inputDateArrivee = document.getElementById("dateArrivee");

// Ajout des écouteurs sur chaque input
[
    inputAdresseDepart,
    inputDateDepart,
    inputAdresseArrivee,
    inputDateArrivee,
].forEach((input) => {
    if (input) input.addEventListener("input", validateRequired);
});

// Fonction de validation d'un champ
function validateRequired(event) {
    const input = event.target;
    const alertDiv = input.closest(".form-group").nextElementSibling; // le div .component__alerte juste après

    if (input.value.trim() !== "") {
        input.classList.add("is-valid");
        input.classList.remove("is-invalid");
        if (alertDiv) alertDiv.style.display = "none";
    } else {
        input.classList.remove("is-valid");
        input.classList.add("is-invalid");
        if (alertDiv) alertDiv.style.display = "flex";
    }
    console.log("Champ :", input.id, "Valeur :", input.value);
}
