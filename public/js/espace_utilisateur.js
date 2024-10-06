// Chargement des informations de l'utilisateur et des achats
document.addEventListener('DOMContentLoaded', function() {
    const isAuthenticated = localStorage.getItem('isAuthenticated') === 'true';
    const userName = localStorage.getItem('userName');
    console.log('isAuthenticated:', isAuthenticated);
    console.log('userName:', userName);
    if (isAuthenticated) {
        document.getElementById('user-name').innerText = userName;
        loadAchats();
    } else {
        window.location.href = 'authentification.html';
    }
});

// Fonction pour charger les achats de l'utilisateur
function loadAchats() {
    // Simuler des achats pour l'exemple
    const achats = [
        { id: 1, type: 'Solo', date: '2024-07-10', pdf: 'billet1.pdf' },
        { id: 2, type: 'Duo', date: '2024-07-11', pdf: 'billet2.pdf' },
        { id: 3, type: 'Famille', date: '2024-07-12', pdf: 'billet3.pdf' }
    ];

    const achatsContainer = document.getElementById('achats-container');
    achats.forEach(achat => {
        const achatElement = document.createElement('div');
        achatElement.className = 'achat';

        achatElement.innerHTML = `
            <p>Type de billet: ${achat.type}</p>
            <p>Date d'achat: ${achat.date}</p>
            <a href="pdf/${achat.pdf}" class="btn btn-primary" download>Télécharger le billet</a>
        `;

        achatsContainer.appendChild(achatElement);
    });
}
