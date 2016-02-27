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


 $_SESSION["pass"]=$nova;
 echo '<div><b>Lozinka uspješno promijenjena!</b></div>';
}//kraj uvjeta za provjeru lozinke

else
{
  echo '<div><b>Krivo ste unijeli lozinku!</b></div>';
}

}// kraj uvjeta za dugme

echo '<h3>Vaše narudžbe:</h3>';
$query2="SELECT narudzbe.*, dostave.* FROM narudzbe JOIN dostave ON narudzbe.dostava=dostave.br_dostave WHERE kupac=? ORDER BY br_narudzbe DESC";
$stmt2=$pdo->prepare($query2);
$stmt2->bindParam(1, $rezultat->br_kupca);
$stmt2->execute();
$r2=$stmt2->fetchAll(PDO::FETCH_OBJ);

if ($r2==0 OR $r2=="") {
  echo "Nema narudžbi!";
  
}

else {
$br=0;
foreach ($r2 as $key => $v) {
$br++;
echo '<b>'.$br.'.)</b><br>';
echo '<b>Br. narudžbe: </b>'.$v->br_narudzbe.',<b> datum: </b>'.$v->datum;

$rbr=0;
$query3='SELECT detalji_narudzbe.*, proizvodi.* FROM detalji_narudzbe JOIN proizvodi ON detalji_narudzbe.proizvod=proizvodi.br_proizvoda WHERE narudzba=?';
$stmt3=$pdo->prepare($query3);
$stmt3->bindParam(1, $v->br_narudzbe);
$stmt3->execute();
$r=$stmt3->fetchAll(PDO::FETCH_OBJ);

echo '<div align="center"><table border="1" style="border-collapse: collapse; width: 90%">'; 
echo '<tr>';
echo '<th>';
echo 'br.';
echo '</th>';
echo '<th>Naziv proizvoda:</th>';
echo '<th>Opis:</th>';
echo '<th>Količina:</th>';
echo '<th>Cijena:</th>';
echo '<th>Ukupno:</th>';
echo '</tr>';
foreach ($r as $key => $value) {
$rbr++;
$k=$value->kolicina;
$c=$value->jedinicna_cijena;
$c=str_replace(".", ",", $c);

echo '<tr>';
echo '<td align="center">';
echo $rbr.'.';
echo '</td>';
echo '<td align="center">'.$value->naziv_proizvoda.'</td>';
echo '<td align="center">'.$value->detalji.'</td>';
echo '<td align="center">'.$value->kolicina.'</td>';
echo '<td align="center">'.$c.' kn</td>';

$c=str_replace(",", ".", $c);
$uk=$c*$k;
$uk=str_replace(".", ",", $uk); 
echo '<td align="center">'.$uk.' kn</td>';
echo '</tr>';

}// kraj foreach value

echo '</table></div>';  

$troskovi=str_replace(".", ",", $v->troskovi);
echo '<br><b>Dostava: </b>'.$v->naziv_dostave.' '.$troskovi.' kn<br>';
$ukupno=str_replace(".", ",", $v->ukupan_iznos);
echo '<b>Ukupno: </b>'.$ukupno.' kn';
echo '<hr>';
}// kraj foreach v

}


}// kraj uvjeta za postavljeni session [user]

?>

<div align="center"><footer>© Web Shop Trgovina </footer></div>

</body>

</html>