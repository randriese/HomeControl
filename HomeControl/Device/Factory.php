<?php

namespace HomeControl\Device
{
class Factory {

	const TYPE_SWITCH = "Light/Switch";
	const TYPE_HEATING = "Heating";
	const TYPE_P1_UTILITY = "P1 Smart Meter";

	const SWITCHTYPE_SWITCH_DIMMER = "Dimmer";
	const SWITCHTYPE_SWITCH_MOTION = "Motion Sensor";
	const SWITCHTYPE_SWITCH_ONOFF = "On/Off";

	const SWITCHTYPE_P1_ENERGY = "Energy";
	const SWITCHTYPE_P1_GAS = "Gas";

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
				break;
			case self::TYPE_P1_UTILITY:
				
				break;
			default:
				return new \HomeControl\Device\Type\Generic($device);
				break;
		}
	}
}
}
