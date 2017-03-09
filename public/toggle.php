<?php

require('../autoloader.php');

$Device = \HomeControl\Cache::getInstance()->fetch('Overloop-1e-verdieping-niveau');
var_dump($Device->setLevel(50));