<!Doctype-html>
<html>
<head>
<title>Web shop</title>
<meta name="description" content="Web shop trgovina">
<meta name="keywords" content="Web shop, trgovina, kupovina, odjeća">
<meta charset="UTF-8">



</head>

<body>

<ul style="float:right;list-style-type:none;">
    <li><a href="registracija.php">Registracija</a></li>
    <li><a href="login.php">Login</a></li>
    <br><li><a href="kosarica.php"><b>Košarica</b></a></li>
  </ul>
</ul>


<h1 align="center">WEB SHOP TRGOVINA</h1>
   <nav>
   <a href="index.php">Početna</a> |
   <a href="onama.php">O nama</a>  |
   <a href="gdjesmo.php">Gdje smo</a> |
 </nav>	


<?php

include 'connection.php';
session_start();
//kategorije:

include 'kategorije_lista.php';



#####
try{
$pdo = new PDO ("mysql:host=$host; dbname=$baza", $user, $pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
}
catch (PDOException $e) {
  die ("GREŠKA: Ne mogu se spojiti:".$e->getMessage());
}

$query="SELECT proizvodi.*, kategorije.* FROM proizvodi
JOIN kategorije ON kategorije.br_kategorije =proizvodi.kategorija
WHERE br_kategorije=?";

$stmt=$pdo->prepare($query);
$stmt->bindParam(1, $_GET["id"]);
$stmt->execute();
$rezultat=$stmt->fetchAll(PDO::FETCH_OBJ);


if (isset($_GET["pk"])) {
	

$query2="SELECT proizvodi.*, kategorije.*, potkategorije.* FROM proizvodi
JOIN kategorije ON kategorije.br_kategorije =proizvodi.kategorija JOIN
potkategorije ON potkategorije.br_potkategorije=proizvodi.potkategorija
 WHERE proizvodi.potkategorija=? ORDER BY naziv_proizvoda ASC";
$stmt2=$pdo->prepare($query2);
$stmt2->bindParam(1, $_GET["pk"]);
$stmt2->execute();
$rezultat2=$stmt2->fetchAll(PDO::FETCH_OBJ);

// naslov potkategorije:
$array = json_decode(json_encode($rezultat2), true);
echo '<div align="center"><h1>'.$array["0"]["naziv_potkategorije"].':</h1></div>';

foreach ($rezultat2 as $key => $v) 
{

echo '<div style="float:left; margin-right: 30px; margin-bottom: 30px; border: 1px groove #aaaaaa">';
echo '<a href="proizvodi.php?id='.$v->br_proizvoda.'"><img width="220px" height="220px" src="slike/'.$v->slika.'" /></a>';
echo '<div align="center">';
echo '<h2>'.$v->naziv_proizvoda.'</a></h2>';

echo '<h1>'.$v->cijena.' kn</h1>';
echo '</div>';
echo '</div>';


 

}


}// kraj ako ima potkategorije


else
{

// naslov kategorije:
$array = json_decode(json_encode($rezultat), true);
echo '<div align="center"><h1>'.$array["0"]["naziv_kategorije"].':</h1></div>';

foreach ($rezultat as $key => $v) 
{

echo '<div style="float:left; margin-right: 30px; margin-bottom: 30px; border: 1px groove #aaaaaa">';
echo '<a href="proizvodi.php?id='.$v->br_proizvoda.'"><img width="220px" height="220px" src="slike/'.$v->slika.'" /></a>';
echo '<div align="center">';
echo '<h2>'.$v->naziv_proizvoda.'</a></h2>';

echo '<h1>'.$v->cijena.' kn</h1>';
echo '</div>';
echo '</div>';


 

}


}

unset($pdo);






?>


</body>


</html>