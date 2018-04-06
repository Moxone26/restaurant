<?php 

class UserSession {
    
    // Constructeur
    public function __construct()
    {
        // Initialisation de la session le cas échéant
        if (session_status() == PHP_SESSION_NONE){
            
            session_start();
        }
    }
    
    // Ajouter les informations de l'utilisateur connecté en session
    public function create($userId, $firstName, $lastName, $email)
    {
        // contenant = contenu (valeur)
        $_SESSION['user'] = [
                                'UserId' => $userId,
                                'FirstName' => $firstName,
                                'LastName' => $lastName,
                                'Email' => $email
                            ];
    }
    
    // Est-ce que l'utilisateur est connecté ou non ?
    public function isAuthenticated()
    {
        if (array_key_exists('user', $_SESSION)){
            
            if (!empty($_SESSION['user'])){
                return true;
            }
        } 
        
        return false;
    }
    
    public function getUserId()
    {
        if($this->isAuthenticated() == false)
        {
            return null;
        }
        
        return $_SESSION['user']['UserId'];
    }
    
    public function getFirstName()
    {
        if($this->isAuthenticated() == false)
        {
            return null;
        }
        
        return $_SESSION['user']['FirstName'];
    }
    
    public function getLastName()
    {
        if($this->isAuthenticated() == false)
        {
            return null;
        }
        
        return $_SESSION['user']['LastName'];
    }
    
    public function getEmail()
    {
        if($this->isAuthenticated() == false)
        {
            return null;
        }
        
        return $_SESSION['user']['Email'];
    }
    
    public function logout()
    {
        // On efface les données de l'utilisateur
        $_SESSION['user'] = [];
        
        // On détruit la session
        session_destroy();
    }
}