<?php

require_once 'Vertex.class.php';

Class Vector
{
	private $_x = 1.0;
	private $_y = 1.0;
	private $_z = 1.0;
	private $_w = 0.0;
	public static $verbose = False;

	public function cos(Vector $rhs)
	{
		$old_verbose = Vector::$verbose;
		Vector::$verbose = false;
		$cos_angle = $this->normalize()->dotProduct($rhs->normalize());
		Vector::$verbose = $old_verbose;
		return ($cos_angle);
	}

	public function crossProduct(Vector $rhs)
	{
		$x = $this->_y * $rhs->getZ() - $this->_z * $rhs->getY();
		$y = $this->_x * $rhs->getZ() - $this->_z * $rhs->getX();
		$z = $this->_x * $rhs->getY() - $this->_y * $rhs->getX();
		return (new Vector(['dest' => new Vertex(['x' => $x, 'y' => -$y, 'z' => $z])]));
	}

	public function dotProduct(Vector $rhs)
	{
		return ($this->_x * $rhs->getX() + $this->_y * $rhs->getY() + $this->_z * $rhs->getZ());
	}

	public function scalarProduct($k)
	{
		return (new Vector(['dest' => new Vertex(['x' => $this->_x * $k, 'y' => $this->_y * $k, 'z' => $this->_z * $k])]));
	}

	public function add(Vector $rhs)
	{
		return (new Vector(['dest' => new Vertex(['x' => $this->_x + $rhs->getX(), 'y' => $this->_y + $rhs->getY(), 'z' => $this->_z + $rhs->getZ()])]));
	}

	public function sub(Vector $rhs)
	{
		return (new Vector(['dest' => new Vertex(['x' => $this->_x - $rhs->getX(), 'y' => $this->_y - $rhs->getY(), 'z' => $this->_z - $rhs->getZ()])]));
	}

	public function opposite()
	{
		return (new Vector(['dest' => new Vertex(['x' => $this->_x * -1, 'y' => $this->_y * -1, 'z' => $this->_z * -1])]));
	}

	public function normalize()
	{
		$norme = $this->magnitude();
		return (new Vector(['dest' => new Vertex(['x' => $this->_x / $norme, 'y' => $this->_y / $norme, 'z' => $this->_z / $norme])]));
	}

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
		$this->_x = $dest->getX() - $orig->getX();
		$this->_y = $dest->getY() - $orig->getY();
		$this->_z = $dest->getZ() - $orig->getZ();
		$this->_w = $dest->getW() - $orig->getW();
		if (self::$verbose === true)
			print(self::__toString()." constructed\n");
	}

	public function __get($att)
	{
		print("Vector: Attempt to access '$att' attribute, this script should die\n");
		exit;
		return "fuck off";
	}

	public function __set($att, $value)
	{
		print("Vector: Attempt to set '$att' attribute to '$value', this script should die\n");
		exit;
	}

	public function __destruct()
	{
		if (self::$verbose === true)
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
		return ("Vector( x:$s_x, y:$s_y, z:$s_z, w:$s_w )");
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
