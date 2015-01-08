<?php
Class NightsWatch
{
	private $_soldiers = [];

	public function recruit($recruited)
	{
		if (method_exists($recruited, "fight"))
			$this->_soldiers[] = $recruited;
	}

	public function fight()
	{
		foreach ($this->_soldiers as $soldier)
			$soldier->fight();
	}
}
?>
