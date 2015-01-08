<?php
require_once('BattleShip.class.php');
require_once('Battleground/Battleground.class.php');
require_once('Battleground/EnumDirection.class.php');

Class OrkExplozeur extends BattleShip
{
	protected $_name = "Ork'n'Roll";
	protected $_pos = [];
	protected $_z = EnumDirection::SOUTH;
	protected $_pp = 10;
	protected $_hp = 4;
	protected $_shield = 0;
	protected $_speed = 19;
	protected $_handling = 3;
	protected $_size = ['width' => 1, 'length' => 5];
	protected $_rotate = 2;
	protected $_sprite = "lightgreen";
	protected $_weapons = ['laser_battery'];

	public static function doc()
	{
		return (file_get_contents("OrkExplozeur.doc.txt"));
	}
}
