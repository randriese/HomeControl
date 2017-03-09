<?php

namespace HomeControl\Device\Type\LightSwitch;

class Dimmer 
    extends \HomeControl\Device\BaseDevice
    implements \HomeControl\Device\Type\IType
{

    private $level = null;

    public function __construct($device) {
        parent::__construct($device);
        $this->setLevel($device['Level']);
    }

    public function switchLevel($level, $logMsg = null) {
        $Domoticz = \HomeControl\Domoticz::getInstance();
        if($Domoticz->setDeviceLevel($this->getIdx(), $level, $logMsg)) {
            $this->setLevel($level);
            $this->saveToCache();
        }
    }

    public function switchOff($logMsg = null) {
        if($this->switchStatus('Off', $logMsg)) {
            $this->setStatus('Off');
            $this->saveToCache();
        }
    }

    public function switchOn($logMsg = null) {
        if($this->switchStatus('On', $logMsg)) {
            $this->setStatus('On');
            $this->saveToCache();
        }
    }

    public function toggle($logMsg = null) {
        if($this->switchStatus('Toggle', $logMsg)) {
            $this->setStatus(($this->getStatus() == 'On') ? 'Off' : 'On');
            $this->saveToCache();
        }
    }

    private function switchStatus($action, $logMsg = null) {
        $Domoticz = \HomeControl\Domoticz::getInstance();
        return $Domoticz->switchDevice($this->getIdx(), $action, $logMsg);
    }

    public function setLevel($level) {
        $this->level = $level;
    }
}
