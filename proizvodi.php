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

   <nav>
   <a href="index.php">Početna</a> |
   <a href="onama.php">O nama</a>  |
   <a href="gdjesmo.php">Gdje smo</a> |
 </nav>	



<?php
session_start();
include 'connection.php';


try{
$pdo = new PDO ("mysql:host=$host; dbname=$baza", $user, $pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
}
catch (PDOException $e) {
  die ("GREŠKA: Ne mogu se spojiti:".$e->getMessage());
}

$query="SELECT proizvodi.*, kategorije.* 
FROM proizvodi LEFT JOIN kategorije ON proizvodi.kategorija=kategorije.br_kategorije
LEFT JOIN potkategorije ON kategorije.br_kategorije=potkategorije.kategorija
 WHERE br_proizvoda=?";
$stmt=$pdo->prepare($query);
$stmt->bindParam(1, $_GET["id"], PDO::PARAM_INT);
$stmt->execute();

$rezultat=$stmt->fetch(PDO::FETCH_OBJ);

$query4="SELECT proizvodi.*, potkategorije.* FROM proizvodi JOIN potkategorije ON
proizvodi.potkategorija=potkategorije.br_potkategorije WHERE br_proizvoda=?";
$stmt4=$pdo->prepare($query4);
$stmt4->bindParam(1, $_GET["id"], PDO::PARAM_INT);
$stmt4->execute();
$rezultat4=$stmt4->fetch(PDO::FETCH_OBJ);



$broj=$stmt->rowCount();

if ($broj<1) {
	echo '<br><h2>Takav proizvod ne postoji!</h2>';
}



else {
  echo '<br><b>Kategorije: </b>'; 
  echo '<a href="kategorije.php?id='.$rezultat->br_kategorije.'"><b>  '.$rezultat->naziv_kategorije.'</b></a>';
 // ako proizvod ima potkategorije - prikaži ih:
if (isset($rezultat4->potkategorija)) {
  

  echo ' <b>></b> <a href="kategorije.php?id='.$rezultat->br_kategorije.'&pk='.$rezultat4->br_potkategorije.'">  '.$rezultat4->naziv_potkategorije.'</a>';
}
	echo '<form method="post" action="kosarica_test.php">';
echo '<h1>'.$rezultat->naziv_proizvoda.'<h1>';
echo '<input type="hidden" name="naziv" value="'.$rezultat->naziv_proizvoda.'">';
echo '<table  border="0" width="100%" cellspacing="0" cellpadding="6">';
echo '<tr>';
echo '<td width="15%">';
echo '<img src="slike/'.$rezultat->slika.'" height="300" width="250">';
echo '</td>';
echo '<td width="40%" valign="top"><font size ="5">';
echo '<b>Opis proizvoda: </b><br>'.$rezultat->opis;
echo '<br><b>Na skladištu: </b><br>'.$rezultat->na_skladistu;
echo '<br><b>Dodano dana:</b> <br>'.$rezultat->vrijeme_dodavanja;

// opcije proizvoda:

$query2="SELECT * FROM opcijske_grupe";
$stmt2=$pdo->query($query2);
$opcijske_grupe=$stmt2->fetchAll(PDO::FETCH_OBJ);



foreach ($opcijske_grupe as $key => $og)
 {



 $query3="SELECT opcijske_grupe.naziv_opc_grupe, opcije.br_opcije , opcije.naziv_opcije FROM opcijske_grupe
JOIN opcije ON opcije.br_opc_grupe=opcijske_grupe.br_opc_grupe  JOIN
proizvodi_opcije ON proizvodi_opcije.opcija=opcije.br_opcije WHERE
proizvodi_opcije.proizvod=? AND naziv_opc_grupe LIKE ?";
$stmt3=$pdo->prepare($query3);
$stmt3->bindParam(1, $_GET["id"], PDO::PARAM_INT);
$stmt3->bindParam(2, $og->naziv_opc_grupe);
$stmt3->execute();
$opcije=$stmt3->fetchAll(PDO::FETCH_OBJ);

// provjera koje opcije proizvod ima:

if ($stmt3->rowCount()>0) 
 { 
echo '<br><b>'.$og->naziv_opc_grupe.": </b>";

echo '<select name="'.$og->naziv_opc_grupe.'" >';
foreach ($opcije as $key => $o) {
  
echo '<option value="'.$o->naziv_opcije.'">'.$o->naziv_opcije;
echo '</option>'; 

}
echo '</select>'; 
}// kraj provjere koje opcije proizvod ima

} 



echo '<input type="hidden" name="id" value="'.$rezultat->br_proizvoda.'">';
$cijena=$rezultat->cijena;
$cijena=str_replace(".", ",", $cijena);
echo '<br><br><strong>Cijena: '.$cijena.' kn</strong>';
echo '<input type="hidden" name="cijena" value="'.$cijena.' kn">';

// ako ima na skladištu, moguće je dodati u košaricu
if ($rezultat->na_skladistu =="dostupno") {
 

 echo '<br><input type="submit" name="dugme" value="Dodaj u košaricu">';
}

else {

echo '<br>Proizvod trenutno nije dostupan na skladištu. <br>Nije moguće dodati u košaricu.';

}

echo '</form>';
 echo '</font></td>'; 

echo '</tr>';
echo '</table>';

} // kraj provjere postojanja proizvoda u bazi








?>




</body>


</html>