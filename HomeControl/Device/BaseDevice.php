<?php 

namespace HomeControl\Device;

class BaseDevice {

	private $idx;
	private $name;
	private $type;

	public function __construct($json) {
		$this->setIdx($json["idx"]);
		$this->setName($json["Name"]);
		$this->setType($json["Type"]);
	}

	public function getIdx() {
		return $this->idx;
	}

	public function setIdx($idx) {
		$this->idx = $idx;
	}

	public function getName() {
		return $this->name;
	}

	public function setName($name) {
		$this->name = $name;
	}

        public function getType() {
		return $this->type;
	}

	public function setType($type) {
		$this->type = $type;
	}
}
