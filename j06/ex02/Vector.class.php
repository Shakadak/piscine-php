<?php

require_once 'Vertex.class.php';

Class Vector
{
	private $_x = 1.0;
	private $_y = 1.0;
	private $_z = 1.0;
	private $_w = 0.0;
	public static $verbose = False;

	public function magnitude()
	{
		return (sqrt(pow($this->_x, 2) + pow($this->_y, 2) + pow($this->_z, 2)));
	}

	public function __construct(array $kwargs)
	{
		if (!array_key_exists('dest', $kwargs))
			exit("Parameter 'dest' missing in constructor\n");
		$dest = $kwargs['dest'];
		if (array_key_exists('orig', $kwargs))
			$orig = $kwargs['orig'];
		else
			$orig = new Vertex(['x' => 0, 'y' => 0, 'z' => 0]);
		if (self::$verbose)
			print(self::__toString()." constructed\n");
	}

	public function __get($att)
	{
		print("Vector: Attempt to access '".$att."' attribute, this script should die\n");
		exit;
		return "fuck off";
	}

	public function __set($att, $value)
	{
		print("Vector: Attempt to set '".$att."' attribute to '".$value."', this script should die\n");
		exit;
	}

	public function __destruct()
	{
		if (self::$verbose)
			print(self::__toString()." destructed\n");
	}

	public function getX()
	{
		return ($this->_x);
	}

	public function getY()
	{
		return ($this->_y);
	}

	public function getZ()
	{
		return ($this->_z);
	}

	public function getW()
	{
		return ($this->_w);
	}

	public function __toString()
	{
		$s_x = sprintf("%.2f", $this->_x);
		$s_y = sprintf("%.2f", $this->_y);
		$s_z = sprintf("%.2f", $this->_z);
		$s_w = sprintf("%.2f", $this->_w);
		if (self::$verbose)
			return ("Vertex( x:$s_x, y:$s_y, z:$s_z, w:$s_w )");
		return ("Vertex( x:$s_x, y:$s_y, z:$s_z, w:$s_w )");
	}

	public static function doc()
	{
		$dash_separator = '----------------------------------------------------------------------';
		$class_name = 'Vector';
		$before = '<- ' . $class_name . ' ' . $dash_separator . PHP_EOL;
		$after = $dash_separator . ' ' . $class_name . ' ->' . PHP_EOL;
		return ($before . file_get_contents("Vector.doc.txt") . $after);
	}
}
?>
