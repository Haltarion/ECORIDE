// Récupération des inputs du formulaire
const inputPseudo = document.getElementById("pseudoInput");
const inputMail = document.getElementById("emailInput");
const inputPassword = document.getElementById("passwordInput");
const inputValidationPassword = document.getElementById(
    "validatePasswordInput"
);
const btnValidation = document.getElementById("btnValidationInscription");
const formInscription = document.getElementById("formulaireInscription");

// Ajout d'écoute des événements sur les inputs et le bouton
inputPseudo.addEventListener("keyup", validateSignUpForm);
inputMail.addEventListener("keyup", validateSignUpForm);
inputPassword.addEventListener("keyup", validateSignUpForm);
inputValidationPassword.addEventListener("keyup", validateSignUpForm);

btnValidation.addEventListener("click", InscrireUtilisateur);

//Function permettant de valider tout le formulaire et d'activer le bouton si tout est ok
function validateSignUpForm() {
    const nomOk = validateRequired(inputPseudo);
    const mailOk = validateMail(inputMail);
    const passwordOk = validatePassword(inputPassword);
    const passwordConfirmOk = validateConfirmationPassword(
        inputPassword,
        inputValidationPassword
    );

    if (nomOk && mailOk && passwordOk && passwordConfirmOk) {
        btnValidation.disabled = false;
    } else {
        btnValidation.disabled = true;
    }
}

// Fonction de validation de l'email
function validateMail(input) {
    //Définir mon regex
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const mailUser = input.value;
    if (mailUser.match(emailRegex)) {
        input.classList.add("is-valid");
        input.classList.remove("is-invalid");
        return true;
    } else {
        input.classList.remove("is-valid");
        input.classList.add("is-invalid");
        return false;
    }
}

// Fonction de validation du mot de passe
function validatePassword(input) {
    //Définir mon regex
    const passwordRegex =
        /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_])[A-Za-z\d\W_]{8,}$/;
    const passwordUser = input.value;
    if (passwordUser.match(passwordRegex)) {
        input.classList.add("is-valid");
        input.classList.remove("is-invalid");
        return true;
    } else {
        input.classList.remove("is-valid");
        input.classList.add("is-invalid");
        return false;
    }
}

// Fonction de validation de la confirmation du mot de passe
function validateConfirmationPassword(inputPwd, inputConfirmPwd) {
    if (inputPwd.value == inputConfirmPwd.value) {
        inputConfirmPwd.classList.add("is-valid");
        inputConfirmPwd.classList.remove("is-invalid");
        return true;
    } else {
        inputConfirmPwd.classList.add("is-invalid");
        inputConfirmPwd.classList.remove("is-valid");
        return false;
    }
}

// Fonction de validation des champs requis
function validateRequired(input) {
    if (input.value != "") {
        input.classList.add("is-valid");
        input.classList.remove("is-invalid");
        return true;
    } else {
        input.classList.remove("is-valid");
        input.classList.add("is-invalid");
        return false;
    }
}

// Fonction d'inscription de l'utilisateur
function InscrireUtilisateur() {
    let dataForm = new FormData(formInscription);

    const myHeaders = new Headers();
    myHeaders.append("Content-Type", "application/json");

    const raw = JSON.stringify({
        firstName: dataForm.get("pseudo"),
        email: dataForm.get("email"),
        password: dataForm.get("mdp"),
    });

    const requestOptions = {
        method: "POST",
        headers: myHeaders,
        body: raw,
        redirect: "follow",
    };

    fetch(apiUrl + "registration", requestOptions)
        .then((response) => {
            if (response.ok) {
                return response.json();
            } else {
                alert("Erreur lors de l'inscription");
            }
        })
        .then((result) => {
            alert(
                "Bravo " +
                    dataForm.get("prenom") +
                    ", vous êtes maintenant inscrit, vous pouvez vous connecter !"
            );
            document.location.href = "/signin";
        })
        .catch((error) => console.error(error));
}
