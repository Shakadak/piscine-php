<?php

Class Color
{
	public $red = 255;
	public $green = 255;
	public $blue = 255;
	public static $verbose = False;

	public function toPngColor($image)
	{
		$color = imagecolorallocate($image, $this->red, $this->green, $this->blue);
		if ($color === false)
			$color = imagecolorresolve($image, $this->red, $this->green, $this->blue);
		return ($color);
	}

	public function __construct(array $kwargs)
	{
		if (array_key_exists('rgb', $kwargs))
		{
			$this->blue = intval($kwargs['rgb']) % 256;
			$this->green = (intval($kwargs['rgb']) >> 8) % 256;
			$this->red = (intval($kwargs['rgb']) >> 16) % 256;
		}
		else if (array_key_exists('red', $kwargs)
			&& array_key_exists('green', $kwargs)
			&& array_key_exists('blue', $kwargs))
		{
			$this->red = intval($kwargs['red']);
			$this->green = intval($kwargs['green']);
			$this->blue = intval($kwargs['blue']);
		}
		if (self::$verbose === true)
			print(self::__toString()." constructed.\n");
	}

	public static function doc()
	{
		$dash_separator = '----------------------------------------------------------------------';
		$class_name = 'Color';
		$before = '<- ' . $class_name . ' ' . $dash_separator . PHP_EOL;
		$after = $dash_separator . ' ' . $class_name . ' ->' . PHP_EOL;
		return ($before . file_get_contents("Color.doc.txt") . $after);
	}

	public function __toString()
	{
		$s_red = sprintf("%3d", $this->red);
		$s_green = sprintf("%3d", $this->green);
		$s_blue = sprintf("%3d", $this->blue);
		return ("Color( red: $s_red, green: $s_green, blue: $s_blue )");
	}

	public function __destruct()
	{
		if (self::$verbose === true)
			print(self::__toString()." destructed.\n");
	}

	public function add(Color $rhs)
	{
		return (new Color(array('red' => $rhs->red + $this->red, 'green' => $rhs->green + $this->green, 'blue' => $rhs->blue + $this->blue)));
	}

	public function sub(Color $rhs)
	{
		return (new Color(array('red' => $this->red - $rhs->red, 'green' => $this->green - $rhs->green, 'blue' => $this->blue - $rhs->blue)));
	}

	public function mult($f)
	{
		return (new Color(array('red' => $f * $this->red, 'green' => $f * $this->green, 'blue' => $f * $this->blue)));
	}
}
?>
