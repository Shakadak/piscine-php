<?php
class Matrix
{
	const IDENTITY = 'IDENTITY';
	const SCALE = 'SCALE';
	const RX = 'RX';
	const RY = 'RY';
	const RZ = 'RZ';
	const TRANSLATION = 'TRANSLATION';
	const PROJECTION = 'PROJECTION';

	private $_preset;
	private $_scale;
	private $_angle;
	private $_vtc;
	private $_fov;
	private $_ratio;
	private $_near;
	private $_far;

	private $_matrix = [
		[1, 0, 0, 0],
		[0, 1, 0, 0],
		[0, 0, 1, 0],
		[0, 0, 0, 1]
		];

	public static $verbose = false;

	public function __construct(array $kwargs)
	{
		$this->_preset = $kwargs['preset'];
		switch ($this->_preset)
		{
		case Matrix::SCALE:
			$this->_scale = $kwargs['scale'];
			break;
		case Matrix::RX:
		case Matrix::RY:
		case Matrix::RZ:
			$this->_angle = $kwargs['angle'];
			break;
		case Matrix::TRANSLATION:
			$this->_vtc = $kwargs['vtc'];
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
			print("Matrix $this->_preset instance constructed\n");
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
}
?>
