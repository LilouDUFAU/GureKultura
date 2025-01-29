function toggleCate(cateId, categorieOriginale) {
    var checkbox = document.querySelector("input[cateId='" + cateId + "']");
    var cateCheckbox = document.querySelectorAll("label[cateId='" + categorieOriginale + "']");

    // Parcourir les divs et modifier leur affichage
    cateCheckbox.forEach(function(cateCheckbox) {
        if (checkbox.checked) {
            cateCheckbox.style.display = "block";
            cateCheckbox.classList.remove("hidden");
        } else {
            cateCheckbox.style.display = "none";
            cateCheckbox.classList.add("hidden");
            cateCheckbox.children[0].checked = false;
            toggleDiv(cateCheckbox.children[0].getAttribute('cateId'));
        }
    });
} 

function toggleDiv(cateId) {
    var checkbox = document.querySelector("input[cateId='" + cateId + "']");
    var divs = document.querySelectorAll("div[cateId='" + cateId + "']");

    // Parcourir les divs et modifier leur affichage
    divs.forEach(function(div) {
                if (checkbox.checked) {
            div.style.display = "block";
            div.classList.remove("hidden");
        } else {
            div.style.display = "none";
            div.classList.add("hidden");
        }
    });
} 