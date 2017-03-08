<?php 

namespace HomeControl\Device;

class BaseDevice {

	private $idx;
	private $name;

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
}
