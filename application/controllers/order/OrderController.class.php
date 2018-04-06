<?php 

class OrderController {
    
    public function httpGetMethod(Http $http, array $queryFields)
    {
        // On vérifie que l'utilisateur est connecté
        $userSession = new UserSession();
        if ($userSession->isAuthenticated() == false){
            
            // sinon on le redirige vers le formulaire de connexion
            $http->redirectTo('/user/login');
        }
        
        // Sélection de tous les produits
        $mealModel = new MealModel();
    	$meals = $mealModel->listAll();
    	
    	return [
    	    'meals' => $meals    
    	];
    }
}