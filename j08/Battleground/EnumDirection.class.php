<?php
abstract class EnumDirection
{
	const NORTH = 1;
	const SOUTH = -1;
	const EAST = -2;
	const WEST = 2;
	const LEFT = -1;
	const RIGHT = 1;

	public static function doc()
	{
		return (file_get_contents("EnumDirection.doc.txt"));
	}
}
?>
