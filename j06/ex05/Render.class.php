<?php



class Render
{
	const VERTEX = 0;
	const EDGE = 1;
	const RASTERIZE = 2;

	private $_width;
	private $_height;
	private $_filename;
	private $_image;

	public static $verbose = false;

	public function develop()
	{
		imagepng($this->_image, $this->_filename);
	}

	public function __construct(array $kwargs)
	{
		$this->_width = $kwargs['width'];
		$this->_height = $kwargs['height'];
		$this->_filename = $kwargs['filename'];
		$this->_imge = imagecreatetruecolor($this->_width, $this->_height);

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
