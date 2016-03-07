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
   <?php   
   session_start();
    
 echo '<a href="profil_kupca.php">Vaš profil</a> | ';
?>
 </nav>

<?php 


include 'connection.php';

//kategorije:

include 'kategorije_lista.php';




echo '<h2><div align="center"><font color="red">NOVO U PONUDI:</font></div></h2>';
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



// proizvodi:
try{
$pdo = new PDO ("mysql:host=$host; dbname=$baza", $user, $pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
}
catch (PDOException $e) {
  die ("GREŠKA: Ne mogu se spojiti:".$e->getMessage());
}

$p="vrijeme_dodavanja DESC";

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

$query="SELECT * FROM proizvodi ORDER BY ".$p." LIMIT 6";
$stmt=$pdo->prepare($query);
$stmt->execute();
$rezultat=$stmt->fetchAll(PDO::FETCH_OBJ);

foreach ($rezultat as $key => $v) 
{

$cijena=$v->cijena;
$cijena=str_replace(".", ",", $cijena);

echo '<div style="float:left; margin-right: 30px; margin-bottom: 30px; border: 1px groove #aaaaaa">';
echo '<a href="proizvodi.php?id='.$v->br_proizvoda.'"><img width="220px" height="220px" src="slike/'.$v->slika.'" /></a>';
echo '<div align="center">';
echo '<h2>'.$v->naziv_proizvoda.'</a></h2>';

echo '<h1>'.$cijena.' kn</h1>';
echo '</div>';
echo '</div>';


 

}


unset($pdo);

?>







</body>



</html>