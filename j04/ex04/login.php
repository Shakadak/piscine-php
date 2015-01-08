<?php
if (!session_start())
{
	echo "ERROR\n";
	return;
}
include 'auth.php';
$loggued_on_user = '';
if (auth($_GET['login'], $_GET['passwd']))
{
	$loggued_on_user = $_GET['login'];
	echo "OK\n";
}
else
{
	echo "ERROR\n";
}
$_SESSION['loggued_on_user'] = $loggued_on_user;
?>
