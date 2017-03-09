<?php
class Autoloader {
    static public function loader($className) {
	$path = '/var/sites/homecontrol.nl/';
        $filename = str_replace('\\', '/', $className) . ".php";
        if (file_exists($path.$filename)) {
            include($path.$filename);
            if (class_exists($className)) {
                return TRUE;
            }
        }
        return FALSE;
    }
}
spl_autoload_register('Autoloader::loader');

