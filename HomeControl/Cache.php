<?php

namespace HomeControl;

class Cache {
    private static $instance = null;

    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new Cache();
        }
        return self::$instance;
    }

    public function fetch($key) {
        return apc_fetch($key);
    }

    public function store($key, $value) {
        return apc_store($key, $value);
    }
}