<?php
require_once('SpaceShips/BattleShip.class.php');
require_once('Battleground/Battleground.class.php');
require_once('Battleground/EnumDirection.class.php');

Class OrkRavajeur extends BattleShip
{
	protected $_name = 'Oktobre Roug';
	protected $_pos = [];
	protected $_z = EnumDirection::SOUTH;
	protected $_rotate = 0;
	protected $_pp = 10;
	protected $_hp = 4;
	protected $_shield = 0;
	protected $_speed = 19;
	protected $_handling = 3;
	protected $_size = ['width' => 1, 'length' => 2];
	protected $_sprite = "lightgreen";
	protected $_weapons = ['laser_battery'];

	public static function doc()
	{
		return (file_get_contents("OrkRavajeur.doc.txt"));
	}
}
