<?php 

namespace HomeControl\Device;

class BaseDevice {

	private $idx;
	private $name;
	private $type;
    private $status;
    private $timestamp;

	public function __construct($json) {
		$this->setIdx($json["idx"]);
		$this->setName($json["Name"]);
		$this->setType($json["Type"]);
        $this->setStatus($json['Data']);
        $this->setTimestamp(time());
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

    public function getStatus() {
        return $this->status;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function getTimestamp() {
        return $this->timestamp;
    }

    public function setTimestamp($timestamp) {
        $this->timestamp = $timestamp;
    }
}
