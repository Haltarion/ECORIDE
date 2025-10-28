const mailInput = document.getElementById("EmailInput");
const passwordInput = document.getElementById("PasswordInput");
const btnSingin = document.getElementById("btnSignin");
const signinForm = document.getElementById("signinForm");

btnSingin.addEventListener("click", checkCredentials);

// Vérification des identifiants
function checkCredentials() {
    let dataForm = new FormData(signinForm);

    const myHeaders = new Headers();
    myHeaders.append("Content-Type", "application/json");

    const raw = JSON.stringify({
        username: dataForm.get("email"),
        password: dataForm.get("mdp"),
    });

    const requestOptions = {
        method: "POST",
        headers: myHeaders,
        body: raw,
        redirect: "follow",
    };

    // Appel API pour la vérification des identifiants
    fetch(apiUrl + "login", requestOptions)
        .then((response) => {
            if (response.ok) {
                return response.json();
            } else {
                mailInput.classList.add("is-invalid");
                passwordInput.classList.add("is-invalid");
            }
        })
        .then((result) => {
            const token = result.apiToken;
            setToken(token);

            //placer ce token en cookie
            setCookie(RoleCookieName, result.roles[0], 7);
            window.location.replace("/");
        })
        .catch((error) => console.error(error));
}
