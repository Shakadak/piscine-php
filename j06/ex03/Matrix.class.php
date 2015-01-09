<?php
class Matrix
{
	static const $IDENTITY = 0;
	static const $SCALE = 1;
	static const $RX = 2;
	static const $RY = 3;
	static const $RZ = 4;
	static const $TRANSLATION = 5;
	static const $PROJECTION = 6;

	private $_preset;
	private $_scale;
	private $_angle;
	private $_vtc;
	private $_fov;
	private $_ratio;
	private $_near;
	private $_far;

	private $matrix = [
		[1, 0, 0, 0]
		[0, 1, 0, 0]
		[0, 0, 1, 0]
		[0, 0, 0, 1]
		];

	public static $verbose = false;

	public function __construct(array $kwargs)
	{
		$this->_preset = $kwargs['preset'];
		switch ($this->_preset)
		{
		case Matrix::$SCALE:
			$this->_scale = $kwargs['scale'];
			break;
		case Matrix::$RX:
		case Matrix::$RY:
		case Matrix::$RZ:
			$this->_angle = $kwargs['angle'];
			break;
		case Matrix::$TRANSLATION:
			$this->_vtc = $kwargs['vtc'];
			break;
		case Matrix::$PROJECTION:
			$this->_fov = $kwargs['fov'];
			$this->_ratio = $kwargs['ratio'];
			$this->_near = $kwargs['near'];
			$this->_far = $kwargs['far'];
			break;
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
}
?>
