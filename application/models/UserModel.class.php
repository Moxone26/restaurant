<?php

class UserModel extends Model {
    
    /**
     * Enregistre les données d'un nouvel utilisateur en base de données
     */ 
    public function signUp($lastName, $firstName, $email, $password, $address, $city, $zipCode, $phone, $birthDate)
    {
        // Vérifier si l'email existe déjà dans la table User
        $res = $this->db->queryOne('SELECT Email FROM User WHERE Email = ?', [$email]);
        
        // Si $res n'est pas vide, l'email est déjà présent dans la table User, on lance une exception
        if (!empty($res)){
        
            // On lance une exception
            throw new Exception('Il existe déjà un compte utilisateur avec cette adresse email');
        }
        
        // Si on se trouve ici, cela signifie qu'aucune exception n'a été lancée au dessus, tout est ok, on insère l'utilisateur dans la BDD
        
        // Requête d'insertion SQL
        $sql = 'INSERT INTO User (LastName, FirstName, Email, Password, Address, City, ZipCode, Phone, BirthDate, CreatedAt) 
                VALUES (?,?,?,?,?,?,?,?,?,NOW())';
        
        // Hashage du mot de passe
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        $values = [$lastName, $firstName, $email, $hashedPassword, $address, $city, $zipCode, $phone, $birthDate];
        
        $this->db->executeSql($sql, $values);
    }
    
    public function signIn($email, $password)
    {
        // Existe-t-il un utilisateur avec cette adresse mail ?
        $user = $this->db->queryOne('SELECT Email, 
                                            Id, 
                                            FirstName, 
                                            LastName, 
                                            Password 
                                     FROM User 
                                     WHERE Email = ?', [$email]);
        
        if (empty($user)) {
            // Non => exception
            throw new Exception("L'adresse email $email n'existe pas dans la base.");
        }
        
        // Si oui, son mot de passe correspond-il ?
        // $password est le mot de passe rentré par l'internaute dans le formulaire de connexion
        // $user['Password'] est le mot de passe stocké dans la BDD
        if ( ! $this->verifyPassword($password, $user['Password']) ){
            
            // Non => exception
            throw new Exception('Le mot de passe est incorrect.');
        }
        
        // Mise à jour de la date de dernière connexion
        $this->updateLastLogin($user['Id']);
        
        return $user; 
    }
    
    public function verifyPassword($passwordToVerify, $passwordInBDD)
    {
        return password_verify($passwordToVerify, $passwordInBDD);
    }
    
    public function updateLastLogin($userId)
    {
        $sql = 'UPDATE User 
                SET LastLoginAt = NOW() 
                WHERE Id = ?';
        
        $this->db->executeSql($sql, [$userId]);
    }
}