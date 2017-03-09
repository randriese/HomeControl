<?php

require('../autoloader.php');

$start = microtime(true);

$Domoticz = new \HomeControl\Domoticz();
$Domoticz->getDevices(false);

$end = microtime(true);

echo $end - $start . PHP_EOL;