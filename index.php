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
    if (!$_SESSION["user"] and !$_SESSION["pass"]) {
 echo '<a href="profil_kupca.php">Vaš profil</a> | ';
}
?>
 </nav>

<?php 


include 'connection.php';

//kategorije:

include 'kategorije_lista.php';




echo '<h2><div align="center"><font color="red">NOVO U PONUDI:</font></div></h2>';




// proizvodi:
try{
$pdo = new PDO ("mysql:host=$host; dbname=$baza", $user, $pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
}
catch (PDOException $e) {
  die ("GREŠKA: Ne mogu se spojiti:".$e->getMessage());
}
$query="SELECT * FROM proizvodi ORDER BY vrijeme_dodavanja DESC LIMIT 6";
$stmt=$pdo->prepare($query);
$stmt->execute();
$rezultat=$stmt->fetchAll(PDO::FETCH_OBJ);

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

unset($pdo);

?>







</body>



</html>