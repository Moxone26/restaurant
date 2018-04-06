<?php

class HomeController
{
    public function httpGetMethod(Http $http, array $queryFields)
    {
    	/*
    	 * Méthode appelée en cas de requête HTTP GET
    	 *
    	 * L'argument $http est un objet permettant de faire des redirections etc.
    	 * L'argument $queryFields contient l'équivalent de $_GET en PHP natif.
    	 */
    	 
    	 // index.php?message=bonjour
    	 
    	 // au lieu d'écrire var_dump($_GET['message']);
    	 // var_dump($queryFields['message']);
    	 
    	 // var_dump('On est en GET !');
    	 
    	 // 1. Aller chercher les données de la table Meal dans la BDD en utilisant le MealModel
    	 $mealModel = new MealModel();
    	 $meals = $mealModel->listAll();
    
         $flashbag = new FlashBag();
         $messages = $flashbag->fetchMessages();
    	 
    	 // var_dump($meals);
    	 
    	 // (new MealModel())->listAll()
    	 
    	 // 2. Transmettre ces données à la vue
    	 return [
    	    // clé  => valeur 
    	    'meals' => $meals, // Je disposerai d'une variable $meals dans le fichier de vue HomeView.phtml car la clé est 'meals'
    	    'flashMessages' => $messages
    	 ];
    	 
    	 /**
    	  * return ['cle' => 'valeur'];
    	  * 
    	  *         $cle qui contient 'valeur'
    	  * 
    	  *  Bonus : voir la fonction PHP extract()
    	  */
    }

    public function httpPostMethod(Http $http, array $formFields)
    {
    	/*
    	 * Méthode appelée en cas de requête HTTP POST
    	 *
    	 * L'argument $http est un objet permettant de faire des redirections etc.
    	 * L'argument $formFields contient l'équivalent de $_POST en PHP natif.
    	 */
    	 
    	 var_dump('On est en POST !');
    }
}