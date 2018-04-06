<?php 

class UserSessionFilter implements InterceptingFilter {
    
    public function run(Http $http, array $queryFields, array $formFields)
    {
        // Cette méthode sera exécutée avant l'appel du contrôleur, quelque soit la page
        $userSession = new UserSession();
        
        // On peut transmettre au LayoutView.phtml des données
        return [
            'userSession' => $userSession  
        ];
    }
}