<?php

require_once("Vertex.class.php");
require_once("Matrix.class.php");

class Camera
{
	public static $verbose = false;

	private $_origin;
	private $_orientation;
	private $_width;
	private $_height;
	private $_ratio;
	private $_fov;
	private $_near;
	private $_far;

	public static function doc()
	{
		$dash_separator = '----------------------------------------------------------------------';
		$class_name = 'Camera';
		$before = '<- ' . $class_name . ' ' . $dash_separator . PHP_EOL;
		$after = $dash_separator . ' ' . $class_name . ' ->' . PHP_EOL;
		return ($before . file_get_contents("$class_name.doc.txt") . $after);
	}

	public function __construct(array $kwargs)
	{
		$this->_origin = $kwargs['origin'];
		$this->_orientation = $kwargs['orientation'];
		if (array_key_exists('ratio', $kwargs))
		{
			$this->_ratio = $kwargs['ratio'];
		}
		else
		{
			$this->_ratio = $kwargs['width'] / $kwargs['height'];
		}
		$this->_fov = $kwargs['fov'];
		$this->_near = $kwargs['near'];
		$this->_far = $kwargs['far'];
		if (Camera::$verbose === true) {print("Camera instance constructed".PHP_EOL);}
	}

	public function __destruct()
	{
		if (Camera::$verbose === true) {print("Camera instance destructed".PHP_EOL);}
	}

	public function __toString()
	{
		return ("Camera(\n+ Origine: $this->_origin\n+ tT:\n$this->_orientation\n+ tR:\n+ tR->mult( tT ):\n+ Proj:\n)\n");
	}
}
?>
