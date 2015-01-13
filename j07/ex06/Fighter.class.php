<?php
abstract class Fighter
{
	protected $_type;

	public function __construct($type)
	{
		$this->_type = $type;
	}

	public function get_type()
	{
		return ($this->_type);
	}

	abstract public function fight($target);
}
?>
