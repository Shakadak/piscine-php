<?php

require_once 'Color.class.php';

Class Vertex
{
	private $_color;
	private $_x = 0.0;
	private $_y = 0.0;
	private $_z = 0.0;
	private $_w = 1.0;
	public static $verbose = False;

	public function __construct(array $kwargs)
	{
		$this->_x = $kwargs['x'];
		$this->_y = $kwargs['y'];
		$this->_z = $kwargs['z'];
		if (array_key_exists('w', $kwargs))
			$this->_w = $kwargs['w'];
		if (array_key_exists('color', $kwargs))
			$this->_color = $kwargs['color'];
		else
			$this->_color = new Color(array('rgb' => 0xffffff));
		if (self::$verbose)
			print(self::__toString()." constructed\n");
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

	public function getColor()
	{
		return ($this->_color);
	}

	public function setX($new)
	{
		$this->_x = $new;
	}

	public function setY($new)
	{
		$this->_y = $new;
	}

	public function setZ($new)
	{
		$this->_z = $new;
	}

	public function setW($new)
	{
		$this->_w = $new;
	}

	public function setColor($new)
	{
		$this->_color = $new;
	}

	public function __toString()
	{
		$s_x = sprintf("%5.2f", $this->_x);
		$s_y = sprintf("%5.2f", $this->_y);
		$s_z = sprintf("%.2f", $this->_z);
		$s_w = sprintf("%.2f", $this->_w);
		if (self::$verbose)
			return ("Vertex( x:$s_x, y:$s_y, z:$s_z, w:$s_w, $this->_color )");
		return ("Vertex( x:$s_x, y:$s_y, z:$s_z, w:$s_w )");
	}

	public static function doc()
	{
		return (file_get_contents("Vertex.doc.txt"));
	}
}
