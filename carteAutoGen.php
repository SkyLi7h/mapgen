<?php
	$xCarte = 100;
	$yCarte = 100;
	
	/*
		libre 1 50%
		montagne 2 10%
		eau 3 10%
		barbare 4 28%
		mine 5 0.5%
		scierie 6 0.5%
		ferme 7 0.5%
		carriere 8 0.5%	
	*/
	
$nbSpeciaux = 0;
$nbBarbare = 0;

class carte
{	
	public function genTerrain()
	{
		$alea = rand(1, 1000);
		global $nbSpeciaux, $nbBarbare;
		
		if($alea <= 500)
		{
			$type = 1;
		}
		else if($alea <= 600)
		{
			$type = 2;
		}
		else if($alea <= 700)
		{
			$type = 3;
		}
		else if($alea <= 980)
		{
			$nbBarbare ++;
			$type = 4;
		}
		else if($alea <= 985)
		{
			$type = 5;
			$nbSpeciaux++;
		}
		else if($alea <= 990)
		{
			$type = 6;
			$nbSpeciaux++;
		}
		else if($alea <= 995)
		{
			$type = 7;
			$nbSpeciaux++;
		}
		else if($alea <= 1000)
		{
			$type = 8;
			$nbSpeciaux++;
		}
		
		
		
		return $type;
	}
	
	public function getNbSpeciaux()
	{	
		global $nbSpeciaux;
		return $nbSpeciaux;
	}
	
	public function getNbBarbares()
	{	
		global $nbBarbare;
		return $nbBarbare;
	}
}
	
	$carte = new carte();
	
	for ($x=0; $x<$xCarte; $x++)
	{
		for ($y=0; $y<$xCarte; $y++)
		{
			echo $carte->genTerrain() . " ; ";		
		}	
		
		echo "<br>";
	}
	
	echo "<br><br>Nb spéciaux : ". $carte->getNbSpeciaux();
	echo "<br><br>Nb barbares : ". $carte->getNbBarbares();








?>