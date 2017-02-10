<?php
header("Content-Type: text/plain"); // Utilisation d'un header pour spécifier le type de contenu de la page. Ici, il s'agit juste de texte brut (text/plain). 

$carte = json_decode($_POST["carte"]);


$DB_ACCESS = "MYSQL"; //Type d'accès aux données
$HOST = "localhost";
$DBNAME = "feudalism";
$LOGIN = "root";
$PASS = "0!";

$bdd = new PDO('mysql:host='.$HOST.';dbname='.$DBNAME.';charset=utf8', $LOGIN, $PASS);
$reponse = $bdd->query('SELECT * FROM carte');

$bdd->query('DELETE FROM carte');
$bdd->query('ALTER TABLE carte AUTO_INCREMENT = 1');



for($y = 1; $y < count($carte); $y++)
{
	for($x = 1; $x < count($carte[$y]); $x++)
	{
		$type = $carte[$y][$x];
		$bdd->query("INSERT INTO carte (x, y, type, joueurId) VALUES ('$x','$y','$type', null)");
	}
}

echo "savegarde mysql terminée";

?>
