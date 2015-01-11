<?php

require_once('Vertex.class.php');

class Triangle
{
	private $_A;
	private $_B;
	private $_C;

	public static $verbose = false;

	public function contain_point(Vertex $v)
	{
		$P = clone $v;
		$P->setZ(0);
		$A = $this->getA();
		$A>setZ(0);
		$B = $this->getB();
		$B->setZ(0);
		$C = $this->getC()
		$C->setZ(0);

		$v0 = new Vector(['origin' => $A, 'dest' => $C]);
		$v1 = new Vector(['origin' => $A, 'dest' => $B]);
		$v2 = new Vector(['origin' => $A, 'dest' => $P]);

		$d00 = $v0->dotProduct($v0);
		$d01 = $v0->dotProduct($v1);
		$d02 = $v0->dotProduct($v2);
		$d11 = $v1->dotProduct($v1);
		$d12 = $v1->dotProduct($v2);

		$inv = 1 / ($d00 * $d11 - $d01 * $d01);
		$u = ($d11 * $d02 - $d01 * $d12) * $inv;
		$v = ($d00 * $d12 - $d01 * $d02) * $inv;
	}

	private function same_side(Vertex $p1, Vertex $p2, Vertex $a, Vertex $b)
	{
		$p1->setZ(0);
		$p2->setZ(0);
		$a->setZ(0);
		$b->setZ(0);
		//print("$p1\n$p2\n$a\n$b\n");
		$ab = new Vector(['origin' => $a, 'dest' => $b]);
		//print_r($ab);
		$ap1 = new Vector(['origin' => $a, 'dest' => $p1]);
		//print_r($ap1);
		$ap2 = new Vector(['origin' => $a, 'dest' => $p2]);
		//print_r($ap2);
		$cp1 = $ab->crossProduct($ap1);
		//print_r($cp1);
		$cp2 = $ab->crossProduct($ap2);
		//print_r($cp2);
		print($cp1->dotProduct($cp2) . "\n");
		if ($cp1->dotProduct($cp2) >= 0)
			return true;
		return false;
	}

	public function point_in_triangle(Vertex $p)
	{
		if (Triangle::same_side($p, $this->getA(), $this->getB(), $this->getC()) && Triangle::same_side($p, $this->getB(), $this->getA(), $this->getC()) && Triangle::same_side($p, $this->getC(), $this->getA(), $this->getB()))
			return true;
		return false;
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
