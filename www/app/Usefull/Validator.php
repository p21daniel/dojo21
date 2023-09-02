<?php

namespace App\Usefull;

class Validator
{
    public function isEmpty(Array $fields) {
        $blankFields = [];

        foreach ($fields as $key => $field) {
            if (empty($field)) {
                $blankFields[] = 'O campo ' . $key . ' está em branco';
            }
        }

        return $blankFields;
    }

    public static function isSamePassword($password, $passwordCheck)
    {
        if ($password !== $passwordCheck) {
            return false;
        }

        return true;
    }
}