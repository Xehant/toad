// JavaScript pour afficher la fenêtre contextuelle
const loginPopup = document.getElementById('login-popup');
const closePopup = document.getElementById('close-popup');

// Vérifiez si l'utilisateur est connecté. Utilisez votre propre logique ici.
const userIsLoggedIn = false; // Mettez la logique de connexion réelle ici

// Si l'utilisateur n'est pas connecté, affichez la fenêtre contextuelle
if (!userIsLoggedIn) {
    loginPopup.style.display = 'block';
}

// Fermez la fenêtre contextuelle lorsqu'on clique sur "Fermer"
closePopup.addEventListener('click', () => {
    loginPopup.style.display = 'none';
});
//Mode nuit
const nightModeToggle = document.getElementById('night-mode-toggle');
const body = document.body;

/*nightModeToggle.addEventListener('click', () => {
    body.classList.toggle('night-mode');
});*/

const nightModeStylesheet = document.getElementById('night-mode-stylesheet');

nightModeToggle.addEventListener('change', () => {
    body.classList.toggle('night-mode');
    nightModeStylesheet.disabled = !nightModeStylesheet.disabled;
});

function showCategory(categoryName) {
    // Masquez toutes les catégories
    const categories = document.querySelectorAll('.category');
    categories.forEach(category => category.style.display = 'none');
    
    // Affichez la catégorie sélectionnée
    const categoryToShow = document.getElementById(categoryName);
    if (categoryToShow) {
        categoryToShow.style.display = 'block';
    }
}