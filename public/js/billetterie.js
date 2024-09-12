document.addEventListener('DOMContentLoaded', function() {
    const ticketPrices = {
        solo: 15,
        duo: 28,
        famille: 42
    };

    let productQuantities = {
        solo: 0,
        duo: 0,
        famille: 0
    };

    function updateDisplay(product) {
        const quantity = productQuantities[product];
        const price = quantity * ticketPrices[product];
        document.getElementById('quantity-' + product).textContent = quantity;
        document.getElementById('price-' + product).textContent = price.toFixed(2) + ' €';
    }

    function calculateTotal() {
        let totalPrice = 0;
        for (const product in productQuantities) {
            totalPrice += productQuantities[product] * ticketPrices[product];
        }
        document.getElementById('total-price').textContent = 'Total: ' + totalPrice.toFixed(2) + ' €';
    }

    window.updateQuantity = function(product, operation) {
        if (operation === 'plus') {
            productQuantities[product]++;
        } else if (operation === 'minus' && productQuantities[product] > 0) {
            productQuantities[product]--;
        }
        updateDisplay(product);
        calculateTotal();
    }

    async function isAuthenticated() {
        try {
            const response = await fetch('../src/php/check_auth.php');
            const data = await response.json();
            return data.authenticated;
        } catch (error) {
            console.error('Erreur lors de la vérification de l\'authentification:', error);
            return false;
        }
    }

    window.validateSelection = async function() {
        const authenticated = await isAuthenticated();
        
        if (authenticated) {
            // Remplir les valeurs du formulaire caché
            document.getElementById('solo_quantity').value = productQuantities.solo;
            document.getElementById('duo_quantity').value = productQuantities.duo;
            document.getElementById('famille_quantity').value = productQuantities.famille;
            document.getElementById('total_amount').value = (productQuantities.solo * ticketPrices['solo'] +
                                                            productQuantities.duo * ticketPrices['duo'] +
                                                            productQuantities.famille * ticketPrices['famille'])
                                                            .toFixed(2);
            // Soumettre le formulaire
            document.getElementById('cart-form').submit();
        } else {
            // Rediriger vers la page d'authentification
            window.location.href = '/paris-olympics-tickets/public/authentification.html';
        }
    }

    // Initialiser l'affichage
    for (const product in productQuantities) {
        updateDisplay(product);
    }
    calculateTotal();
});
