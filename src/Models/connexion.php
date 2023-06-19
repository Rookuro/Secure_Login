<?php

//class bdd connexion
class bdd {

    public PDO $connexion;

    public function __construct() {
        
        $this->connexion = new PDO('mysql:host=localhost;dbname=securite;charset=utf8mb4', 'root', 'R-vPlsWjq0syR)1]');
    }
}