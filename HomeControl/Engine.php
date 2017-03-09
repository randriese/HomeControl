<?php

namespace HomeControl;

class Engine {

    public function __construct($commandString) {
        if (strlen($commandString) > 0) {
            foreach($this->parseCommand($commandString) as $device => $status) {
                $cachedDevice = \HomeControl\Cache::getInstance()->fetch($device);
                if (is_object($cachedDevice)) {
                    //TODO: add logic per device, should be editable
                    //after logic has been processed, update device
                    $cacheUpdate = \HomeControl\Domoticz::getInstance()->updateDevice($cachedDevice->getIdx());
                    if ($cacheUpdate) {
                        \HomeControl\Cache::getInstance()->store($cachedDevice->getName(), $cachedDevice);
                    }
                }
            }
        }
    }

    public function parseCommand($commandString) {
        $deviceAndStatusPairs = array();
        foreach(explode('#', $commandString) as $deviceAndStatusPair) {
            $keyval=explode('|',$deviceAndStatusPair);
            if(count($keyval) > 1) {
                $deviceAndStatusPairs[$keyval[0]] = $keyval[1];
            } else {
                $deviceAndStatusPairs[$keyval[0]] = '';
            }
        }
        return $deviceAndStatusPairs;
    }

}