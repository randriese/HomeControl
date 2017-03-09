<?php

namespace HomeControl\Device;

class Factory {

    const TYPE_GENERAL = "General";

    const TYPE_SWITCH = "Light/Switch";
    const TYPE_HEATING = "Heating";
    const TYPE_P1_UTILITY = "P1 Smart Meter";

    const SWITCHTYPE_SWITCH_DIMMER = "Dimmer";
    const SWITCHTYPE_SWITCH_MOTION = "Motion Sensor";
    const SWITCHTYPE_SWITCH_ONOFF = "On/Off";

    const SUBTYPE_P1_ENERGY = "Energy";
    const SUBTYPE_P1_GAS = "Gas";

    const SUBTYPE_HEATING_EVOHOME = "Evohome";
    const SUBTYPE_HEATING_ZONE = "Zone";

    public static function getDeviceClass($device) {
        switch($device["Type"]) {
            case self::TYPE_SWITCH:
                switch($device["SwitchType"]) {
                    case self::SWITCHTYPE_SWITCH_DIMMER:
                        return new \HomeControl\Device\Type\LightSwitch\Dimmer($device);
                        break;
                    case self::SWITCHTYPE_SWITCH_MOTION:
                        return new \HomeControl\Device\Type\LightSwitch\MotionSensor($device);
                        break;
                    case self::SWITCHTYPE_SWITCH_ONOFF:
                        return new \HomeControl\Device\Type\LightSwitch\OnOff($device);
                        break;
                    default:
                        return new \HomeControl\Device\Type\Generic($device);
                        break;
                }
                break;
            case self::TYPE_HEATING:
                switch($device["SubType"]) {
                    case self::SUBTYPE_HEATING_EVOHOME:
                        return new \HomeControl\Device\Type\Heating\Evohome($device);
                        break;
                    case self::SUBTYPE_HEATING_ZONE:
                        return new \HomeControl\Device\Type\Heating\Zone($device);
                        break;
                    default:
                        return new \HomeControl\Device\Type\Generic($device);
                        break;
                }
                break;
            case self::TYPE_P1_UTILITY:
                switch($device["SubType"]) {
                    case self::SUBTYPE_P1_ENERGY:
                        return new \HomeControl\Device\Type\P1\Energy($device);
                        break;
                    case self::SUBTYPE_P1_GAS:
                        return new \HomeControl\Device\Type\P1\Gas($device);
                        break;
                    default:
                        return new \HomeControl\Device\Type\Generic($device);
                        break;
                }
                break;
            case self::TYPE_GENERAL:
                return new \HomeControl\Device\Type\General($device);
                break;
            default:
                return new \HomeControl\Device\Type\Generic($device);
                break;
        }
    }
}