<?php
$tab = array();
function available($database, $login)
{
	foreach ($database as $account)
	{
		if ($account['login'] == $login)
			return FALSE;
	}
	return TRUE;
}
if(file_exists("../private/passwd"))
{
	$tab = file_get_contents("../private/passwd");
	$tab = unserialize($tab);
}
else if (!file_exists("../private"))
	mkdir("../private");
if ($_POST['passwd'] != "" && $_POST['login'] != "" && $_POST['submit'] == "OK")
{
	$log = $_POST['login'];
	if (available($tab, $log))
	{
		$i = 0;
		foreach ($tab as $tmp)
			$i++;
		$new = hash("whirlpool", $_POST['passwd']);
		$tab[$i] = array("login" => $log, "passwd" => $new);
		$tab = serialize($tab);
		file_put_contents("../private/passwd", $tab);
		echo "OK\n";
		return ;
	}
}
echo "ERROR\n";
?>
