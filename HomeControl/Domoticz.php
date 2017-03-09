<?php

namespace HomeControl;

class Domoticz {

	const URL = "http://127.0.0.1:8080";
	const logLevel = DomoticzLogLevel::TRACE;

	/**
	* Method to switch (light) devices 
	* @param int $idx ID of the device to switch
	* @param string $command the command to send to the device (On/Off/Toggle), 
	* @param string $comment comment to send to the log file
	* @return void
	**/
	public function switchDevice ($idx, $command = "Toggle", $comment = null) {
		
	}

	/**
	* Method to set (light) devices to a specific level (in percents)
	* @param int $idx ID of the device to switch
	* @param int $level The level to set the device to (0 = Off, 100 = fully on)
	* @param string $comment comment to send to the log file
	* @return void
	**/
	public function setDeviceLevel ($idx, $level, $comment = null) {
		
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
	public function setRGBWDevice ($idx, $hue, $brightness, $comment = null) {
		
	}

	/**
	* Method to add a log entry to the Domoticz log files
	* @param string $message the message to add to the log file
	* @param int $level unused for now as Domoticz doesn't support logging messages under specific levels
	* @return void
	**/
	public function log ($message, $level = null) {

	}

	private function sendToDomoticz ($cmds) {
		if (!is_array($cmds)) {
			$cmds = array($cmds);
		}
		foreach($cmds as $cmd) {

		}
	}


}

class DomoticzLogLevel {
	const NONE = 0;
	const WARN = 1;
	const CHANGES = 2;
	const TRACE = 3;
}
