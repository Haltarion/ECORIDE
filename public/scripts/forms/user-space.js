import { isAllowedSize, isAllowedType, sanitizeString } from "../security.js";
document.addEventListener("DOMContentLoaded", () => {
    // Script pour la modal de modification de la photo de profil
    const modal = document.getElementById("modal-edit-photo");
    const openBtn = document.getElementById("open-modal-btn");
    const closeBtn = document.getElementById("close-modal");
    const input = document.getElementById("photo-input");
    const fileName = document.getElementById("file-name");
    const img = document.getElementById("modal-photo-profil");
    const photo = document.getElementById("photo-profil");

    openBtn.addEventListener("click", () => {
        modal.classList.add("open");
    });

    closeBtn.addEventListener("click", () => {
        modal.classList.remove("open");
    });

    // Script pour récupérer la photo
    // Variables temporaires
    let tempName = "";
    let tempSrc = "";

    const allowedTypes = ["image/jpeg", "image/png", "image/webp"];
    const maxSize = 2 * 1024 * 1024;

    // Prévisualisation de l'image sélectionnée
    if (!input) {
        console.error("input introuvable !");
        return;
    }
    input.addEventListener("change", function () {
        const file = this.files[0];
        if (!file) return;

        if (!isAllowedType(file, allowedTypes)) {
            alert("Votre image doit être au format JPG, PNG ou WEBP.");
            return;
        }

        if (!isAllowedSize(file, maxSize)) {
            alert("Fichier trop volumineux.");
            return;
        }

        tempName = sanitizeString(file.name);
        fileName.textContent = tempName;

        tempSrc = URL.createObjectURL(file);
        img.src = tempSrc;
    });

    // Afficher la photo de profile stockée en base de données
    if (window.userPhotoFromDB !== "") {
        photo.src = "/uploads/users/" + window.userPhotoFromDB;
    }
});
