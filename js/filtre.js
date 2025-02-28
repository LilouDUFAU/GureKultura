
function openPopupFiltre(val) {
    if (val == "Filtre") {
        document.getElementById("popupFiltres").parentElement.parentElement.classList.remove("hidden");
        updateSelectedItems()
    }


}

function closePopupFiltre(val) {
    if (val == "Filtre") {
        document.getElementById("popupFiltres").parentElement.parentElement.classList.add("hidden");
    }
}

let selectedOptions = new Array();

function toggleDropdown() {
    document.getElementById('dropdownMenu').classList.toggle('hidden');
}
document.querySelectorAll('.option-item').forEach(item => {
    item.addEventListener('click', function () {
        var valOption = this.value;
        if (!selectedOptions.includes(valOption)) {
            selectedOptions.push(valOption);
            this.classList.add("hidden");
            updateSelectedItems();
        }
    });
});

function updateSelectedItems() {
    var container = document.getElementById('conteneurFiltre');
    container.innerHTML = '';
    selectedOptions.forEach(valOption => {
        var divSelectionFiltre = document.createElement('div');
        divSelectionFiltre.className = 'flex items-center gap-1 bg-blue-500 text-white px-2 py-1 rounded-full';
        divSelectionFiltre.innerHTML = `<span>${valOption}</span>
				 <button type="button" class="text-white bg-grey-500 font-bold" onclick="removeSelected('${valOption}')">×</button>`;
        container.appendChild(divSelectionFiltre);
    });

    document.getElementById("listeFiltres").value = selectedOptions.toString();
    if (selectedOptions.length === 0) {
        container.innerHTML = 'Sélectionner des filtres à appliquer';
    }
}

function removeSelected(valOption) {
    const valSuppression = selectedOptions.indexOf(valOption);
    if (valSuppression > -1) { // only splice array when item is found
        selectedOptions.splice(valSuppression, 1); // 2nd parameter means remove one item only
    }
    var valDropDown = document.getElementById(valOption);
    valDropDown.classList.remove("hidden");
    updateSelectedItems();
}

document.addEventListener('click', function (event) {
    var dropdown = document.getElementById('dropdownToggle');
    var menu = document.getElementById('dropdownMenu');

    if (!dropdown.contains(event.target) && !menu.contains(event.target)) {
        menu.classList.add('hidden');
    }
});