<?php

require('../autoloader.php');

$Domoticz = new \HomeControl\Domoticz();
$Domoticz->getDevices(true);