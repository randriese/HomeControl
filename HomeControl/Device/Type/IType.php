<?php

namespace HomeControl\Device\Type;

interface IType {
	public function getName();

	public function getType();

	public function getIdx();
}