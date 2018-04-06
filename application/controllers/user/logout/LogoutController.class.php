<?php 

class LogoutController {
    
    public function httpGetMethod(Http $http, array $queryFields)
    {
        // Se déconnecter
        $userSession = new UserSession();
        $userSession->logout();
        
        // Rediriger l'interaute vers la page d'accueil
        $http->redirectTo('/');
    }
}