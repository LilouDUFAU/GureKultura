function verifErreurSaisie(input) {
    var valeur = input.value.trim();
    var type = input.type;
    // Vérification des champs en fonction du type
    switch (type) {
        case "text": // Zone de texte
            if (input.id === "titre" && (valeur === "" || (valeur.length > 50 || valeur.length < 5))) {
                addErrorForm(input, "La taille du titre doit être comprise entre 5 et 50 caractères.");
            } else if (input.id === "nomRep" && valeur === "") {
                addErrorForm(input, "Veuillez renseigner un nom.");
            } else if (input.id === "nom" && valeur === "") {
                addErrorForm(input, "Veuillez renseigner un nom.");
            } else if (input.id === "pseudo" && valeur === "") {
                addErrorForm(input, "Veuillez renseigner un pseudo.");
            } else if (input.id === "prenomRep" && valeur === "") {
                addErrorForm(input, "Veuillez renseigner un pseudo.");
            } else {
                removeErrorForm(input);
            }
            break;

        case "email":
            var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(valeur)) {
                addErrorForm(input, "Veuilez renseigner un email valide.");

            } else {
                removeErrorForm(input);
            }
            break;

        case "tel": //numeroTel
            console.log("tel");
            var nombre = parseInt(valeur, 10);
            if (isNaN(nombre) || valeur.length != 10 || valeur[0] != 0) {
                addErrorForm(input, "Veuillez renseigner un numéro de téléphone valide.");

            } else {
                removeErrorForm(input);
            }
            break;

        case "textarea":
            if (input.id === "description" && (valeur === "" || (valeur.length > 500 || valeur.length < 30))) {
                addErrorForm(input, "La taille de la description doit être comprise entre 30 et 500 caractères.");
            } else if ((input.id === "resume" || input.id === "contenu") && (valeur === "" || (valeur.length > 500 || valeur.length < 30))) {
                addErrorForm(input, "La taille du " + input.id + " doit être comprise entre 30 et 500 caractères.");
            } else if (input.id === "lieu" && (valeur === "" || (valeur.length > 100 || valeur.length < 5))) {
                addErrorForm(input, "La taille de la description doit être comprise entre 5 et 100 caractères.");
            } else {
                removeErrorForm(input);
            }
            break;

        case "date":
            var dateDebut = document.getElementById("debutDate");
            var dateFin = document.getElementById("finDate");
            var dateActuelle = new Date().toISOString().split('T')[0];

            if (valeur < dateActuelle) {
                addErrorForm(input, "Veuillez renseigner une date qui n'est pas antérieure à la date actuelle.");
            } else if (input.id === "debutDate" && valeur > dateFin.value) {
                addErrorForm(dateDebut, "Veuillez renseigner une date de début antérieure ou égale à la date de fin.");
                addErrorForm(dateFin, "Veuillez renseigner une date de fin postérieure ou égale à la date de début.");
            } else if (input.id === "finDate" && valeur < dateDebut.value) {
                addErrorForm(dateFin, "Veuillez renseigner une date de fin postérieure ou égale à la date de début.");
                addErrorForm(dateDebut, "Veuillez renseigner une date de début antérieure ou égale à la date de fin.");
            } else {
                removeErrorForm(dateDebut);
                removeErrorForm(dateFin);
            }
            break;

        case "time":
            var heureDebut = document.getElementById("debutHeure");
            var heureFin = document.getElementById("finHeure");
            if (input.id === "debutHeure" && valeur > heureFin.value && heureFin.value !== "") {

                addErrorForm(input, "Veuillez renseigner une heure de début antérieure ou égale à l'heure de fin.");
                addErrorForm(heureFin, "Veuillez renseigner une heure de fin postérieure ou égale à l'heure de début.");

            } else if (input.id === "debutHeure" && valeur === "") {

                addErrorForm(input, "Veuillez renseigner une heure.");

            } else if (input.id === "finHeure" && valeur < heureDebut.value && heureDebut.value !== "") {

                addErrorForm(input, "Veuillez renseigner une heure de fin postérieure ou égale à l'heure de début.");
                addErrorForm(heureDebut, "Veuillez renseigner une heure de début antérieure ou égale à l'heure de fin.");

            } else if (input.id === "finHeure" && valeur < heureDebut.value) {

                addErrorForm(input, "Veuillez renseigner une heure.");

            }
            else {
                removeErrorForm(heureDebut);
                removeErrorForm(heureFin);
            }
            break;
        case "file":
            var extension = getExtension(valeur);
            console.log(extension);
            if ((input.id === "photo" || input.id === "image" || input.id === "pfp") && (extension.toLowerCase() !== 'jpg' && extension.toLowerCase() !== 'png')) {
                addErrorForm(input, "Veuillez sélectionner une image au format jpg ou png.");
            } else if (input.id === "autorisation" && (extension.toLowerCase() !== 'pdf')) {
                addErrorForm(input, "Veuillez sélectionner un fichier au format pdf.");
            }
            else {
                removeErrorForm(input);
            }
        case "password":
            var mdpPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
            console.log(mdpPattern.test(valeur));
            if (input.id === "mdp" || input.id === "nouvMdp" || input.id === "password") {
                console.log(mdpPattern.test(valeur));
                if (!mdpPattern.test(valeur)) {
                    addErrorForm(input, "Veuilez entrer un mot de passe assez fort.");
                }
            } else if (input.id === "confirmpassword" && document.getElementById("password").value !== valeur) {

                addErrorForm(input, "Les mots de passe ne correspondent pas.");

            } else if (input.id === "confNouvMdp" && document.getElementById("nouvMdp").value !== valeur) {
                addErrorForm(input, "Les mots de passe ne correspondent pas.");

            } else {
                removeErrorForm(input);
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


function getExtension(file) {
    var extension = file.split('.');
    return extension[extension.length - 1];
}
