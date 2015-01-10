<?php

require_once('Vector.class.php');
require_once('Vertex.class.php');

class Matrix
{
	const IDENTITY = 'IDENTITY';
	const SCALE = 'SCALE';
	const RX = 'Ox ROTATION';
	const RY = 'Oy ROTATION';
	const RZ = 'Oz ROTATION';
	const TRANSLATION = 'TRANSLATION';
	const PROJECTION = 'PROJECTION';

	private $_preset;

	private $_matrix = [
		[1, 0, 0, 0],
		[0, 1, 0, 0],
		[0, 0, 1, 0],
		[0, 0, 0, 1]
		];

	public static $verbose = false;

	public function transpose()
	{
		$old_verbose = Matrix::$verbose;
		Matrix::$verbose = false;
		$result = new Matrix(['preset' => Matrix::IDENTITY]);
		Matrix::$verbose = $old_verbose;
		for ($i = 0; $i < 4; $i++)
		{
			for ($j = 0; $j < 4; $j++)
			{
				$result->_matrix[$i][$j] = $this->_matrix[$j][$i];
			}
		}
		return ($result);
	}

	public function transformVertex(Vertex $vtx)
	{
		$x = $vtx->getX() * $this->_matrix[0][0] + $vtx->getY() * $this->_matrix[0][1] + $vtx->getZ() * $this->_matrix[0][2] + $this->_matrix[0][3];
		$y = $vtx->getX() * $this->_matrix[1][0] + $vtx->getY() * $this->_matrix[1][1] + $vtx->getZ() * $this->_matrix[1][2] + $this->_matrix[1][3];
		$z = $vtx->getX() * $this->_matrix[2][0] + $vtx->getY() * $this->_matrix[2][1] + $vtx->getZ() * $this->_matrix[2][2] + $this->_matrix[2][3];
		$w = $vtx->getX() * $this->_matrix[3][0] + $vtx->getY() * $this->_matrix[3][1] + $vtx->getZ() * $this->_matrix[3][2] + $this->_matrix[3][3];
		return (new Vertex(['x' => $x / $w, 'y' => $y / $w, 'z' => $z / $w]));
	}

	public function mult($rhs)
	{
		$old_verbose = Matrix::$verbose;
		Matrix::$verbose = false;
		$result = new Matrix(['preset' => Matrix::IDENTITY]);
		Matrix::$verbose = $old_verbose;
		for ($i = 0; $i < 4; $i++)
		{
			for ($j = 0; $j < 4; $j++)
			{
				$result->_matrix[$i][$j] = $this->_matrix[$i][0] * $rhs->_matrix[0][$j] + $this->_matrix[$i][1] * $rhs->_matrix[1][$j] + $this->_matrix[$i][2] * $rhs->_matrix[2][$j] + $this->_matrix[$i][3] * $rhs->_matrix[3][$j];
			}
		}
		return ($result);
	}

	public function __construct(array $kwargs)
	{
		$this->_preset = $kwargs['preset'];
		switch ($this->_preset)
		{
		case Matrix::SCALE:
			$scale = $kwargs['scale'];
			self::scale($scale);
			break;
		case Matrix::RX:
			$angle = $kwargs['angle'];
			self::rotateX($angle);
			break;
		case Matrix::RY:
			$angle = $kwargs['angle'];
			self::rotateY($angle);
			break;
		case Matrix::RZ:
			$angle = $kwargs['angle'];
			self::rotateZ($angle);
			break;
		case Matrix::TRANSLATION:
			$vtc = $kwargs['vtc'];
			self::translate($vtc);
			break;
		case Matrix::PROJECTION:
			$fov = $kwargs['fov'];
			$ratio = $kwargs['ratio'];
			$near = $kwargs['near'];
			$far = $kwargs['far'];
			self::OpenGLPerspective($fov, $ratio, $near, $far);
			break;
		}
		if (Matrix::$verbose === true)
		{
			print("Matrix $this->_preset" . ($this->_preset == Matrix::IDENTITY ? "" : " preset") . " instance constructed\n");
		}
	}

	public function __destruct()
	{
		if (Matrix::$verbose === true) {print("Matrix instance destructed".PHP_EOL);}
	}

	public static function doc()
	{
		$dash_separator = '----------------------------------------------------------------------';
		$class_name = 'Matrix';
		$before = '<- ' . $class_name . ' ' . $dash_separator . PHP_EOL;
		$after = $dash_separator . ' ' . $class_name . ' ->' . PHP_EOL;
		return ($before . file_get_contents("$class_name.doc.txt") . $after);
	}

	public function __toString()
	{
		$string = "M | vtcX | vtcY | vtcZ | vtxO";
			$string .= PHP_EOL;
		$string .= "-----------------------------";
		$prefix = ['x', 'y', 'z', 'w'];
		for ($i = 0; $i < 4; $i++)
		{
			$string .= PHP_EOL;
			$string .= $prefix[$i];
			for ($j = 0; $j < 4; $j++)
			{
				$string .= sprintf(" | %.2f", $this->_matrix[$i][$j]);
			}
		}
		return ($string);
	}

	private function OpenGLPerspective($fov, $ratio, $near, $far)
	{
		$scale = tan(deg2rad($fov * 0.5)) * $near;
		$right = $ratio * $scale;
		$left = -$right;
		$top = $scale;
		$bottom = -$top;
		self::OpenGLFrustrum($left, $right, $bottom, $top, $near, $far);
	}

	private function OpenGLFrustrum($left, $right, $bottom, $top, $near, $far)
	{
		$this->_matrix[0][0] = (2 * $near) / ($right - $left);
		$this->_matrix[0][1] = 0;
		$this->_matrix[0][2] = ($right + $left) / ($right - $left);
		$this->_matrix[0][3] = 0;

		$this->_matrix[1][0] = 0;
		$this->_matrix[1][1] = (2 * $near) / ($top - $bottom);
		$this->_matrix[1][2] = ($top + $bottom) / ($top - $bottom);
		$this->_matrix[1][3] = 0;

		$this->_matrix[2][0] = 0;
		$this->_matrix[2][1] = 0;
		$this->_matrix[2][2] = -(($far + $near) / ($far - $near));
		$this->_matrix[2][3] = -((2 * $far * $near) / ($far - $near));

		$this->_matrix[3][0] = 0;
		$this->_matrix[3][1] = 0;
		$this->_matrix[3][2] = -1;
		$this->_matrix[3][3] = 0;
	}

	private function scale($k)
	{
		$this->_matrix[0][0] *= $k;
		$this->_matrix[1][1] *= $k;
		$this->_matrix[2][2] *= $k;
	}

	private function translate(Vector $vtc)
	{
		$this->_matrix[0][3] = $vtc->getX();
		$this->_matrix[1][3] = $vtc->getY();
		$this->_matrix[2][3] = $vtc->getZ();
	}

	private function rotateX($angle)
	{
		$this->_matrix[1][1] = cos($angle);
		$this->_matrix[1][2] = -sin($angle);
		$this->_matrix[2][1] = sin($angle);
		$this->_matrix[2][2] = cos($angle);
	}

	private function rotateY($angle)
	{
		$this->_matrix[0][0] = cos($angle);
		$this->_matrix[0][2] = sin($angle);
		$this->_matrix[2][0] = -sin($angle);
		$this->_matrix[2][2] = cos($angle);
	}

	private function rotateZ($angle)
	{
		$this->_matrix[0][0] = cos($angle);
		$this->_matrix[0][1] = -sin($angle);
		$this->_matrix[1][0] = sin($angle);
		$this->_matrix[1][1] = cos($angle);
	}
}
?>
