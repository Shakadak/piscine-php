<?php
if (!file_exists("../private/passwd"))
{
	print("ERROR\n");
	return ;
}
$tab = file_get_contents("../private/passwd");
$tab = unserialize($tab);
if ($_POST['newpw'] != null && $_POST['login'] != null && $_POST['oldpw'] != null && isset($_POST['submit']) && $_POST['submit'] === 'OK')
{
	$new = hash("whirlpool", $_POST['newpw']);
	$i = 0;
	foreach ($tab as $value)
	{
		if ($value['login'] == $_POST['login'])
		{
			if($value['passwd'] === hash("whirlpool", $_POST['oldpw']))
				$tab[$i]['passwd'] = $new;
			else
			{
				echo "ERROR\n";
				return ;
			}
		}
		$i++;
	}
	$tab = serialize($tab);
	file_put_contents("../private/passwd", $tab);
	echo "OK\n";
	return ;
}
echo "ERROR\n";
?>
