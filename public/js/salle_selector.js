document.addEventListener('DOMContentLoaded', function () {
    const centreSelector = document.getElementById('centre-selector');
    const salleSelector = document.getElementById('salle-selector');
    const originalOptions = Array.from(salleSelector.options);

    centreSelector.addEventListener('change', function () {
        const selectedCentreId = this.value;

        // Clear current salle options (except the first "–––" one)
        salleSelector.innerHTML = '';
        salleSelector.appendChild(originalOptions[0]); // Add the default option

        if (selectedCentreId !== '') {
            // Re-add options matching selected centre
            originalOptions.forEach(option => {
                if (option.dataset.centre === selectedCentreId) {
                    salleSelector.appendChild(option);
                }
            });
            salleSelector.disabled = false;
        } else {
            salleSelector.disabled = true;
        }
    });
});