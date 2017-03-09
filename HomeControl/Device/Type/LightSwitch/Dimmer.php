<?php

namespace HomeControl\Device\Type\LightSwitch;

class Dimmer 
    extends \HomeControl\Device\BaseDevice
    implements \HomeControl\Device\Type\IType
{
    public function setLevel($level, $logMsg = null) {
        $Domoticz = \HomeControl\Domoticz::getInstance();
        return $Domoticz->setDeviceLevel($this->getIdx(), $level, $logMsg);
    }

    public function switchOff($logMsg = null) {
        return $this->switchStatus('Off', $logMsg);
    }

    public function switchOn($logMsg = null) {
        return $this->switchStatus('On', $logMsg);
    }

    public function toggle($logMsg = null) {
        return $this->switchStatus('Toggle', $logMsg);
    }

    private function switchStatus($action, $logMsg = null) {
        $Domoticz = \HomeControl\Domoticz::getInstance();
        return $Domoticz->switchDevice($this->getIdx(), $action, $logMsg);
    }
}
