<?php

require('../autoloader.php');

$Domoticz = \HomeControl\Domoticz::getInstance();
$Domoticz->getDevices(true);