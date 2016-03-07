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

$p="naziv_proizvoda";
// sortiranje po atributima:
if (isset($_POST["button"])) {
switch ($_POST["sortiraj"]) {
  case '1':
    $p="cijena DESC";
    break;
  case '2':
    $p="cijena ASC";
    break;
    case '3':
     $p="naziv_proizvoda ASC"; 
      break;
     case '4':
      $p="naziv_proizvoda DESC";
        break; 
    case '5':
      $p="vrijeme_dodavanja DESC";
      break;
   case '6':
        $p="vrijeme_dodavanja ASC";
        break;   
}

}// kraj if isset button

$query="SELECT proizvodi.*, kategorije.* FROM proizvodi
JOIN kategorije ON kategorije.br_kategorije =proizvodi.kategorija
WHERE br_kategorije=? ORDER BY ".$p;

$stmt=$pdo->prepare($query);
$stmt->bindParam(1, $_GET["id"]);
$stmt->execute();
$rezultat=$stmt->fetchAll(PDO::FETCH_OBJ);


if (isset($_GET["pk"])) {
	
$p="naziv_proizvoda";
// sortiranje po atributima:
if (isset($_POST["button"])) {
switch ($_POST["sortiraj"]) {
  case '1':
    $p="cijena DESC";
    break;
  case '2':
    $p="cijena ASC";
    break;
    case '3':
     $p="naziv_proizvoda ASC"; 
      break;
     case '4':
      $p="naziv_proizvoda DESC";
        break; 
    case '5':
      $p="vrijeme_dodavanja DESC";
      break;
   case '6':
        $p="vrijeme_dodavanja ASC";
        break;   
}

}// kraj if isset button
$query2="SELECT proizvodi.*, kategorije.*, potkategorije.* FROM proizvodi
JOIN kategorije ON kategorije.br_kategorije =proizvodi.kategorija JOIN
potkategorije ON potkategorije.br_potkategorije=proizvodi.potkategorija
 WHERE proizvodi.potkategorija=? ORDER BY ".$p;
$stmt2=$pdo->prepare($query2);
$stmt2->bindParam(1, $_GET["pk"]);
$stmt2->execute();
$rezultat2=$stmt2->fetchAll(PDO::FETCH_OBJ);

// naslov potkategorije:
$array = json_decode(json_encode($rezultat2), true);
echo '<div align="center"><h1>'.$array["0"]["naziv_potkategorije"].':</h1></div>';
?>
<form method="post">
<b>Sortiraj:</b>
<select name="sortiraj">
  <option value="">Odaberi...</option>
  <option value="1">S višom cijenom</option>
  <option value="2">S nižom cijenom</option>
  <option value="3">Prema nazivu A-Z</option>
  <option value="4">Prema nazivu Z-A</option>
  <option value="5">Prema datumu, najnoviji</option>
   <option value="6">Prema datumu, najstariji</option>
</select>
<input type="submit" name="button" value="Sortiraj">
</form>

<?php

foreach ($rezultat2 as $key => $v) 
{

echo '<div style="float:left; margin-right: 30px; margin-bottom: 30px; border: 1px groove #aaaaaa">';
echo '<a href="proizvodi.php?id='.$v->br_proizvoda.'"><img width="220px" height="220px" src="slike/'.$v->slika.'" /></a>';
echo '<div align="center">';
echo '<h2>'.$v->naziv_proizvoda.'</a></h2>';
$cijena=$v->cijena;
$cijena=str_replace(".", ",", $cijena);
echo '<h1>'.$cijena.' kn</h1>';
echo '</div>';
echo '</div>';

}


}// kraj ako ima potkategorije


else
{

// naslov kategorije:
$array = json_decode(json_encode($rezultat), true);
echo '<div align="center"><h1>'.$array["0"]["naziv_kategorije"].':</h1></div>';
?>

<form method="post">
<b>Sortiraj:</b>
<select name="sortiraj">
  <option value="">Odaberi...</option>
  <option value="1">S višom cijenom</option>
  <option value="2">S nižom cijenom</option>
  <option value="3">Prema nazivu A-Z</option>
  <option value="4">Prema nazivu Z-A</option>
  <option value="5">Prema datumu, najnoviji</option>
   <option value="6">Prema datumu, najstariji</option>
</select>
<input type="submit" name="button" value="Sortiraj">
</form>

<?php

foreach ($rezultat as $key => $v) 
{

echo '<div style="float:left; margin-right: 30px; margin-bottom: 30px; border: 1px groove #aaaaaa">';
echo '<a href="proizvodi.php?id='.$v->br_proizvoda.'"><img width="220px" height="220px" src="slike/'.$v->slika.'" /></a>';
echo '<div align="center">';
echo '<h2>'.$v->naziv_proizvoda.'</a></h2>';

$cijena=$v->cijena;
$cijena=str_replace(".", ",", $cijena);
echo '<h1>'.$cijena.' kn</h1>';
echo '</div>';
echo '</div>';


 

}


}



unset($pdo);






?>


</body>


</html>