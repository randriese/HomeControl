<?php

namespace HomeControl;

class Engine {

    public function __construct($commandString) {
        if (strlen($commandString) > 0) {
            foreach($this->parseCommand($commandString) as $device => $status) {
                $cachedDevice = \HomeControl\Cache::getInstance()->fetch($device);
                if (is_object($cachedDevice)) {
                    printf('%s (%d) - %s to %s<br/>', $cachedDevice->getName(), $cachedDevice->getTimestamp(), $cachedDevice->getstatus(), $status);
                    $cachedDevice->setStatus($status);
                    $cachedDevice->setTimestamp(time());
                    \HomeControl\Cache::getInstance()->store($cachedDevice->getName(), $cachedDevice);
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