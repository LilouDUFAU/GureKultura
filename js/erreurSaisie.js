function verifErreurSaisie(input) {
    var valeur = input.value.trim();
    var type = input.type;
    // Vérification des champs en fonction du type
    switch (type) {
        case "text": // Zone de texte
            if (input.id === "titre" && (valeur === "" || valeur.length > 50)) {
                addErrorForm(input, "Les titres ne peuvent pas être vides ou dépasser 50 caractères !");
            } else if (input.id === "nomRep" && valeur === "") {
                addErrorForm(input, "Le Nom ne peut pas être vide !");
            } else if (input.id === "nom" && valeur === "") {
                addErrorForm(input, "Le Nom ne peut pas être vide !");
            } else if (input.id === "pseudo" && valeur === "") {
                addErrorForm(input, "Le Pseudo ne peut pas être vide !");
            } else if (input.id === "prenomRep" && valeur === "") {
                addErrorForm(input, "Le Prenom ne peut pas être vide !");
            } else {
                removeErrorForm(input);
            }
            break;

        case "email":
            console.log("email");
            var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(valeur)) {
                addErrorForm(input, "Veuilez entrer un email valide !");

            } else {
                removeErrorForm(input);
            }
            break;

        case "tel": //numeroTel
            console.log("tel");
            var nombre = parseInt(valeur, 10);
            if (isNaN(nombre) || valeur.length != 10 || valeur[0] != 0) {
                addErrorForm(input, "Veuillez entrer un numéro de téléphone valide !");

            } else {
                removeErrorForm(input);
            }
            break;

        case "textarea":
            if (input.id === "description" && (valeur === "" || valeur.length > 500)) {
                addErrorForm(input, "La description ne peux pas être vide ou dépasser 500 caractères !");
            } else if ((input.id === "resume" || input.id === "contenu") && (valeur === "" || valeur.length > 500)) {
                addErrorForm(input, "Le " + input.id + " ne peux pas être vides ou dépasser 500 caractères !");
            } else if (input.id === "lieu" && valeur === "") {
                addErrorForm(input, "Le lieu ne peut pas être vide !");
            } else {
                removeErrorForm(input);
            }
            break;

        case "date":
            var dateDebut = document.getElementById("debutDate");
            var dateFin = document.getElementById("finDate");
            var dateActuelle = new Date().toISOString().split('T')[0];

            if (valeur < dateActuelle) {
                addErrorForm(input, "La date ne peut pas être inférieure à la date actuelle !");
            } else if (input.id === "debutDate" && valeur > dateFin.value) {
                addErrorForm(dateDebut, "La date ne peut pas être supérieur à la date de fin !");
                addErrorForm(dateFin, "La date ne peut pas être inférieure à la date de début !");
            } else if (input.id === "finDate" && valeur < dateDebut.value) {
                addErrorForm(dateFin, "La date ne peut pas être inférieure à la date de début !");
                addErrorForm(dateDebut, "La date ne peut pas être supérieur à la date de fin !");
            } else {
                removeErrorForm(dateDebut);
                removeErrorForm(dateFin);
            }
            break;

        case "time":
            var heureDebut = document.getElementById("debutHeure");
            var heureFin = document.getElementById("finHeure");
            if (input.id === "debutHeure" && valeur > heureFin.value && heureFin.value !== "") {

                addErrorForm(input, "L'heure ne peut pas être supérieur à l'heure de fin !");
                addErrorForm(heureFin, "L'heure ne peut pas être inférieure à l'heure de début !");

            } else if (input.id === "debutHeure" && valeur === "") {

                addErrorForm(input, "L'heure ne peut pas être vide !");

            } else if (input.id === "finHeure" && valeur < heureDebut.value && heureDebut.value !== "") {

                addErrorForm(input, "L'heure ne peut pas être inférieure à l'heure de début !");
                addErrorForm(heureDebut, "L'heure ne peut pas être supérieur à l'heure de fin !");

            } else if (input.id === "finHeure" && valeur < heureDebut.value) {

                addErrorForm(input, "L'heure ne peut pas etre vide !");

            }
            else {
                removeErrorForm(heureDebut);
                removeErrorForm(heureFin);
            }
            break;

        default:
            break;
    }
}

function removeErrorForm(input) {
    var divParent = input.parentElement.childNodes;
    var exist = false;
    divParent.forEach(enfantDiv => {
        if (enfantDiv.id === "messageErreur") {
            input.parentElement.children['messageErreur'].remove();
            exist = true;
        }
    });
    if (exist) {
        input.classList.add("border-white");
        input.classList.remove("border-error");
    }


    var messageErrExist = document.getElementById("messageErreur");
    var btnValider = document.getElementById("validerFormulaire");
    if (btnValider !== null && btnValider.disabled && messageErrExist == null) {
        btnValider.disabled = false;
    }

}

function addErrorForm(input, msgError) {

    var divParent = input.parentElement.childNodes;
    var exist = false;

    var messageErreur = document.createElement("p");

    messageErreur.className = "text-xs flex-none break-words text-error";
    messageErreur.id = "messageErreur";

    divParent.forEach(enfantDiv => {
        if (enfantDiv.id === "messageErreur") {
            exist = true;
        }
    });

    if (!exist) {
        input.classList.remove("border-white");
        input.classList.add("border-error");
        messageErreur.innerHTML = msgError;
        input.parentElement.appendChild(messageErreur);
    }
    var btnValider = document.getElementById("validerFormulaire");
    if (btnValider !== null && !btnValider.disabled) {
        btnValider.disabled = true;
    }

}