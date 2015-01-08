<?php
Final Class Dice
{
	public function roll($nb)
	{
		for ($i = 0; $i < $nb; $i++)
			$result[] = rand(0, 6);
		return ($result);
	}

	public static function doc()
	{
		return (file_get_contents("Dice.doc.txt"));
	}
}
?>
