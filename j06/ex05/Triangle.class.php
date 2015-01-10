<?php

require_once('Vertex.class.php');

class Triangle
{
	private $_A;
	private $_B;
	private $_C;

	public static $verbose = false;

	public function __construct(array $kwargs)
	{
		$this->_A = $kwargs['A'];
		$this->_B = $kwargs['B'];
		$this->_C = $kwargs['C'];

		if (Triangle::$verbose === true)
		{
			print("Triangle instance constructed\n");
		}
	}

	public function __destruct()
	{
		if (Triangle::$verbose === true)
		{
			print("Triangle instance destructed\n");
		}
	}
}
?>
