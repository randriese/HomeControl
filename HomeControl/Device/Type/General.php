<?php

namespace HomeControl\Device\Type;

class General 
	extends \HomeControl\Device\BaseDevice
	implements \HomeControl\Device\Type\IType
{
    public function __construct($json) {
		$this->setIdx($json["idx"]);
		$this->setName($json["Name"]);
		$this->setType($json["Type"]);
        $this->setStatus($json['Data']);
        $this->setTimestamp(time());
	}
}