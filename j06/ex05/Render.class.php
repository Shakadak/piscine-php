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
}


	public function bibresenham(Vertex $origin, Vertex $left, Vertex $right)
	{

		$test = 0;
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
		$color[0] = $left->getColor();


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
		$color[1] = $right->getColor();


		$i = 0;
		while (true)
		{
			$current_size[$i] = sqrt(pow($ex[$i] - $ox[$i], 2) + pow($ey[$i] - $oy[$i], 2));
			$p_l = new Vertex(['x' => $ox[0], 'y' => $oy[0], 'z' => 1, 'color' => $origin->getColor()->bifusion($color[0], 1 - ($current_size[0] / $size[0]))]);
			$p_r = new Vertex(['x' => $ox[1], 'y' => $oy[1], 'z' => 1, 'color' => $origin->getColor()->bifusion($color[1], 1 - ($current_size[1] / $size[1]))]);
			$this->render_line($p_l, $p_r);

			echo "echo:".$ox[0]." ==". $ex[0]." || ".$oy[0]." == ".$ey[0].") && (".$ox[1]." == ".$ex[1]." || ".$oy[1]." == ".$ey[1]."\n";
			if (($ox[0] == $ex[0] && $oy[0] == $ey[0]) && ($ox[1] == $ex[1] && $oy[1] == $ey[1]))
				break;
			$erry[$i] = $errx[$i];
			if ($erry[$i] > -$dx[$i])
			{
				if ($ox[$i] != $ex[$i])
				{
					$errx[$i] -= $dy[$i];
					$ox[$i] += $sx[$i];
				}
			}
			if ($erry[$i] < $dy[$i])
			{
				if ($oy[$i] != $ey[$i])
				{
					$errx[$i] += $dx[$i];
					$oy[$i] += $sy[$i];
					$i = ($i + 1) % 2;
				}
			}
		}
	}




	private function render_line(Vertex $origin, Vertex $end)
	{
		print("Rendering line\n");
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
			$this->bibresenham($triangle->getA(), $triangle->getB(), $triangle->getC());
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
