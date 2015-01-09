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

	public function __construct(array $kwargs)
	{
		$this->_preset = $kwargs['preset'];
		switch ($this->_preset)
		{
		case Matrix::$SCALE:
			$this->_scale = $kwargs['scale'];
		}
	}
}
?>
