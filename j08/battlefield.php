<html>
<body style='font-family:monospace'>
<div style='width:100%'>
<div style='width:80%;float:left'>
<?php
require_once('Battleground/Battleground.class.php');
require_once('SpaceShips/OrkRavajeur.class.php');
require_once('SpaceShips/OrkExplozeur.class.php');
require_once('SpaceShips/ImpCuirasse.class.php');
require_once('Battleground/EnumDirection.class.php');
require_once('SpaceShips/Asteroid.class.php');
session_start();
$_SESSION['turn']++;
if (!isset($_POST['sent']))
	$_POST['sent'] = "NOK";
if ($_POST['sent'] == "OK")
{
	$ship = $_SESSION['ships'][$_SESSION['turn'] % 2];
	if (isset($_POST['steering']))
	{
		switch ($_POST['steering'])
		{
		case 1:
			$ship->setZ(EnumDirection::LEFT);
			break;
		case 2:
			$ship->setZ(EnumDirection::RIGHT);
			break;
		}
	}
	if (isset($_POST['movement']))
		$ship->setPos($_POST['movement']);
}

$_SESSION['bg']->display($_SESSION['ships']);
?>
</div>
<div style='background-color:<?php
if ($_SESSION['turn'] % 2)
	echo "lightgreen";
else
	echo "red";
?>;width=20%;float:left'>
<form method='post'><table>
<tr><td>Player <?php print($_SESSION['turn'] % 2 + 1)?></td></tr>
<tr><td>Steering</td><td><span title='COUNTER-CLOCKWISE'><input type='radio' name='steering' value=1>LEFT</span></td>
<td><span title='CLOCKWISE'><input type='radio' name='steering' value=2>RIGHT</span></td></tr>
<tr><td>Move</td><td><select name='movement'><?php
$ship = $_SESSION['ships'][$_SESSION['turn'] % 2];
$speed = $ship->getSpeed();
for ($i = 0; $i <= $speed; $i++)
	echo "<option value=$i>$i</option>\n";?>
</select></td><td><input type='submit' name='sent' value='OK'></td></tr></table></form>
</div>
</body></html>
