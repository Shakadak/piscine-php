<?php
require_once('BattleShip.class.php');
require_once('Battleground/Battleground.class.php');
require_once('Battleground/EnumDirection.class.php');

Class Asteroid extends Battleship
{
	protected $_name = "Big Ass Meteor in your Face";
	protected $_pos = [];
	protected $_z = EnumDirection::NORTH;
	protected $_rotate = 42;
	protected $_pp = 42;
	protected $_hp = 42000;
	protected $_shield = 0;
	protected $_speed = 0;
	protected $_handling = 9000;
	protected $_size = ['width' => 10, 'length' => 13];
	protected $_sprite = "brown";
	protected $_weapons = ['heavy gravity'];

	public static function doc()
	{
		return (file_get_contents("Asteroid.doc.txt"));
	}
}
?>
