<?php

require_once('Vertex.class.php');
require_once('Triangle.class.php');
require_once('Color.class.php');
require_once('Vector.class.php');

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

	private function render_filled_triangle(Triangle $triangle)
	{
		print("Filling Triangle\n");
		$v1 = $triangle->get_vertices()[0];
		$v2 = $triangle->get_vertices()[1];
		$v3 = $triangle->get_vertices()[2];

		$minX = min($v1->getX(), min($v2->getX(), $v3->getX()));
		$minY = min($v1->getY(), min($v2->getY(), $v3->getY()));
		$maxX = max($v1->getX(), max($v2->getX(), $v3->getX()));
		$maxY = max($v1->getY(), max($v2->getY(), $v3->getY()));

		for ($x = $minX; $x <= $maxX; $x++)
		{
			for ($y = $minY; $y <= $maxY; $y++)
			{
				if ($triangle->contain_point(new Vertex(['x' => $x, 'y' => $y, 'z' => 0])))
				{
					$this->renderVertex(new Vertex(['x' => $x, 'y' => $y, 'z' => 0]));
				}
			}
		}
	}

	public function 2dbresenham(Vertex $origin, Vertex $left, $right)
	{
		$ox[0] = round($origin->getX());
		$oy[0] = round($origin->getY());
		$ex[0] = round($left->getX());
		$ey[0] = round($left->getY());
		$size[0] = sqrt(pow($ex[0] - $ox[0], 2) + pow($ey[0] - $oy[0], 2));
		$dx[0] = round($ox[0] - $ex[0] >= 0 ? $ox[0] - $ex[0] : $ex[0] - $ox[0]);
		$dy[0] = round($oy[0] - $ey[0] >= 0 ? $oy[0] - $ey[0] : $ey[0] - $oy[0]);
		$sx[0] = round($ox[0] < $ex[0] ? 1 : -1);
		$sy[0] = round($oy[0] < $ey[0] ? 1 : -1);
		$errx[0] = round($dx[0] > $dy[0] ? $dx[0] : -$dy[0]) / 2;

		$ox[1] = round($origin->getX());
		$oy[1] = round($origin->getY());
		$ex[1] = round($left->getX());
		$ey[1] = round($left->getY());
		$size[1] = sqrt(pow($ex[1] - $ox[1], 2) + pow($ey[1] - $oy[1], 2));
		$dx[1] = round($ox[1] - $ex[1] >= 1 ? $ox[1] - $ex[1] : $ex[1] - $ox[1]);
		$dy[1] = round($oy[1] - $ey[1] >= 1 ? $oy[1] - $ey[1] : $ey[1] - $oy[1]);
		$sx[1] = round($ox[1] < $ex[1] ? 1 : -1);
		$sy[1] = round($oy[1] < $ey[1] ? 1 : -1);
		$errx[1] = round($dx[1] > $dy[1] ? $dx[1] : -$dy[1]) / 2;

		$i = 0;
		while ($ox[0] != $ex[0] + 1 || $oy[0] != $ey[0] + 1 || $ox[1] != $ex[1]|| $oy[1] != $ex[1])
		{
			$current_size[$i] = sqrt(pow($ex - $ox, 2) + pow($ey - $oy, 2));
			$this->renderVertex(new Vertex(['x' => $ox, 'y' => $oy, 'z' => 1, 'color' => $origin->getColor()->bifusion($end->getColor(), 1 - ($current_size / $size))]));
			$erry = $errx;
			if ($erry > -$dx)
			{
				$errx -= $dy;
				$ox += $sx;
			}
			if ($erry < $dy)
			{
				$errx += $dx;
				$oy += $sy;
			}
		}
		$this->renderVertex(new Vertex(['x' => $ox, 'y' => $oy, 'z' => 1, 'color' => $end->getColor()]));
	}

	private function render_line(Vertex $origin, Vertex $end)
	{
		$ox = round($origin->getX());
		$oy = round($origin->getY());
		$ex = round($end->getX());
		$ey = round($end->getY());
		$size = sqrt(pow($ex - $ox, 2) + pow($ey - $oy, 2));
		$dx = round($ox - $ex >= 0 ? $ox - $ex : $ex - $ox);
		$dy = round($oy - $ey >= 0 ? $oy - $ey : $ey - $oy);
		$sx = round($ox < $ex ? 1 : -1);
		$sy = round($oy < $ey ? 1 : -1);
		$errx = round($dx > $dy ? $dx : -$dy) / 2;
		while ($ox != $ex || $oy != $ey)
		{
			$current_size = sqrt(pow($ex - $ox, 2) + pow($ey - $oy, 2));
			$this->renderVertex(new Vertex(['x' => $ox, 'y' => $oy, 'z' => 1, 'color' => $origin->getColor()->bifusion($end->getColor(), 1 - ($current_size / $size))]));
			$erry = $errx;
			if ($erry > -$dx)
			{
				$errx -= $dy;
				$ox += $sx;
			}
			if ($erry < $dy)
			{
				$errx += $dx;
				$oy += $sy;
			}
		}
		$this->renderVertex(new Vertex(['x' => $ox, 'y' => $oy, 'z' => 1, 'color' => $end->getColor()]));
	}

	public function renderMesh($mesh, $mode)
	{
		foreach ($mesh as $triangle)
		{
			print("JUMP\n");
			$this->renderTriangle($triangle, $mode);
		}
	}

	public function renderTriangle(Triangle $triangle, $mode)
	{
		$vertices = $triangle->get_vertices();
		switch ($mode)
		{
		case Render::VERTEX:
			foreach ($vertices as $screen_vertex)
			{
				$this->renderVertex($screen_vertex);
			}
			break;
		case Render::EDGE:
			for ($i = 0; $i < 3; $i++)
			{
				$this->render_line($vertices[$i], $vertices[($i + 1) % 3]);
			}
			break;
		case Render::RASTERIZE:
			$this->render_filled_triangle($triangle);
			break;
		}
	}

	public function renderVertex(Vertex $screenVertex)
	{
		$z = $screenVertex->getZ();
		if (0 <= $z)// && $z <= 1)
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
