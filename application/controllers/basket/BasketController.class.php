<?php 

class BasketController {
    
    public function httpPostMethod(Http $http, array $data)
    {
        // On vérifie que l'utilisateur est connecté
        $userSession = new UserSession();
        if ($userSession->isAuthenticated() == false){
            
            // sinon on le redirige vers le formulaire de connexion
            $http->redirectTo('/user/login');
        }
        
        // On vérifie qu'il y a bien des données transmises (ce qui n'est pas le cas lorsque l'internaute arrive sur le formulaire de commande pour la première fois)
        if (array_key_exists('items', $data) == false){
            
            $data['items'] = [];
        }
        
        // Transmettre les données du panier à la vue BasketView.phtml
        return [
            'basketItems' => $data['items'], // Contient le panier (tableau de tableaux associatifs)
            '_raw_template' => true // On ne veut pas générer le code HTML de la page entière, mais uniquement le BasketView.phtml
        ];
    }
}