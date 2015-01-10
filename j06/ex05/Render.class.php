<?php



class Render
{
	const VERTEX = 0;
	const EDGE = 1;
	const RASTERIZE = 2;

	private $_width;
	private $_height;
	private $_filename;

	public static $verbose = false;

	public function __construct(array $kwargs)
	{
		$this->_width = $kwargs['width'];
		$this->_height = $kwargs['height'];
		$this->_filename = $kwargs['filename'];

		if (Triangle::$verbose === true)
		{
			print("Render instance constructed\n");
		}
	}

	public function __destruct()
	{
		if (Triangle::$verbose === true)
		{
			print("Render instance destructed\n");
		}
	}
}
?>
