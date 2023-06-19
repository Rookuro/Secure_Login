<?php

class PostData  {

    public static function execute(string $value): ?string {
        if (isset($_POST[$value])) {
            return $_POST[$value];
        }
        return null;
    }
}