<script>
		var carte = [];	
		
		function getXMLHttpRequest() {
	var xhr = null;
	
	if (window.XMLHttpRequest || window.ActiveXObject) {
		if (window.ActiveXObject) {
			try {
				xhr = new ActiveXObject("Msxml2.XMLHTTP");
			} catch(e) {
				xhr = new ActiveXObject("Microsoft.XMLHTTP");
			}
		} else {
			xhr = new XMLHttpRequest(); 
		}
	} else {
		alert("Votre navigateur ne supporte pas l'objet XMLHTTPRequest...");
		return null;
	}
	
	return xhr;
}
</script>

<?php


$DB_ACCESS = "MYSQL"; //Type d'accès aux données
$HOST = "localhost";
$DBNAME = "feudalism";
$LOGIN = "root";
$PASS = "0!";

$bdd = new PDO('mysql:host='.$HOST.';dbname='.$DBNAME.';charset=utf8', $LOGIN, $PASS);
$reponse = $bdd->query('SELECT * FROM carte');


while($donnees = $reponse->fetch())
{
?>
	<script>
		if(carte[<?php echo  $donnees["y"];?>] == null)
			carte[<?php echo  $donnees["y"];?>] = [];
		
		carte[<?php echo  $donnees["y"];?>][<?php echo  $donnees["x"];?>] = "<?php echo  $donnees["type"];?>";
	</script>
	
<?php
}

if(file_exists('carte.json'))
{
	// 1 : on ouvre le fichier
	$monfichier = fopen('carte.json', 'r+');
	 
	// 2 : on lit la première ligne du fichier
	$carteJson = fgets($monfichier);
	 
	// 3 : quand on a fini de l'utiliser, on ferme le fichier
	fclose($monfichier);

	$carte = json_decode($carteJson);

	for($y = 1; $y < count($carte); $y++)
	{
		for($x = 1; $x < count($carte[$y]); $x++)
		{
			?>
			<script>
			if(carte[<?php echo  $y;?>] == null)
				carte[<?php echo  $y;?>] = [];
			
			carte[<?php echo  $y;?>][<?php echo $x;?>] = "<?php echo  $carte[$y][$x];?>";
			</script>
			<?php
		}
	}
	
	
}


?>



<html charset="utf-8">
	<head>
		<style  type="text/css">
			#divMap
			{
				overflow: auto;
				width: 100%;
				height: 95%;
			}
			#tableCarte
			{	
				overflow-x: scroll;
				overflow-y: scroll;
			}
			
			#tableCarte tr
			{	
				min-width: 50px;
			}
			
			#tableCarte td
			{
				height: 64px;
				min-width: 64px;
				background-image: URL('img/plains.png');
			}
		
		</style>
	
	</head>
	<body>
		<script>
			var xSelected, ySelected = null;
		
			function genererCarte()
			{
				var tailleX = document.getElementById("x").value;
				var tailleY = document.getElementById("y").value;
				var tableCarte = "<table cellspacing='0' id='tableCarte'>";
				
				for(var y = 0; y < tailleY; y++)
				{
					tableCarte += "<tr>";
					carte[y+1] = [];
					
					for(var x = 0; x < tailleX; x++)
					{
						carte[y+1][x+1] = "plaine";
						tableCarte += "<td onClick='selectTile("+ (x+1) +","+ (y+1) +")' id='x"+(x+1)+"y"+(y+1)+"'></td>";
					}
					
					tableCarte += "</tr>";
				
				}
				
				
				tableCarte += "</table>";
				document.getElementById("divMap").innerHTML = tableCarte;		
			}
			
			function chargerCarte()
			{
				var tableCarte = "<table cellspacing='0' id='tableCarte'>";
				var img;
				
				for(var y = 1; y < carte.length; y++)
				{
					tableCarte += "<tr>";
					ligne = carte[y];

					for(var x = 1; x < ligne.length; x++)
					{
						if(carte[y][x] == "plaine")		
							img = "img/plains.png";
						if(carte[y][x] == "montagne")		
							img = "img/mountains.png";
						if(carte[y][x] == "foret")		
							img = "img/forest.png";
						
						
						tableCarte += "<td style='background-image:URL("+ img +");' onClick='selectTile("+ (x) +","+ (y) +")' id='x"+(x)+"y"+(y)+"'></td>";
					}
					
					tableCarte += "</tr>";
				
				}
				
				
				tableCarte += "</table>";
				document.getElementById("divMap").innerHTML = tableCarte;
				
			}
			
			function sauvegarderXml()
			{
				var xhr = getXMLHttpRequest(); // Voyez la fonction getXMLHttpRequest() définie dans la partie précédente

				xhr.open("POST", "sauverCarteXml.php", true);
				xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
				carteJson = JSON.stringify(carte);
				console.log(carteJson);
				xhr.send("carte="+ carteJson);
				
				
				xhr.onreadystatechange = function() {
					if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
							alert(xhr.responseText); // Données textuelles récupérées
					}
					};
				
				
			}
			
			function sauvegarderMysql()
			{
				var xhr = getXMLHttpRequest(); // Voyez la fonction getXMLHttpRequest() définie dans la partie précédente

				xhr.open("POST", "sauverCarteMysql.php", true);
				xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
				carteJson = JSON.stringify(carte);
				console.log(carteJson);
				xhr.send("carte="+ carteJson);
				
				
				xhr.onreadystatechange = function() {
					if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
							alert(xhr.responseText); // Données textuelles récupérées
					}
					};
				
				
			}
			
			function selectTile(x, y)
			{
				if(xSelected != null)
					document.getElementById("x"+xSelected+"y"+ySelected).style.border="";
					
				xSelected = x;
				ySelected = y;
				document.getElementById("x"+xSelected+"y"+ySelected).style.border="1px inset red";
			}
			
			function montagne()
			{
				document.getElementById("x"+xSelected+"y"+ySelected).style.backgroundImage="URL('img/mountains.png')";
				carte[ySelected][xSelected] = "montagne";
			}
			
			function plaine()
			{
				document.getElementById("x"+xSelected+"y"+ySelected).style.backgroundImage="URL('img/plains.png')";
				carte[ySelected][xSelected] = "plaine";
			}
			
			function foret()
			{
				document.getElementById("x"+xSelected+"y"+ySelected).style.backgroundImage="URL('img/forest.png')";
				carte[ySelected][xSelected] = "foret";
			}			
			
			
			

		</script>

		<input type="text" id="x"/>
		<input type="text" id="y"/>
		<input type="submit" value="generer" onClick="genererCarte()"/>
		<input type="submit" value="montagne" onClick="montagne()"/>
		<input type="submit" value="plaine" onClick="plaine()"/>
		<input type="submit" value="foret" onClick="foret()"/>
		<input type="submit" value="sauvegarder Xml" onClick="sauvegarderXml()"/>
		<input type="submit" value="sauvegarder Mysql" onClick="sauvegarderMysql()"/>
		<div id="divMap">
		
		
		</div>
		
		<script>
		if(carte.length != 0)
			{
				chargerCarte();
			}
		</script>
	</body>
</html>


