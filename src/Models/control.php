<?php
require_once("./src/Models/connexion.php");

//Is the class is interact with the bdd
class control extends bdd {

    //Uniq request function
    public function request1(string $rqsql): object
    {
        $statement = $this->connexion->prepare($rqsql);
        $statement->execute();
        return $statement;
    }

    //Double request function
    public function request2(string $rqsql, array $exec): object
    {
        $statement = $this->connexion->prepare($rqsql);
        $statement->execute($exec);
        return $statement;
    }
}
