'use strict';

// Constructeur
var BasketSession = function()
{
    // Création et initilisation d'une propriété items qui permettra de stocker les produits ajoutés au panier
    this.items = [];  
    
    // Chargement des articles du localStorage lors de la création de l'objet (au chargement de la page)
    this.load();
};

// Méthode qui ajoute un produit au panier
BasketSession.prototype.add = function(mealId, name, quantity, price)
{
    var index;
    // var found = false; // Pour la Version 2
    
    // Conversion des paramètres 
    mealId = parseInt(mealId);
    quantity = parseInt(quantity);
    price = parseFloat(price);
    
    // Parcourir le tableau items qui contient les articles déjà présents dans le panier
    
    // VERSION 1 : avec une boucle for
    // for(index = 0 ; index < this.items.length ; index++){
        
    //     // Si l'id de l'article à ajouter est égal à l'id de l'article courant du tableau items 
    //     if (mealId == this.items[index].mealId){
            
    //         // On met à jour la quantité de l'article
    //         this.items[index].quantity += quantity;
            
    //         // Plus besoin de continuer, on sort de la méthode
    //         return;
    //     }
    // }
    
    // VERSION 2 : avec la méthode forEach() de la classe Array [https://developer.mozilla.org/fr/docs/Web/JavaScript/Reference/Objets_globaux/Array/forEach]
    // this.items.forEach(function(meal){
    //     // Cette fonction sera exécutée par javascript pour chaque élément du tableau this.items
        
    //     // Si l'id de l'article à ajouter est égal à l'id de l'article courant du tableau items 
    //     if (mealId == meal.mealId){
            
    //         // console.log('quantity = ' + quantity);
    //         // console.log(typeof quantity);
            
    //         // On met à jour la quantité de l'article
    //         meal.quantity += quantity;
            
    //         found = true;
            
    //         // Plus besoin de continuer, on sort de la méthode
    //         return false;
    //     }
    // });
    
    // // Avec la version 2 (forEach) il faut vérifier si on trouvé l'article => on sort de la méthode add
    // if(found){
    //     return;
    // }
    
    // // VERSION 3 : avec la boucle for ... in (https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Statements/for...in)
    // for (index in this.items) {
    
    //     // Si l'id de l'article à ajouter est égal à l'id de l'article courant du tableau items 
    //     if (mealId == this.items[index].mealId){
            
    //         // On met à jour la quantité de l'article    
    //         this.items[index].quantity += quantity;
            
    //         // Plus besoin de continuer, on sort de la méthode
    //         return;
    //     }
    // }
    
    // VERSION 4 : for...of (https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Statements/for...of) introduite en ECMAScript 2015
    for (let meal of this.items) {
    
        // Si l'id de l'article à ajouter est égal à l'id de l'article courant du tableau items 
        if (mealId == meal.mealId){
            
            // On met à jour la quantité de l'article    
            meal.quantity += quantity;
            
            // Sauvegarde dans le localStorage
            this.save();
            
            // Plus besoin de continuer, on sort de la méthode
            return;
        }
    }
    
    // Si on est arrivé ici, on n'a pas trouvé l'article dans le tableau, on l'ajoute 
    this.items.push({
        mealId: mealId,
        name: name,
        quantity: quantity,
        price: price
    });
    
    // Sauvegarde dans le localStorage
    this.save();
};

BasketSession.prototype.save = function()
{
    // Sauvegarder les données dupanier dans le localStorage
    saveDataToDomStorage('basket', this.items);
};

BasketSession.prototype.load = function()
{
    // Chargement des données du localStorage
    this.items = loadDataFromDomStorage('basket');
    
    if (this.items == null){
        
        this.items = [];
    }
};

BasketSession.prototype.remove = function(mealIdToRemove)
{
    var index;

    // Recherche de l'aliment spécifié.
    for(index = 0; index < this.items.length; index++)
    {
        // Est-ce que on se trouve sur l'élément à supprimer ?
        if ( mealIdToRemove == this.items[index].mealId ){
            
            // Suppression de la case du tableau this.items qui se trouve à l'indice index
            // Doc: https://developer.mozilla.org/fr/docs/Web/JavaScript/Reference/Objets_globaux/Array/splice
            this.items.splice(index, 1);
            
            // Mise à jour du lcoalStorage
            this.save();
            
            return true;
        }
    }
    
    return false;
};