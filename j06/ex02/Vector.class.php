<?php
Class Vector
{
	private _x = 1.0;
	private _y = 1.0;
	private _z = 1.0;
	private _w = 0.0;
	public static $verbose = False;

	public function __construct(array $kwargs)
	{
		$dest = $kwargs['dest'];
		if (array_key_exists('orig', $kwargs))
			$orig = $kwargs['orig'];
		if (self::$verbose)
			print(self::__toString()." constructed\n");
	}

	public function __get($att)
	{
		print("Attempt to access '".$att."' attribute, this script should die\n");
		return "fuck off";
	}

	public function __set($att, $value)
	{
		print("Attempt to set '".$att."' attribute to '".$value."', this script should die\n");
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
			return ("Vertex( x:$s_x, y:$s_y, z:$s_z, w:$s_w, $this->_color )");
		return ("Vertex( x:$s_x, y:$s_y, z:$s_z, w:$s_w )");
	}
}
?>
