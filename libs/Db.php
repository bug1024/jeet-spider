<?php

/**
 * Singleton Db
 *
 */
class Db {

    private static $__instance = null;

    private $__db = null;

    public static function getInstance($config) {
        if (self::$__instance === null) {
            self::$__instance = new self($config);
        }

        return self::$__instance;
    }

    public function query($sql) {
        return $this->__db->query($sql);
    }

    private function __construct($config) {
        $this->__db = new mysqli($config['host'], $config['user'], $config['password'], $config['database']);
    }

    private function __clone() {}

}
