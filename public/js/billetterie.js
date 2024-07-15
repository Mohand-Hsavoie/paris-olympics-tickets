let tickets = {
    solo: 0,
    duo: 0,
    famille: 0
};

function increment(ticketType) {
    tickets[ticketType]++;
    updateCount(ticketType);
    saveSelection();
}

function decrement(ticketType) {
    if (tickets[ticketType] > 0) {
        tickets[ticketType]--;
        updateCount(ticketType);
        saveSelection();
    }
}

function updateCount(ticketType) {
    document.getElementById(`${ticketType}-count`).innerText = tickets[ticketType];
}

function saveSelection() {
    localStorage.setItem('tickets', JSON.stringify(tickets));
}

function loadSelection() {
    const savedTickets = JSON.parse(localStorage.getItem('tickets'));
    if (savedTickets) {
        tickets = savedTickets;
        updateCount('solo');
        updateCount('duo');
        updateCount('famille');
    }
}

function validateSelection() {
    const isAuthenticated = false; // Change this to check real authentication status

    if (isAuthenticated) {
        window.location.href = 'paiement.html';
    } else {
        window.location.href = 'authentification.html';
    }
}

// Load the selection on page load
window.onload = loadSelection;
