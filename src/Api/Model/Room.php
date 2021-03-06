<?php

namespace Course\Api\Model;

class Room {

    public static $users = [];

    public static function addUser($userId) {
        self::$users[] = $userId;
    }

    public static function areThereAreEnoughUsers() {
        return count(self::$users) >= 2;
    }
}