<?php
Class House
{
	public function introduce()
	{
		print("House ".static::getHouseName()." of ".static::getHouseSeat()." : \"".static::getHouseMotto()."\"\n");
	}
}
?>
