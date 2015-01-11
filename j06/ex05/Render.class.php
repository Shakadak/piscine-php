<?php

require_once('Vertex.class.php');
require_once('Triangle.class.php');
require_once('Color.class.php');

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

	public function renderMesh($mesh, $mode)
	{
		foreach ($mesh as $triangle)
		{
			$this->renderTriangle($triangle, $mode);
		}
	}

	public function renderTriangle(Triangle $triangle, $mode)
	{
		switch ($mode)
		{
		case Render::VERTEX:
			$vertices = $triangle->get_vertices();
			print("Rendering: ");
			print_r($vertices);
			foreach ($vertices as $screen_vertex)
			{
				$this->renderVertex($screen_vertex);
			}
			break;
		}
	}

	public function renderVertex(Vertex $screenVertex)
	{
		$z = $screenVertex->getZ();
		//if (0 <= $z && $z <= 1)
		{
			$result = imagesetpixel($this->_image, $screenVertex->getX(), $screenVertex->getY(), $screenVertex->getColor()->toPngColor($this->_image));
		}
	}

	public function develop()
	{
		imagepng($this->_image, $this->_filename);
	}

	public function __construct($width, $height, $filename)
	{
		$this->_width = $width;
		$this->_height = $height;
		$this->_filename = $filename;
		$this->_image = imagecreatetruecolor($this->_width, $this->_height);

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
