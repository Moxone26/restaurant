<?php

class LoginController {
    
    public function httpGetMethod(Http $http, array $queryFields)
    {
        return [
            '_form' => new LoginForm()  
        ];
    }
    
    public function httpPostMethod(Http $http, array $formFields)
    {
        try {
            // Récupérer les données du formulaire
            $email = $formFields['email'];
            $password = $formFields['password'];
            
            // Récupérer l'utilisateur connecté
            $userModel = new UserModel();
            $user = $userModel->signIn($email, $password);
            
            // var_dump($user);
            
            // Enregistrer l'utilisateur en session
            $userSession = new UserSession();
            $userSession->create(
                                    $user['Id'],        // Ici la clé 'Id' correspond au nom du champ 'Id' dans la table User de la BDD
                                    $user['FirstName'],
                                    $user['LastName'],
                                    $user['Email']
                                );
                                
            // var_dump($_SESSION);
            
            // Ajout d'un message flash
            $flashbag = new FlashBag();
            $flashbag->add('Bienvenue ' . $user['FirstName'] . ' ' . $user['LastName'] . ', vous êtes bien connecté.');
            
            // Redirection vers l'accueil
            $http->redirectTo('/');
        }
        catch(Exception $e){
            
            $loginForm = new LoginForm();
            $loginForm->bind($formFields);
            $loginForm->setErrorMessage('Identifiants incorrects.');
            
            return [
                '_form' => $loginForm  
            ];
        }
    }
}