<?php
require_once('ISpaceShip.class.php');
require_once('Battleground/Battleground.class.php');
require_once('Battleground/EnumDirection.class.php');

Class BattleShip implements ISpaceShip
{
	final public function __construct(array $pos)
	{
		for ($i = 0; $i < $this->_size['width']; $i++)
		{
			for ($j = 0; $j < $this->_size['length']; $j++)
				$this->_pos[] = (($pos['y'] + $j * $this->_z) * Battleground::WIDTH) + ($pos['x'] + $i);
		}
	}

	public static function doc()
	{
		return (file_get_contents("BattleShip.doc.txt"));
	}

	final public function getName()
	{
		return ($this->_name);
	}

	final public function getPos()
	{
		return ($this->_pos);
	}

	final public function getSprite()
	{
		return ($this->_sprite);
	}

	final public function setPos($dist)
	{
		switch($this->_z)
		{
		case EnumDirection::NORTH:
			self::moveNorth($dist);
			break;
		case EnumDirection::SOUTH:
			self::moveSouth($dist);
			break;
		case EnumDirection::EAST:
			self::moveEast($dist);
			break;
		case EnumDirection::WEST:
			self::moveWest($dist);
			break;
		}
	}

	final public function getZ()
	{
		return ($this->_z);
	}

	final public function setZ($dir)
	{
		switch($this->_z)
		{
		case EnumDirection::NORTH:
			self::setNorth($dir);
			break;
		case EnumDirection::SOUTH:
			self::setSouth($dir);
			break;
		case EnumDirection::EAST:
			self::setEast($dir);
			break;
		case EnumDirection::WEST:
			self::setWest($dir);
			break;
		}
	}

	final private function moveNorth($dist)
	{
		$hull = $this->_pos;
		$this->_pos = [];
		foreach ($hull as $part)
			$this->_pos[] = $part - $dist * Battleground::WIDTH;
	}

	final private function moveSouth($dist)
	{
		$hull = $this->_pos;
		$this->_pos = [];
		foreach ($hull as $part)
			$this->_pos[] = $part + $dist * Battleground::WIDTH;
	}

	final private function moveWest($dist)
	{
		$hull = $this->_pos;
		$this->_pos = [];
		foreach ($hull as $part)
			$this->_pos[] = $part - $dist;
	}

	final private function moveEast($dist)
	{
		$hull = $this->_pos;
		$this->_pos = [];
		foreach ($hull as $part)
			$this->_pos[] = $part + $dist;
	}

	final private function setNorth($dir)
	{
		$spin = $this->_rotate;
		$ox = $this->_pos[$spin] % Battleground::WIDTH;
		$oy = ($this->_pos[$spin] - $ox) / Battleground::WIDTH;
		$this->_pos = [];
		for ($i = 0; $i < $this->_size['width']; $i++)
		{
			for ($j = 0; $j < $this->_size['length']; $j++)
				$this->_pos[] = (($oy + $i) * Battleground::WIDTH) + ($j * -$dir + $ox + $spin * $dir);
		}
		if ($dir == EnumDirection::LEFT)
			$this->_z = EnumDirection::WEST;
		else
			$this->_z = EnumDirection::EAST;
	}

	final private function setSouth($dir)
	{
		$spin = $this->_rotate;
		$ox = $this->_pos[$spin] % Battleground::WIDTH + $spin * $dir;
		$oy = ($this->_pos[$spin] - $ox) / Battleground::WIDTH;
		$this->_pos = [];
		for ($i = 0; $i < $this->_size['width']; $i++)
		{
			for ($j = 0; $j < $this->_size['length']; $j++)
				$this->_pos[] = (($oy + $i) * Battleground::WIDTH) + $j * $dir + $spin * -$dir + $ox;
		}
		if ($dir == EnumDirection::LEFT)
			$this->_z = EnumDirection::EAST;
		else
			$this->_z = EnumDirection::WEST;
	}

	final private function setWest($dir)
	{
		$spin = $this->_rotate;
		$ox = $this->_pos[$spin] % Battleground::WIDTH;
		$oy = ($this->_pos[$spin] - $ox) / Battleground::WIDTH;
		$this->_pos = [];
		for ($i = 0; $i < $this->_size['width']; $i++)
		{
			for ($j = 0; $j < $this->_size['length']; $j++)
				$this->_pos[] = (($oy + $j * $dir + $spin * -$dir) * Battleground::WIDTH) + $i * $dir + $ox;
		}
		if ($dir == EnumDirection::LEFT)
			$this->_z = EnumDirection::SOUTH;
		else
			$this->_z = EnumDirection::NORTH;
	}

	final private function setEast($dir)
	{
		$spin = $this->_rotate;
		$ox = $this->_pos[$spin] % Battleground::WIDTH;
		$oy = ($this->_pos[$spin] - $ox) / Battleground::WIDTH;
		$this->_pos = [];
		for ($i = 0; $i < $this->_size['width']; $i++)
		{
			for ($j = 0; $j < $this->_size['length']; $j++)
				$this->_pos[] = (($oy + $j * -$dir + $spin * $dir) * Battleground::WIDTH) + $i + $ox;
		}
		if ($dir == EnumDirection::LEFT)
			$this->_z = EnumDirection::NORTH;
		else
			$this->_z = EnumDirection::SOUTH;
	}

	final public function getSpeed()
	{
		return ($this->_speed);
	}

/*	public function getHP(
	{
		return ($this->_hp);
	})
	public function setHP($malus)
	{
		$this->_hp -= $malus;
	}
	public function getPP()
	{
		return ($this->_pp);
	}
	public function getShield()
	{
		return ($this->_shield);
	}
	public function setShield($bonus)
	{
		$this->_shield += $bonus;
	}
	public function getHandling()
	{
		return ($this->_handling);
	}
	public function getSize()
	{
		return ($this->_size);
	}
	public function getWeapons()
	{
		return ($this->_weapons);
	}
 */}
