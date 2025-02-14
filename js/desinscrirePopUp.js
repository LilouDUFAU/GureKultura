// modal.js

// Get modal and button elements
const modal = document.getElementById('inscriptionModal');
const inscrireBtn = document.getElementById('inscrireBtn');
const closeModalBtn = document.getElementById('closeModal');

// Show the modal when "S'inscrire" is clicked
inscrireBtn.addEventListener('click', function(event) {
    event.preventDefault(); // Prevent form submission
    modal.classList.remove('hidden'); // Show modal
});

// Close the modal when "Fermer" or "x" (close button) is clicked
closeModalBtn.addEventListener('click', function() {
    modal.classList.add('hidden'); // Hide modal
});
