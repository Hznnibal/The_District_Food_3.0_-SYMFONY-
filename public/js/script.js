function myMap() {
    var mapProp = {
        center: new google.maps.LatLng(49.900002, 2.3),
        zoom: 18,
    };
    var map = new google.maps.Map(document.getElementById("googleMap"), mapProp);
}
$(document).ready(function () {
    var $grid = $('.grid').isotope({
        itemSelector: '.grid-item',
        layoutMode: 'fitRows'
    });

    $('.filters_menu li').on('click', function () {
        var filterValue = $(this).attr('data-filter');
        $grid.isotope({ filter: filterValue });
        $('.filters_menu li').removeClass('active');
        $(this).addClass('active');
    });
});
$(document).ready(function () {
    var limit = 6; // Nombre initial d'articles à afficher
    var offset = limit; // Décalage pour charger les articles suivants

    // Fonction pour charger plus d'articles
    function loadMore() {
        $.ajax({
            url: "load_more.php", // Remplacez "load_more.php" par le fichier qui récupère plus d'articles depuis la base de données
            method: "POST",
            data: { limit: limit, offset: offset },
            dataType: "html",
            success: function (data) {
                if (data != "") {
                    $("#load-more-container").before(data);
                    offset += limit;
                } else {
                    $("#load-more").attr("disabled", true).text("Aucun article supplémentaire");
                }
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }

    // Écouteur d'événement pour le clic sur le bouton "Voir plus"
    $("#load-more").on("click", function () {
        loadMore();
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const cartItems = document.getElementById('cart-items');
    const totalPrice = document.getElementById('total-price');

    // Ajoutez un événement de clic à chaque élément du menu
    const menuItems = document.querySelectorAll('.item');
    menuItems.forEach(item => {
        item.addEventListener('click', addToCart);
    });

    // Fonction pour ajouter un élément au panier
    function addToCart(event) {
        const itemId = event.target.getAttribute('data-id');
        const itemName = event.target.querySelector('h2').textContent;
        const itemPrice = parseFloat(event.target.getAttribute('data-price'));

        const cartItem = document.createElement('li');
        cartItem.textContent = itemName;
        cartItems.appendChild(cartItem);

        // Mettez à jour le total
        const currentTotal = parseFloat(totalPrice.textContent);
        totalPrice.textContent = (currentTotal + itemPrice).toFixed(2);
    }

    // Ajoutez un événement de clic au bouton de commande
    const checkoutBtn = document.getElementById('checkout-btn');
    checkoutBtn.addEventListener('click', checkout);

    // Fonction pour passer la commande
    function checkout() {
        alert('Commande passée avec succès! Total: ' + totalPrice.textContent + ' €');
        // Vous pouvez ajouter ici la logique pour enregistrer la commande dans la base de données, etc.
    }
});

  