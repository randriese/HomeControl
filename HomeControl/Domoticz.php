<?php

namespace HomeControl;

class Domoticz {

    const URL = "http://192.168.1.219:8080";
    const logLevel = DomoticzLogLevel::TRACE;
    private static $instance = null;

    public static function getInstance() {
        if(!isset(self::$instance)) {
            self::$instance = new Domoticz();
        }
        return self::$instance;
    }

    /**
    * Method to switch (light) devices 
    * @param int $idx ID of the device to switch
    * @param string $command the command to send to the device (On/Off/Toggle), 
    * @param string $comment comment to send to the log file
    * @return void
    **/
    public function switchDevice ($idx, $command = "Toggle", $comment = null) {
        try {
            if (!is_null($comment)) {
                $this->log($comment);
            }
            $response = json_decode(file_get_contents(sprintf('%s/json.htm?type=command&param=switchlight&idx=%d&switchcmd=%s', self::URL, $idx, $command)), true);
            if ($response['status'] == 'OK') {
                return true;
            }
            return false; 
        } catch (Exception $ex) {
            
        }
        return false;
    }

    /**
    * Method to set (light) devices to a specific level (in percents)
    * @param int $idx ID of the device to switch
    * @param int $level The level to set the device to (0 = Off, 100 = fully on)
    * @param string $comment comment to send to the log file
    * @return void
    **/
    public function setDeviceLevel ($idx, $level, $comment = null) {
        try {
            if (!is_null($comment)) {
                $this->log($comment);
            }
            $response = json_decode(file_get_contents(sprintf('%s/json.htm?type=command&param=switchlight&idx=%d&switchcmd=%s&level=%d', self::URL, $idx, 'Set%20Level', $level)), true);
            if ($response['status'] == 'OK') {
                return true;
            }
            return false; 
        } catch (Exception $ex) {
            
        }
        return false;
    }

    /**
    * Method to set RGBW lights to a specific level (hue and brightness)
    * @param int $idx ID of the device to switch
    * @param int $hue The level to set the hue to
    * @param int $brightness The level to set the brightness to
    * @param boolean $isWhite 
    * @param string $comment comment to send to the log file
    * @return void
    **/
    public function setRGBWDevice ($idx, $hue, $brightness, $isWhite, $comment = null) {
        try {
            if (!is_null($comment)) {
                $this->log($comment);
            }
            $response = json_decode(file_get_contents(sprintf('%s/json.htm?type=command&param=setcolbrightnessvalue&idx=%d&hue=%d&brightness=%d&iswhite=%s', self::URL, $idx, $hue, $brightness, ($isWhite) ? 'true' : 'false')), true);
            if ($response['status'] == 'OK') {
                return true;
            }
            return false; 
        } catch (Exception $ex) {
            
        }
        return false;
    }

    /**
    * Method to add a log entry to the Domoticz log files
    * @param string $message the message to add to the log file
    * @param int $level unused for now as Domoticz doesn't support logging messages under specific levels
    * @return void
    **/
    public function log ($message, $level = null) {
        try {
            $response = json_decode(file_get_contents(sprintf('%s/json.htm?type=command&param=addlogmessage&message=%s', self::URL, $message)), true);
            if ($response['status'] == 'OK' && isset($response['result'])) {
                return true;
            }
        } catch (Exception $ex) {
        }
        return false;
    }

    public function getDevices($usedOnly = true) {
        try {
            $response = json_decode(file_get_contents(sprintf('%s/json.htm?type=devices%s', self::URL, ($usedOnly) ? '&used=true' : '')), true);
            if ($response['status'] == 'OK' && isset($response['result'])) {
                $this->parseDevices($response['result']);
            }
        } catch (Exception $ex) {
            echo 'cannot fetch devices';
        }
    }

    public function updateDevice($idx) {
        try {
            $response = json_decode(file_get_contents(sprintf('%s/json.htm?type=devices&rid=%d', self::URL, $idx)), true);
            if ($response['status'] == 'OK' && isset($response['result'])) {
                $this->parseDevices($response['result']);
            }
        } catch (Exception $ex) {
            echo 'cannot fetch device';
        }
    }

    public function parseDevices($devices) {
        if (is_array($devices)) {
            foreach($devices as $tmpDevice) {
                $Device = \HomeControl\Device\Factory::getDeviceClass($tmpDevice);
                apc_store($Device->getName(), $Device);
            }
        }
    }
}

class DomoticzLogLevel {
    const NONE = 0;
    const WARN = 1;
    const CHANGES = 2;
    const TRACE = 3;
}
