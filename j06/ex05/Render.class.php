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


	public function rasterize(Triangle $triangle)
{
	// 28.4 fixed-point coordinates
	(int)$Y1 = round(16.0 * $triangle->getA()->getY());
	(int)$Y2 = round(16.0 * $triangle->getB()->getY());
	(int)$Y3 = round(16.0 * $triangle->getC()->getY());

	(int)$X1 = round(16.0 * $triangle->getA()->getX());
	(int)$X2 = round(16.0 * $triangle->getB()->getX());
	(int)$X3 = round(16.0 * $triangle->getC()->getX());

	//Deltas
	(int)$DY12 = $Y1 - $Y2;
	(int)$DY23 = $Y2 - $Y3;
	(int)$DY31 = $Y3 - $Y1;

	(int)$DX12 = $X1 - $X2;
	(int)$DX23 = $X2 - $X3;
	(int)$DX31 = $X3 - $X1;

	//Fixed-point deltas
	(int)$FDX12 = $DX12 << 4;
	(int)$FDX23 = $DX23 << 4;
	(int)$FDX31 = $DX31 << 4;

	(int)$FDY12 = $DY12 << 4;
	(int)$FDY23 = $DY23 << 4;
	(int)$FDY31 = $DY31 << 4;

	//Bounding rectangle
	(int)$minx = (min($X1, min($X2, $X3)) + 0xF) >> 4;
	(int)$maxx = (max($X1, max($X2, $X3)) + 0xF) >> 4;
	(int)$miny = (min($Y1, min($Y2, $Y3)) + 0xF) >> 4;
	(int)$maxy = (max($Y1, max($Y2, $Y3)) + 0xF) >> 4;

	//Half-edge constants
	(int)$C1 = $DY12 * $X1 - $DX12 * $Y1;
	(int)$C2 = $DY23 * $X2 - $DX23 * $Y2;
	(int)$C3 = $DY31 * $X3 - $DX31 * $Y3;

	//Correct for fill convention.
	if ($DY12 < 0 || ($DY12 == 0 && $DX12 > 0))
	{$C1++;}
	if ($DY23 < 0 || ($DY23 == 0 && $DX23 > 0))
	{$C2++;}
	if ($DY31 < 0 || ($DY31 == 0 && $DX31 > 0))
	{$C3++;}

				(int)$CY1 = $C1 + $DX12 * ($miny << 4) - $DY12 * ($minx << 4);
	(int)$CY2 = $C2 + $DX23 * ($miny << 4) - $DY23 * ($minx << 4);
	(int)$CY3 = $C3 + $DX31 * ($miny << 4) - $DY31 * ($minx << 4);

	for((int)$y = $miny; $y < $maxy; $y++)
	{
		(int)$CX1 = $CY1;
		(int)$CX2 = $CY2;
		(int)$CX3 = $CY3;

		for((int)$x = $minx; $x < $maxx; $x++)
		{
			if($CX1 > 0 && $CX2 > 0 && $CX3 > 0)
			{
				imagesetpixel($this->_image, $x, $y, $triangle->get_point_color(new Vertex(['x' => $x, 'y' => $y, 'z' => 0]))->toPngColor($this->_image));
			}

			$CX1 -= $FDY12;
			$CX2 -= $FDY23;
			$CX3 -= $FDY31;
		}

		$CY1 += $FDX12;
		$CY2 += $FDX23;
		$CY3 += $FDX31;
	}
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
			$this->rasterize($triangle);
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
