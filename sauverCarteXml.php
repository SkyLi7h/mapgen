<?php
header("Content-Type: text/plain"); // Utilisation d'un header pour spécifier le type de contenu de la page. Ici, il s'agit juste de texte brut (text/plain). 

$carte = json_decode($_POST["carte"]);

if(file_exists('carte.json'))
	unlink('carte.json');


$monfichier = fopen('carte.json', 'w+');
 
fputs($monfichier, $_POST["carte"]);

echo "savegarde terminée";

?>