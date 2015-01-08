<?php
Final Class Battleground
{
	const WIDTH = 150;
	const HEIGHT = 100;

	public function display(array $ships)
	{
		print("<table style='table-layout:fixed'>");
		for ($i = 0; $i < self::HEIGHT; $i++)
		{
			print("<tr>");
			for ($j = 0; $j < self::WIDTH; $j++)
				self::checkship($ships, $i, $j);
			print("</tr>");
			print(PHP_EOL);
		}
		print("</table>");
	}

	private function checkship(array $ships, $i, $j)
	{
		foreach ($ships as $ship)
		{
			$hull = $ship->getPos();
			$head = True;
			foreach ($hull as $block)
			{
				if (((int)($block / self::WIDTH) == $i) && ((int)($block % self::WIDTH) == $j))
				{
					print("<td style='background-color:".$ship->getSprite());
					if ($head)
						print("'>X</td>");
					else
						print("'>O</td>");
					return ;
				}
				$head = False;
			}
		}
		echo "<td>_</td>";
	}

	public static function doc()
	{
		return (file_get_contents("Battleground.doc.txt"));
	}
}
?>
