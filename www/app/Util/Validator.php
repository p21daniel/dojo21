<?php

namespace App\Util;

/**
 * Validator Class
 */
class Validator
{
    /**
     * @param array $fields
     * @return array
     */
    public function isEmpty(Array $fields): array
    {
        $blankFields = [];

        foreach ($fields as $key => $field) {
            if (empty($field)) {
                $blankFields[] = 'O campo ' . $key . ' está em branco';
            }
        }

        return $blankFields;
    }

    /**
     * @param $password
     * @param $passwordCheck
     * @return bool
     */
    public static function isSamePassword($password, $passwordCheck): bool
    {
        if ($password !== $passwordCheck) {
            return false;
        }

        return true;
    }
}