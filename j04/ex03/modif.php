<?php
$tab = file_get_contents("../private/passwd");
$tab = unserialize($tab);
if ($_POST['newpw'] != "" && $_POST['login'] && $_POST['oldpw'] && isset($_POST['submit']) && $_POST['submit'] == 'OK')
{
	$new = hash("whirlpool", $_POST['newpw']);
	foreach ($tab as $value)
	{
		if ($value['login'] == $_POST['login'])
		{
			if($value['passwd'] == hash("whirlpool", $_POST['oldpw']))
				$value['passwd'] = $new;
			else
				echo "ERROR\n";
		}
	}
	$tab = serialize($tab);
	file_put_contents("../private/passwd", $tab);
	echo "OK\n";
	return ;
}
else
	echo "ERROR\n";
?>
