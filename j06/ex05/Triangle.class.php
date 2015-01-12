<?php

require_once('Vertex.class.php');

class Triangle
{
	private $_A;
	private $_B;
	private $_C;

	private $_visible = true;

	public static $verbose = false;

	public function check_visibility(Camera $cam)
	{
		$this->_visibile = $cam->isVisible($this);
	}

	public function area()
	{
		$ax = $this->_A->getX();
		$ay = $this->_A->getY();
		$bx = $this->_B->getX();
		$by = $this->_B->getY();
		$cx = $this->_C->getX();
		$cy = $this->_C->getY();
		$area = abs(($ax * ($by - $cy) + $bx * ($cy - $ay) + $cx * ($ay - $by)) / 2);
		return ($area);
	}

	public function get_point_color(Vertex $p)
	{
		$abp = new Triangle($this->_A, $this->_B, $p);
		$acp = new Triangle($this->_A, $this->_C, $p);
		$bcp = new Triangle($this->_B, $this->_C, $p);
		$t_area = $this->area();
		$a_area = $bcp->area();
		$b_area = $acp->area();
		$c_area = $abp->area();
		return (Color::trifusion($this->_A->getColor(), $a_area / $t_area, $this->_B->getColor(), $b_area / $t_area, $this->_C->getColor(), $c_area / $t_area));
	}

	public function is_visible()
	{
		return ($this->_visible);
	}

	public function get_vertices()
	{
		return ([clone $this->_A, clone $this->_B, clone $this->_C]);
	}

	public function getA() {return (clone $this->_A);}
	public function getB() {return (clone $this->_B);}
	public function getC() {return (clone $this->_C);}

	public function __construct(Vertex $A, Vertex $B, Vertex $C)
	{
		$this->_A = clone $A;
		$this->_B = clone $B;
		$this->_C = clone $C;

		if (Triangle::$verbose === true)
		{
			print("Triangle instance constructed\n");
		}
	}

	public function __destruct()
	{
		if (Triangle::$verbose === true)
		{
			print("Triangle instance destructed\n");
		}
	}
}
?>
