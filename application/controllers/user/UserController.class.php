<?php

class UserController {
    
    public function httpGetMethod(Http $http, array $queryFields)
    {
        /*
    	 * Méthode appelée en cas de requête HTTP GET
    	 *
    	 * L'argument $http est un objet permettant de faire des redirections etc.
    	 * L'argument $queryFields contient l'équivalent de $_GET en PHP natif.
    	 */
    	 
    	 /*
    	  * Si on est ici c'est que le formulaire n'a pas encore été validé
    	  *     -> on l'affiche (code HTML du formulaire dans le fichier UserView.phtml) 
    	  */
    	  
    	  // Création d'un tableau pour stocker les mois de l'année
    	  $tabMonths = [
    	    'Janvier',
			'Février',
			'Mars',
			'Avril',
			'Mai',
			'Juin',
			'Juillet',
			'Août',
			'Septembre',
		    'Octobre',
		    'Novembre',
		    'Décembre'
    	  ];
    	  
    	  return [
    	       'months' => $tabMonths, // Je retrouverai dans mon template UserView.phtml une variable $months
    	       '_form' => new UserForm()
    	  ];
    }
    
    public function httpPostMethod(Http $http, array $formFields)
    {
        /*
    	 * Méthode appelée en cas de requête HTTP POST
    	 *
    	 * L'argument $http est un objet permettant de faire des redirections etc.
    	 * L'argument $formFields contient l'équivalent de $_POST en PHP natif.
    	 */
    	 
    	 /*
    	  * Si on est ici c'est que le formulaire a été validé
    	  *     -> Récupérer les données du formulaire (contenues dans le paramètre $formFields)
    	  *     -> Insérer un nouvel utilisateur dans la BDD (dans une table User) en utilisant un modèle UserModel et une méthode signUp()
    	  *     -> Redirection vers la page d'accueil
    	  */
        
        // 1. Récupérer les données du formulaire 
        $lastName = $formFields['lastName']; // $formFields est l'équivalent de $_POST. La clé 'lastName' correspond à l'attribut name dans le formulaire
        $firstName = $formFields['firstName'];
		$email = $formFields['email'];
		$password = $formFields['password'];
		$address = $formFields['address'];
		$city = $formFields['city'];
		$zipCode = $formFields['zipCode'];
		$phone = $formFields['phone'];
		$birthDate = $formFields['birthYear'].'-'.$formFields['birthMonth'].'-'.$formFields['birthDay'];
		
        // 2. Insérer un nouvel utilisateur dans la BDD
        try {
            
            // Enregistrement dans la BDD
            $userModel = new UserModel();
            $userModel->signUp($lastName, $firstName, $email, $password, $address, $city, $zipCode, $phone, $birthDate);
            
            // Ajout d'un message au FlashBag
            $flashbag = new FlashBag();
            $flashbag->add('Votre compte a bien été créé, vous pouvez vous connecter.');
            
            // Redirection vers la page d'accueil
            // https://veroniquecuomo-s4-veroniquecuomo.c9users.io/Restaurant/index.php/user
            
            $http->redirectTo('/'); // La route '/' est la route de la page d'accueil
        }
        catch(Exception $e){
        	
            // var_dump($e->getMessage());
            
            $userForm = new UserForm();
            $userForm->bind($formFields);
            
            // On ajoute un message d'erreur à l'objet userForm (le message récupéré de l'exception)
            $userForm->setErrorMessage($e->getMessage());
            
            // Création d'un tableau pour stocker les mois de l'année
	    	  $tabMonths = [
	    	    'Janvier',
				'Février',
				'Mars',
				'Avril',
				'Mai',
				'Juin',
				'Juillet',
				'Août',
				'Septembre',
			    'Octobre',
			    'Novembre',
			    'Décembre'
	    	  ];
	    	  
	    	  return [
	    	       'months' => $tabMonths, // Je retrouverai dans mon template UserView.phtml une variable $months
	    	       '_form' => $userForm
	    	  ];
        }
    }
}