function verifErreurSaisie(input) {
    var valeur = input.value.trim();
    var type = input.type;
    var iconErreur = document.createElement("img");

    iconErreur.src = "../asset/icones/eye.svg";
    iconErreur.alt = "Erreur de saisie";
    iconErreur.className = "absolute right-2 top-1/2 transform -translate-y-1/2 w-6 h-6 py-1 rounded-md";
    iconErreur.id = "iconErreur";

    
    var messageErreur = document.createElement("p");

    messageErreur.className = "absolute right-2 top-1/2 transform -translate-y-1/2 w-6 h-6 bg-button py-1 rounded-md";
    messageErreur.id = "messageErreur";
    
    var divParent = input.parentElement.childNodes;
    var exist = false;

    // Vérification des champs en fonction du type
    switch (type) {
        case "text":
            if (valeur === "") {
                console.log("text");
                //<img src="../asset/icones/eye.svg" class="absolute right-2 top-1/2 transform -translate-y-1/2 w-6 h-6 bg-button py-1 rounded-md" alt="Afficher le mot de passe">
                input.classList.remove("border-white");
                input.classList.add("border-[#A23145]");

                divParent.forEach(enfantDiv => {
                    if(enfantDiv.id == "iconErreur"){
                        exist = true;
                    }
                });
                if(!exist){
                    input.messageErreur.value = "messageErreur";
                    input.parentElement.appendChild(iconErreur);
                    input.parentElement.appendChild(messageErreur);
                }

            }else{
                document.getElementById("iconErreur").remove();
                input.classList.add("border-white");
                input.classList.remove("border-[#A23145]");
            }

        case "email":
            console.log("email");
            var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(valeur)) {
                //<img src="../asset/icones/eye.svg" class="absolute right-2 top-1/2 transform -translate-y-1/2 w-6 h-6 bg-button py-1 rounded-md" alt="Afficher le mot de passe">
                input.classList.remove("border-white");
                input.classList.add("border-[#A23145]");

                divParent.forEach(enfantDiv => {
                    if(enfantDiv.id == "iconErreur"){little44
                        exist = true;
                    }
                });
                if(!exist){
                    messageErreur.value = "messageErreur";
                    console.log(messageErreur.value);
                    input.parentElement.appendChild(iconErreur);
                    input.parentElement.appendChild(messageErreur);
                }

            }else{
                document.getElementById("iconErreur").remove();
                input.classList.add("border-white");
                input.classList.remove("border-[#A23145]");
            }
            break;

        case "tel": //numeroTel
            console.log("tel");
            var nombre = parseInt(valeur, 10);
            if (isNaN(nombre) || valeur.length != 10 || valeur[0] != 0) {
                input.classList.remove("border-white");
                input.classList.add("border-[#A23145]");

                divParent.forEach(enfantDiv => {
                    if(enfantDiv.id == "iconErreur"){
                        exist = true;
                    }
                });
                if(!exist){
                    input.parentElement.appendChild(iconErreur);
                }

            }else{
                document.getElementById("iconErreur").remove();
                input.classList.add("border-white");
                input.classList.remove("border-[#A23145]");
            }
            break;

        default:
            break;
    }
}