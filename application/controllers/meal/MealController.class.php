<?php 

class MealController {
    
    public function httpGetMethod(Http $http, array $queryFields)
    {
        //var_dump($queryFields);
        
        // Récupération de l'id de l'article transmis dans la chaîne de requête ?mealId=...
        $mealId = $queryFields['mealId'];
        
        // Création de l'objet MealModel
        $mealModel = new MealModel();
        
        // Appel de la méthode find pour récupérer les données de l'article en BDD
        $meal = $mealModel->find($mealId);
        
        // Encodage des données au format JSON et envoie vers le flux de sortie (client)
        echo json_encode($meal);
        
        // L'instruction exit stoppe l'exécution du code PHP, cela permet d'éviter que le framework aille chercher un MealView.phtml qui n'existe pas.
        exit;
    }
}