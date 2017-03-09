<?php

namespace HomeControl\Device\Type;

interface IType {
	public function getName();

	public function getType();

    public function setIdx($idx);
	public function getIdx();

    public function setStatus($status);

    public function getStatus();
}