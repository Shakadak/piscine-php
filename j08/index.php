<?php
require_once('Battleground/Battleground.class.php');
require_once('SpaceShips/OrkRavajeur.class.php');
require_once('SpaceShips/OrkExplozeur.class.php');
require_once('SpaceShips/ImpCuirasse.class.php');
require_once('SpaceShips/Asteroid.class.php');
require_once('Battleground/EnumDirection.class.php');

session_start();

$_SESSION['turn'] = -1;
$_SESSION['bg'] = new Battleground();
$_SESSION['ships'][] = new OrkExplozeur(['x' => 10, 'y' => 10]);
$_SESSION['ships'][] = new ImpCuirasse(['x' => 130, 'y' => 90]);
$_SESSION['ships'][] = new Asteroid(['x' => 60, 'y' => 70]);
$_SESSION['ships'][] = new Asteroid(['x' => 20, 'y' => 90]);
$_SESSION['ships'][] = new Asteroid(['x' => 35, 'y' => 27]);
$_SESSION['ships'][] = new Asteroid(['x' => 140, 'y' => 90]);
$_SESSION['ships'][] = new Asteroid(['x' => 88, 'y' => 42]);
$_SESSION['ships'][] = new Asteroid(['x' => 124, 'y' => 12]);
?>
<html><head>
<meta http-equiv="refresh" content="0; url=battlefield.php">
</head></html>
