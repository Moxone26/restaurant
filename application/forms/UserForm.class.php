<?php

class UserForm extends Form {
    
    /**
     * La méthode build doit obligatoirement être implémentée car elle est déclarée abstraite dans la classe parente Form
     */ 
    public function build()
    {
        $this->addFormField('lastName'); // 'lastName' correspond à l'attribut "name" dans le formulaire HTML
        $this->addFormField('firstName');
        $this->addFormField('address');
        $this->addFormField('city');
        $this->addFormField('zipCode');
        $this->addFormField('phone');
        $this->addFormField('email');
    }
}