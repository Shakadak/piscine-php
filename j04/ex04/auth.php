<?php
function auth($login, $passwd)
{
	$serialized = file_get_contents("../private/passwd");
	if ($serialized === false) { return false; }

	$unserialized = unserialize($serialized);
	if ($unserialized === false) { return false; }

	foreach ($unserialized as $couple)
	{
		if ($couple["login"] === $login)
		{
			if ($couple["passwd"] === hash("whirlpool", $passwd))
				return true;
			return false;
		}
	}
}
?>
