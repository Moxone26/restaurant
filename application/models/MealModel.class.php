<?php

class MealModel extends Model {
    
    /**
     * Sélectionne l'ensemble des enregistrements de la table Meal et les retourne
     */ 
    public function listAll()
    {
        return $this->db->query('SELECT * FROM Meal');
    }
    
    public function find($mealId)
    {
        $sql = 'SELECT *
                FROM Meal
                WHERE Id = ?';
                
        return $this->db->queryOne($sql, [$mealId]);
    }
}