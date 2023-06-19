<?php

class json extends control
{

    public static function keyExecute(string $arg)
    {
        //Take the key of connexion
        $json_url = "../../../../password.json";

        $json = file_get_contents($json_url);
        $data = json_decode($json, TRUE);
        return $data[$arg];
    }

    public static function roleExecute(string $arg)
    {
        // Take the json
        $json_url = "../../config/roles/".$arg.".json";

        //Read the json
        $json = file_get_contents($json_url);

        //Convert the json
        $data = json_decode($json, true);

        //Convert the array
        $jsonString = json_encode($data);

        return $jsonString;
    }

}
