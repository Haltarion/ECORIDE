let allVehicles = [];
let selectedVehicle = null;
let dropdownOpen = false;

// Charger les véhicules depuis l'API
async function loadVehicles() {
    try {
        const response = await fetch("/suggest-trip/vehicules");
        const data = await response.json();

        if (data.voitures && data.voitures.length > 0) {
            allVehicles = data.voitures;

            // Afficher le premier véhicule par défaut
            selectVehicle(allVehicles[0]);

            // Remplir la liste déroulante
            populateVehiclesList();
        }
    } catch (error) {
        console.error("Erreur lors du chargement des véhicules:", error);
    }
}

// Remplir la liste déroulante avec les véhicules
function populateVehiclesList() {
    const vehiclesList = document.getElementById("vehiclesList");
    vehiclesList.innerHTML = "";

    allVehicles.forEach((vehicle) => {
        const vehicleItem = document.createElement("div");
        vehicleItem.className = "vehicle-item";

        const plaque = document.createElement("div");
        plaque.className = "plaque relative";
        const immat = document.createElement("p");
        immat.className = "immatriculation";
        immat.textContent = vehicle.immatriculation || "--";
        plaque.appendChild(immat);

        const info = document.createElement("div");
        info.className = "f-col g-5 just-center al-start";
        const marque = document.createElement("h3");
        marque.textContent = vehicle.marque || "Marque";
        const modele = document.createElement("p");
        modele.textContent = vehicle.modele || "Modèle";
        info.appendChild(marque);
        info.appendChild(modele);

        const nbPlaces = document.createElement("div");
        nbPlaces.className = "nbPlaces";
        const placesText = document.createElement("p");
        placesText.textContent = vehicle.nbPlaceDispo || "2";
        const smallerText = document.createElement("span");
        smallerText.className = "smaller-text";
        smallerText.textContent = " places";
        placesText.appendChild(smallerText);
        nbPlaces.appendChild(placesText);

        const electricIcone = document.createElement("div");
        electricIcone.className = vehicle.electrique
            ? "is-electric"
            : "is-not-electric";
        electricIcone.appendChild(createEnergyIcon(!!vehicle.electrique));

        const spacer = document.createElement("div");

        vehicleItem.appendChild(plaque);
        vehicleItem.appendChild(info);
        vehicleItem.appendChild(nbPlaces);
        vehicleItem.appendChild(electricIcone);
        vehicleItem.appendChild(spacer);

        vehicleItem.addEventListener("click", (e) => {
            e.stopPropagation();
            selectVehicle(vehicle);
            toggleDropdown();
        });

        vehiclesList.appendChild(vehicleItem);
    });
}

// Création de l'icône d'énergie
function createEnergyIcon() {
    const svg = document.createElementNS("http://www.w3.org/2000/svg", "svg");
    svg.setAttribute("xmlns", "http://www.w3.org/2000/svg");
    svg.setAttribute("viewBox", "0 0 24 24");
    svg.setAttribute("fill", "currentColor");
    svg.setAttribute("class", "size-6");

    const path = document.createElementNS("http://www.w3.org/2000/svg", "path");
    path.setAttribute("fill-rule", "evenodd");
    path.setAttribute(
        "d",
        "M14.615 1.595a.75.75 0 0 1 .359.852L12.982 9.75h7.268a.75.75 0 0 1 .548 1.262l-10.5 11.25a.75.75 0 0 1-1.272-.71l1.992-7.302H3.75a.75.75 0 0 1-.548-1.262l10.5-11.25a.75.75 0 0 1 .913-.143Z"
    );
    path.setAttribute("clip-rule", "evenodd");

    svg.appendChild(path);
    return svg;
}

// Générer la liste déroulante des véhicules
function selectVehicle(vehicle) {
    const smallerText = document.createElement("span");
    smallerText.className = "smaller-text";
    smallerText.textContent = " places";
    selectedVehicle = vehicle;
    document.getElementById("vehicleImmatriculation").textContent =
        vehicle.immatriculation || "--";
    document.getElementById("vehicleMarque").textContent =
        vehicle.marque || "Marque";
    document.getElementById("vehicleModele").textContent =
        vehicle.modele || "Modèle";
    document.getElementById("vehicleNbPlaces").firstChild.textContent =
        vehicle.nbPlaceDispo || "2";
    document.getElementById("selectedVehicleId").value = vehicle.id || "";

    // Changer la classe de l'icône électrique
    const energyIcon = document.getElementById("vehicleSelectionEnergieIcon");
    if (energyIcon) {
        energyIcon.className = vehicle.electrique
            ? "is-electric"
            : "is-not-electric";
    }
}

// Basculer l'affichage de la liste déroulante
function toggleDropdown() {
    dropdownOpen = !dropdownOpen;
    const vehiclesList = document.getElementById("vehiclesList");
    vehiclesList.style.display = dropdownOpen ? "block" : "none";

    const icon = document
        .getElementById("vehicleDropdownIcon")
        .querySelector("svg");
    if (icon) {
        icon.style.transform = dropdownOpen ? "rotate(180deg)" : "rotate(0deg)";
    }
}

// Ajouter les événements au chargement du DOM
document.addEventListener("DOMContentLoaded", () => {
    // Charger les véhicules
    loadVehicles();

    // Ajouter un événement au clic sur la div de sélection
    const vehicleSelection = document.getElementById("vehicleSelection");
    vehicleSelection.addEventListener("click", toggleDropdown);

    // Fermer la liste déroulante quand on clique ailleurs
    document.addEventListener("click", (e) => {
        const vehicleContainer = document.querySelector(".vehicle-container");
        if (!vehicleContainer.contains(e.target) && dropdownOpen) {
            toggleDropdown();
        }
    });
});
