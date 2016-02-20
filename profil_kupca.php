<!Doctype-HTML>
<html>
<head>

<title>Profil kupca</title>
<meta name="description" content="Profil kupca i podaci o njemu">
<meta name="keywords" content="web shop, kupovina, profil">
<meta charset="UTF-8"> 


</head>

<body>

<ul style="float:right;list-style-type:none;">
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
include "connection.php";
session_start();




if (!$_SESSION["user"] and !$_SESSION["pass"]) {
	header("location:login.php");
}

else
{

echo 
'<ul style="float:right;list-style-type:none;">
  <li><a href="logout.php">Logout</a></li>

  </ul>';

echo '<h2 >Podaci o kupcu:</h2>';


$pdo = new PDO ("mysql:host=$host; dbname=$baza", $user, $pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
$query="SELECT * FROM kupci  WHERE username=? AND password = ?";
$stmt=$pdo->prepare($query);
$stmt->bindParam(1, $_SESSION["user"]);
$stmt->bindParam(2, $_SESSION["pass"]);
$stmt->execute();
$rezultat=$stmt->fetch(PDO::FETCH_OBJ);


echo '<table  border="1">';
echo '<tr>';
echo '<th>Ime:</th>
      <th>Prezime:</th>
      <th>Adresa:</th>
      <th>Poštanski broj:</th>
      <th>Mjesto:</th>
      <th>Telefon:</th>
      <th>Email:</th>
      <th>Username:</th>';
echo '</tr>';      
echo '<tr>';
echo '<td>'.$rezultat->ime.'</td>';
echo '<td>'.$rezultat->prezime.'</td>';
echo '<td>'.$rezultat->adresa.'</td>';
echo '<td>'.$rezultat->postanski_broj.'</td>';
echo '<td>'.$rezultat->mjesto.'</td>';
echo '<td>'.$rezultat->telefon.'</td>';
echo '<td>'.$rezultat->email.'</td>';
echo '<td>'.$rezultat->username.'</td>';
echo '</tr>';
echo '</table>';

echo '<br><b>Promijeni lozinku:</b>';
echo '<form method="post">';
echo '<br>Stara lozinka:<br>';
echo '<input type="password" name="stara"><br>';
echo 'Nova loznika:<br>';
echo '<input type="password" name="nova"><br>';
echo 'Potvrdi novu lozinku:<br>';
echo '<input type="password" name="potvrda">'; 
echo '<br><input class="dugme" type="submit" name="dugme" value="Promijeni">';
echo '</form>';

if (isset($_POST["dugme"])) {


$stara=$_POST["stara"];
$nova=$_POST["nova"];
$potvrda=$_POST["potvrda"];

//provjera lozinke
if (!empty($stara) & !empty($nova) & !empty($potvrda)
AND md5($stara==$_SESSION["pass"]) AND $nova==$potvrda) {


 

$pdo = NEW pdo ("mysql:host=$host; dbname=$baza", $user, $pass);
$query="UPDATE kupci SET password = ? WHERE username = ? AND password= ? ";
$stmt=$pdo->prepare($query);
$stmt->bindParam(1, $nova, PDO::PARAM_STR);
$stmt->bindParam(2, $_SESSION["user"]);
$stmt->bindParam(3, $_SESSION["pass"]);
$nova=md5($nova);
$stmt->execute();
unset($pdo);  

 $_SESSION["pass"]=$nova;
 echo '<div><b>Lozinka uspješno promijenjena!</b></div>';
}//kraj uvjeta za provjeru lozinke

else
{
  echo '<div><b>Krivo ste unijeli lozinku!</b></div>';
}

}// kraj uvjeta za dugme

}// kraj uvjeta za postavljeni session [user]

?>

<div align="center"><footer>© Web Shop Trgovina </footer></div>

</body>

</html>