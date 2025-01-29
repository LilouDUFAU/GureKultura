function toggleCate(cateId, categorieOriginale) {
    var checkbox = document.querySelector("input[cateId='" + cateId + "']");
    var cateCheckbox = document.querySelectorAll("label[cateId='" + categorieOriginale + "']");

    // Parcourir les divs et modifier leur affichage
    cateCheckbox.forEach(function(cateCheckbox) {
        if (checkbox.checked) {
            cateCheckbox.style.display = "block";
        } else {
            cateCheckbox.style.display = "none";
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
        } else {
            div.style.display = "none";
        }
    });
} 