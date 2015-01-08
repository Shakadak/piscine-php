<?php

Class Targaryen
{
	public function resistsFire()
	{
		return (False);
	}

	public function getBurned()
	{
		if (static::resistsFire())
			return ("emerges naked but unharmed");
		return ("burns alive");
	}
}

?>
