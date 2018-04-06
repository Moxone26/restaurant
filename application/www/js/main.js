'use strict';

/////////////////////////////////////////////////////////////////////////////////////////
// FONCTIONS                                                                           //
/////////////////////////////////////////////////////////////////////////////////////////

function initOrderForm()
{
    var orderForm;
    
    // Création d'un objet de la classe OrderForm
    orderForm = new OrderForm();
    
    // Initialisation de l'objet
    orderForm.init();
}


/////////////////////////////////////////////////////////////////////////////////////////
// CODE PRINCIPAL                                                                      //
/////////////////////////////////////////////////////////////////////////////////////////
jQuery(function($){
    
    // Si le type de la variable OrderForm est défini (donc différent de 'undefined') alors on est sur la page de commande
    if (typeof OrderForm != 'undefined'){
        initOrderForm();
    }
});
