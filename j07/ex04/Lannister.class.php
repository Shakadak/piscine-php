<?php
Class Lannister
{
	protected $_family = True;

	public function sleepWith($partner)
	{
		if (!isset($partner->_family))
			print("Let's do this.\n");
		else if ($partner->_family == $this->_family)
			print("With pleasure, but only in a tower in Winterfell, then.\n");
		else
			print("Not even if I'm drunk !\n");
	}
}
?>
