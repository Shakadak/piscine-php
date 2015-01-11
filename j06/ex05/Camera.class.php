<?php

require_once("Vertex.class.php");
require_once("Matrix.class.php");

class Camera
{
	public static $verbose = false;

	private $_origin;
	private $_tT;
	private $_tR;
	private $_proj;
	private $_width;
	private $_height = 480;

	public function watchMesh(array $mesh)
	{
		foreach ($mesh as $triangle)
		{
			foreach ($triangle->get_vertices() as $vertex)
			{
				$t_vertex[] = $this->watchVertex($vertex);
			}
			$t_mesh[] = new Triangle($t_vertex[0], $t_vertex[1], $t_vertex[2]);
		}
		return ($t_mesh);
	}

	public function watchVertex(Vertex $worldVertex)
	{
		$view_matrix = $this->_tR->mult($this->_tT);
		$cam_vertex = $view_matrix->transformVertex($worldVertex);
		$ndc_vertex = $this->_proj->transformVertex($cam_vertex);
		return (new Vertex(['x' => (1 + $ndc_vertex->getX()) * $this->_width / 2, 'y' => (1 + $ndc_vertex->getY()) * $this->_height / 2, 'z' => $ndc_vertex->getZ(), 'color' => $ndc_vertex->getColor()]));
	}

	public static function doc()
	{
		$dash_separator = '----------------------------------------------------------------------';
		$class_name = 'Camera';
		$before = '<- ' . $class_name . ' ' . $dash_separator . PHP_EOL;
		$after = $dash_separator . ' ' . $class_name . ' ->' . PHP_EOL;
		return ($before . file_get_contents("$class_name.doc.txt") . $after);
	}

	public function __construct(array $kwargs)
	{
		$this->_origin = $kwargs['origin'];
		$orientation = $kwargs['orientation'];
		$translation = new Vector(['dest' => $this->_origin]);
		$this->_tT = new Matrix(['preset' => Matrix::TRANSLATION, 'vtc' => $translation->opposite()]);
		$this->_tR = $orientation->transpose();
		if (array_key_exists('ratio', $kwargs))
		{
			$ratio = $kwargs['ratio'];
			$this->_width = $ratio * $this->_height;
		}
		else
		{
			$this->_width = $kwargs['width'];
			$this->_height = $kwargs['height'];
			$ratio = $kwargs['width'] / $kwargs['height'];
		}
		$fov = $kwargs['fov'];
		$near = $kwargs['near'];
		$far = $kwargs['far'];
		$this->_proj = new Matrix(['preset' => Matrix::PROJECTION, 'fov' => $fov, 'ratio' => $ratio, 'near' => $near, 'far' => $far]);
		if (Camera::$verbose === true) {print("Camera instance constructed".PHP_EOL);}
	}

	public function __destruct()
	{
		if (Camera::$verbose === true) {print("Camera instance destructed".PHP_EOL);}
	}

	public function __toString()
	{
		return ("Camera( \n+ Origine: $this->_origin\n+ tT:\n$this->_tT\n+ tR:\n$this->_tR\n+ tR->mult( tT ):\n".$this->_tR->mult($this->_tT)."\n+ Proj:\n$this->_proj\n)");
	}
}
?>
