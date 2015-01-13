<?php
Class UnholyFactory
{
	private $_clones = [];

	public function absorb($fighter)
	{
		if (is_subclass_of($fighter, 'Fighter'))
		{
			$type = $fighter->get_type();
			if (array_key_exists($type, $this->_clones))
			{
				print("(Factory already absorbed a fighter of type $type)" . PHP_EOL);
			}
			else
			{
				$this->_clones[$type] = clone $fighter;
				print("(Factory absorbed a fighter of type $type)" . PHP_EOL);
			}
		}
		else
		{
			print("(Factory can't absorb this, it's not a fighter)".PHP_EOL);
		}
	}

	public function fabricate($type)
	{
		if (array_key_exists($type, $this->_clones))
		{
			print("(Factory fabricates a fighter of type $type)". PHP_EOL);
			return (clone $this->_clones[$type]);
		}
		else
		{
			print("(Factory hasn't absorbed any fighter of type $type)".PHP_EOL);
		}
	}

	public function __construct()
	{
	}
	public function __destruct()
	{
	}
}
?>
