'use strict'; // Mode strict de javascript

// Constructeur
var OrderForm = function()
{
    // Sélection de l'élément du DOM correspondant à la liste des produits
    this.$meal = $('#meal'); // Liste déroulante des produits
    this.$mealDetails   = $('#meal-details'); // Bloc de détail d'un produit sous la liste déroulante
    this.$form = $('#order-form'); // Formulaire
    
    // Création d'une propriété basketSession qui stocke un objet de la classe BasketSession
    this.basketSession = new BasketSession(); // C'est de la composition ! 
}

// Autres méthodes
OrderForm.prototype.init = function()
{
    // Initialisation de la classe, essentiellement installation des gestionnaires d'événements 
   
    // Installation du gestionnaire d'événement sur l'événement change de la liste déroulante des plats
    this.$meal.on('change', this.onChangeMeal.bind(this)); // la méthode bind de la classe Function permet de modifier la valeur de this dans une fonction

    // Déclenchement artificiel de l'événement 'change' sur la liste déroulante
    this.$meal.trigger('change');
    
    // Ajout d'un gestionnaire d'événement au clic sur le bouton Ajouter au panier
    $('#addMealButton').on('click', this.onClickAddMeal.bind(this));
    
    // Installation des gestionnaires d'événements au clic sur les boutons "Supprimer" avec délégation (dans le futur)
    $('#order-summary').on('click', '.button-cancel', this.onClickRemoveBasketItem.bind(this));
    
    // Faire apparaître le bloc de détails qui est masqué au chargement de la page
    this.$mealDetails.fadeIn();
    
    // Mise à jour de l'affichage du panier
    this.refreshOrderSummary();
};

OrderForm.prototype.onClickRemoveBasketItem = function(event)
{
    var button;
    var mealId;
    
    // 0. Récupérer le bouton cliqué
    button = event.currentTarget;
    
    // 1. Récupérer l'id de l'article à supprimer
    mealId = button.dataset.id; // en jQuery : $(button).data('id')
    
    // 2. Appeler une méthode remove() de la classe BasketSession pour supprimer l'article
    this.basketSession.remove(mealId);
    
    // 3. Rafraichir l'affichage du panier
    this.refreshOrderSummary();
};

OrderForm.prototype.onClickAddMeal = function()
{
    var mealId;
    var name;
    var quantity;
    var price;
    
    // 1. Récupérer les informations du produit sélectionné (Id, Name, Quantity, Price)
    mealId = this.$meal.val(); // Valeur de la liste déroulante des produits
    name = this.$meal.find('option:selected').text(); // Texte de l'option sélectionnée
    quantity = this.$form.find('select[name=quantity]').val(); // Valeur de la liste déroulante quantity
    price = this.$form.find('input[name=price]').val(); // valeur du champ caché "price"
    
    // 2. Ajouter le produit au panier "virtuel"
    this.basketSession.add(mealId, name, quantity, price);
    
    // console.log(this.basketSession.items);
    
    // 3. Mise à jour de l'affichage du panier grâce à la méthode refreshOrderSummary
    this.refreshOrderSummary();
};

OrderForm.prototype.refreshOrderSummary = function()
{
    var url;
    var data;
    var callback;
    
    // Url vers laquelle on envoie la requête AJAX
    url = getRequestUrl() + '/basket';
    
    // Données transmises
    data = {
        items: this.basketSession.items
    };
    
    // Callback
    callback = this.onAjaxRefreshOrderSummary.bind(this);
    
    // Transmettre ce panier dans une requête AJAX vers la page /basket
    $.post(url, data, callback);
};

OrderForm.prototype.onAjaxRefreshOrderSummary = function(basketView)
{
    // Insertion du contenu du panier (la vue en PHP) dans le document HTML.
    $('#order-summary').html(basketView);
};

// Définition du gestionnaire d'événement sur l'événement change de la liste déroulante des plats
OrderForm.prototype.onChangeMeal = function()
{
    var mealId;
    var url;
    var data;
    var success;
    
    // 1. Récupérer l'id du plat sélectionné stocké dans l'attribut value de l'option sélectionnée ("valeur" du select)
    
    // Par défaut dans le gestionnaire d'événement onChangeMeal, this vaut l'élément déclancheur, càd la balise <select>
    // Autrement dit - par défaut - , this contient le résultat de : document.getElementById('meal')
    //
    // $('#meal').val()
    mealId = this.$meal.val();
    
    // console.log(mealId);
    
    // 2. Requête AJAX vers l'url /meal avec l'identifiant du plat sélectionné
    
    // Url souhaitée : https://veroniquecuomo-s4-veroniquecuomo.c9users.io/Restaurant/index.php/meal
    // La fonction getRequestUrl() est définie dans le fichier utilities.js et est léquivalent de la variable $requestUrl danas les templates du framework
    url = getRequestUrl() + '/meal?mealId=' + mealId;
    
    // data = {mealId: mealId};
    // data = 'mealId=' + mealId;
    
    // Fonction de callback qui sera exécutée lors de la réception par javascript de la réponse du serveur
    success = this.onAjaxChangeMeal.bind(this);
    
    // Appel de la méthode $.getJSON()
    $.getJSON(url, /*data,*/ success);
    
    // $.getJSON(getRequestUrl() + '/meal', {mealId: $('#meal').val()}, success);
    
};

OrderForm.prototype.onAjaxChangeMeal = function(meal)
{
    var imageUrl;
    
    // Insérer dans des balises HTML (qu'il faut rajouter au préalable dans le OrderView.phtml) les données de l'article
    this.$mealDetails.children('p').text(meal.Description);
    this.$mealDetails.find('strong').text(formatMoneyAmount(meal.Price));
    
    // Construction de l'url de l'image
    imageUrl = getWwwUrl() + '/images/meals/' + meal.Photo;
    
    this.$mealDetails.children('img').attr('src', imageUrl);
    
    // Sélection du champ caché "price" : on lui attribue une valeur
    this.$form.find('input[name=price]').val(meal.Price);
};