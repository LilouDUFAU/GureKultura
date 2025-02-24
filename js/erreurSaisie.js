function verifErreurSaisie(input) {
    var valeur = input.value.trim();
    var type = input.type;
    // Vérification des champs en fonction du type
    switch (type) {
        case "text": // Zone de texte
            if (input.id === "titre" && (valeur === "" || valeur.length > 50)) {
                addError(input, "Les titres ne peuvent pas être vides ou dépasser 50 caractères !");

            } else if (input.id === "description" && (valeur === "" || valeur.length > 50)) {
                addError(input, "Les titres ne peuvent pas être vides ou dépasser 50 caractères !");

            } else {
                removeError(input);
            }
            break;

        case "email":
            console.log("email");
            var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(valeur)) {
                addError(input, "veuilez entré un email valide ! mmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmm");

            } else {
                removeError(input);
            }
            break;

        case "tel": //numeroTel
            console.log("tel");
            var nombre = parseInt(valeur, 10);
            if (isNaN(nombre) || valeur.length != 10 || valeur[0] != 0) {
                addError(input, "veuillez entrer un numéro de téléphone valide !");

            } else {
                removeError(input);
            }
            break;

        default:
            break;
    }
}

function removeError(input) {
    var divParent = input.parentElement.childNodes;
    var exist = false;
    divParent.forEach(enfantDiv => {
        if (enfantDiv.id == "iconErreur" || enfantDiv.id == "messageErreur") {
            exist = true;
        }
    });
    if (exist) {
        document.getElementById("iconErreur").remove();
        document.getElementById("messageErreur").remove();
        input.classList.add("border-white");
        input.classList.remove("border-error");
    }
}

function addError(input, msgError) {

    var divParent = input.parentElement.childNodes;
    var exist = false;

    var iconErreur = document.createElement("img");

    iconErreur.src = "../asset/icones/eye.svg";
    iconErreur.alt = "Erreur de saisie";
    iconErreur.className = "absolute right-2 top-1/2 transform -translate-y-1/2 w-6 h-6 py-1 rounded-md";
    iconErreur.id = "iconErreur";

    var messageErreur = document.createElement("p");

    messageErreur.className = "row-start-3 absolute w-full h-6 py-1 text-error";
    messageErreur.id = "messageErreur";

    divParent.forEach(enfantDiv => {
        if (enfantDiv.id == "iconErreur" || enfantDiv.id == "messageErreur") {
            exist = true;
        }
    });
    if (!exist) {

        input.classList.remove("border-white");
        input.classList.add("border-error");
        messageErreur.innerHTML = msgError;
        input.parentElement.appendChild(iconErreur);
        input.parentElement.appendChild(messageErreur);
    }

}