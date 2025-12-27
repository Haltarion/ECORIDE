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
        vehicleItem.className =
            "vehicle-item f-row f-w al-center just-sb g-10 p-15 b-1 b-secondary r-15";
        vehicleItem.style.cursor = "pointer";
        vehicleItem.style.marginBottom = "8px";

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

        const electricWrapper = document.createElement("div");
        electricWrapper.className = vehicle.isElectric
            ? "energy-indicator is-electric"
            : "energy-indicator is-not-electric";
        electricWrapper.appendChild(createEnergyIcon(vehicle.isElectric));

        const spacer = document.createElement("div");

        vehicleItem.appendChild(plaque);
        vehicleItem.appendChild(info);
        vehicleItem.appendChild(electricWrapper);
        vehicleItem.appendChild(spacer);

        vehicleItem.addEventListener("click", (e) => {
            e.stopPropagation();
            selectVehicle(vehicle);
            toggleDropdown();
        });

        vehiclesList.appendChild(vehicleItem);
    });
}

// Icône énergie dynamique selon isElectric (pas de données utilisateur injectées)
function createEnergyIcon(isElectric) {
    const svg = document.createElementNS("http://www.w3.org/2000/svg", "svg");
    svg.setAttribute("xmlns", "http://www.w3.org/2000/svg");
    svg.setAttribute("viewBox", "0 0 24 24");
    svg.setAttribute("fill", "currentColor");
    svg.setAttribute("class", "size-6");

    const path = document.createElementNS("http://www.w3.org/2000/svg", "path");
    path.setAttribute("fill-rule", "evenodd");
    path.setAttribute(
        "d",
        isElectric
            ? "M9.11 3.564a.75.75 0 0 1 .832-.224l9 3a.75.75 0 0 1 .115 1.384l-4.484 2.69 2.987 6.27a.75.75 0 0 1-1.172.888l-9-7a.75.75 0 0 1 .118-1.243l4.5-2.7-2.996-2.405a.75.75 0 0 1-.2-.66Z"
            : "M14.615 1.595a.75.75 0 0 1 .359.852L12.982 9.75h7.268a.75.75 0 0 1 .548 1.262l-10.5 11.25a.75.75 0 0 1-1.272-.71l1.992-7.302H3.75a.75.75 0 0 1-.548-1.262l10.5-11.25a.75.75 0 0 1 .913-.143Z"
    );
    path.setAttribute("clip-rule", "evenodd");

    svg.appendChild(path);
    return svg;
}

// Sélectionner un véhicule
function selectVehicle(vehicle) {
    selectedVehicle = vehicle;
    document.getElementById("vehicleImmatriculation").textContent =
        vehicle.immatriculation || "--";
    document.getElementById("vehicleMarque").textContent =
        vehicle.marque || "Marque";
    document.getElementById("vehicleModele").textContent =
        vehicle.modele || "Modèle";
    document.getElementById("selectedVehicleId").value = vehicle.id || "";

    const energySlot = document.getElementById("vehicleEnergy");
    if (energySlot) {
        energySlot.className = `f-col just-center h-100 ${
            vehicle.isElectric ? "is-electric" : "is-not-electric"
        }`;
        energySlot.replaceChildren(createEnergyIcon(!!vehicle.isElectric));
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
    if (dropdownOpen) {
        icon.style.transform = "rotate(180deg)";
    } else {
        icon.style.transform = "rotate(0deg)";
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
