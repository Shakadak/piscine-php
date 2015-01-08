<?php
session_start();
if (isset($_GET['login']) && $_GET['submit'] == "OK")
	$_SESSION['login'] = $_GET['login'];
if (isset($_GET['passwd']))
	$_SESSION['passwd'] = $_GET['passwd'];
echo "<html><body>\n<form method=\"get\">\n";
echo "	Identifiant: <input type=\"text\" name=\"login\" value=\"";
if (isset($_SESSION['login']) && $_SESSION['login'] != "")
	echo $_SESSION['login'];
echo "\" />\n	<br />\n";
echo "	Mot de passe: <input type=\"password\" name=\"passwd\" value=\"";
if (isset($_SESSION['passwd']) && $_SESSION['passwd'] != "")
	echo $_SESSION['passwd'];
echo "\" />\n	<input type=\"submit\" name=\"submit\" value=\"OK\" />\n</form>\n</body></html>\n";
?>
