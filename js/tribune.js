// Fonction qui met à jour les options des menus selon le choix de la tribune
document.getElementById('tribune').addEventListener('change', function() {
    var tribune = this.value;
    
    var blocSelect = document.getElementById('bloc');
    var rangSelect = document.getElementById('rang');

    if (tribune === 'keolis') {
        blocSelect.innerHTML = `
            <option value="blocA">Bloc A</option>
            <option value="blocB">Bloc B</option>
            <option value="blocC">Bloc C</option>
        `;
        rangSelect.innerHTML = `
            <option value="rangA">Rang A</option>
            <option value="rangB">Rang B</option>
            <option value="rangC">Rang C</option>
        `;
    } else if (tribune === 'nord') {
        blocSelect.innerHTML = `
            <option value="blocA">Bloc A</option>
            <option value="blocB">Bloc B</option>
        `;
        rangSelect.innerHTML = `
            <option value="rangA">Rang A</option>
            <option value="rangB">Rang B</option>
        `;
    } else if (tribune === 'honneur') {
        blocSelect.innerHTML = `
            <option value="blocA">Bloc A</option>
            <option value="blocB">Bloc B</option>
            <option value="blocC">Bloc C</option>
        `;
        rangSelect.innerHTML = `
            <option value="rangA">Rang A</option>
            <option value="rangB">Rang B</option>
            <option value="rangC">Rang C</option>
            <option value="rangD">Rang D</option>
        `;
    } else if (tribune === 'europcar') {
        blocSelect.innerHTML = `
            <option value="blocA">Bloc A</option>
        `;
        rangSelect.innerHTML = `
            <option value="rangA">Rang A</option>
        `;
    }
});

// Simuler un changement au chargement pour mettre à jour les options
document.getElementById('tribune').dispatchEvent(new Event('change'));
