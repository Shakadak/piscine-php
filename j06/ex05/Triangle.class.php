<?php

require_once('Vertex.class.php');

class Triangle
{
	private $_A;
	private $_B;
	private $_C;

	public static $verbose = false;

	public function get_vertices()
	{
		return ([clone $this->_A, clone $this->_B, clone $this->_C]);
	}

	public function __construct(Vertex $A, Vertex $B, Vertex $C)
	{
		$this->_A = clone $A;
		$this->_B = clone $B;
		$this->_C = clone $C;

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
