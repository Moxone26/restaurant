<?php

class Model {
    
    // Propriété qui stockera un objet Database
    protected $db;
    
    // Constructeur
    public function __construct()
    {
        // Création d'un objet Database qui nous permettra de faire des requêtes SQL
        // On le stocke dansla propriété db
        $this->db = new Database();
    }
}