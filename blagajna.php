<!Doctype-html>

<html>
<head>

<title>Web shop</title>
<meta name="description" content="Web shop trgovina">
<meta name="keywords" content="Web shop, trgovina, kupovina, odjeća">
<meta charset="UTF-8">
</head>

<body>

<?php
session_start();
include "connection.php";

if (isset($_SESSION["user"]) AND isset($_SESSION["pass"])
	AND isset($_SESSION["kosarica"]))
 {
	


echo '<ul style="float:right;list-style-type:none;">    
    <br><li><a href="kosarica.php"><b>Košarica</b></a></li>
    <li><a href="logout.php">Logout</a></li>
  </ul>
</ul>
<br>';


 echo  '<nav>
   <a href="index.php">Početna</a> |
   <a href="onama.php">O nama</a>  |
   <a href="gdjesmo.php">Gdje smo</a> |';
    echo '<a href="profil_kupca.php">Vaš profil</a> |';
    echo '</nav>';

echo '<h1 align="center">BLAGAJNA:</h1>';  
 

$rbr=0;
foreach ($_SESSION["kosarica"] as $key => $value) {


echo '<table border="1" style="border-collapse: collapse; width: 90%">'; 
$rbr++;
echo '<tr>';
echo '<td>';
echo $rbr.'.';
echo '</td>';
foreach ($value as $k => $v) {


    echo '<td>';
    echo $k.': '.$v;
echo '</td>';
  }


echo '</tr>';
echo '</table><br>';	
	
}// kraj foreach kosarica

echo '<br><b>UKUPNO: '.$_SESSION["ukupno"].' kn</b>';

try{
$pdo = new PDO ("mysql:host=$host; dbname=$baza", $user, $pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
}
catch (PDOException $e) {
  die ("GREŠKA: Ne mogu se spojiti:".$e->getMessage());
}

$query="SELECT * FROM dostave";
$stmt=$pdo->prepare($query);
$stmt->execute();
$rezultat=$stmt->fetchAll(PDO::FETCH_OBJ);

$query2="SELECT * FROM kupci WHERE username=?";
$stmt=$pdo->prepare($query2);
$stmt->bindParam(1, $_SESSION["user"]);
$stmt->execute();
$r=$stmt->fetch(PDO::FETCH_OBJ);

echo '<form method="post">';
echo '<h3>Podaci o kupcu:</h3>';
echo 'Ime:<br><input type="text" name="ime" value="'.$r->ime.'"><br>';
echo 'Prezime:<br><input type="text" name="prezime" value="'.$r->prezime.'"><br>';
echo 'Adresa:<br><input type="text" name="adresa" value="'.$r->adresa.'"><br>';
echo 'Poštanski broj:<br><input type="text" name="postanski_broj" value="'.$r->postanski_broj.'"><br>';
echo 'Mjesto:<br><input type="text" name="mjesto" value="'.$r->mjesto.'"><br>';
echo 'Telefon:<br><input type="text" name="telefon" value="'.$r->telefon.'"><br>';

echo '<h3>Dostava:</h3>';
echo '<select name="dostava">';
foreach ($rezultat as $key => $value) {
	$troskovi=str_replace(".", ",", $value->troskovi);
	echo '<option value="'.$value->br_dostave.'">'.$value->naziv_dostave.' - '.$troskovi.' kn</option>';
}

echo '<select>';


echo '<h3>Plaćanje:</h3>';

$query3="SELECT * FROM placanja";
$stmt3=$pdo->prepare($query3);
$stmt3->execute();
$r3=$stmt3->fetchAll(PDO::FETCH_OBJ);

echo '<select name="placanje">';
foreach ($r3 as $key => $value) {
 echo '<option value="'.$value->br_pl.'">'.$value->naziv_placanja.'</option>';

}
echo '</select>';

echo '<br><br><input type="submit" name="dugme" value="Potvrdi">';
echo '</form>';

if (isset($_POST["dugme"])) {
	


$ime=$_POST["ime"];
$prezime=$_POST["prezime"];
$adresa=$_POST["adresa"];
$postanski_broj=$_POST["postanski_broj"];
$mjesto=$_POST["mjesto"];
$telefon=$_POST["telefon"];



function nije_prazno()
{
  
  $par=func_get_args();
  foreach ($par as $key => $value) {
    if (empty($value)) {
      return 0;
    }

  }

}

if (nije_prazno($ime, $prezime, $adresa, $postanski_broj, $mjesto, $telefon)!== 0)
{

// uvećavanje ukupnog iznosa za trošak dostave
$query4="SELECT * FROM dostave WHERE br_dostave=?";
$stmt4=$pdo->prepare($query4);
$stmt4->bindParam(1, $_POST["dostava"]);
$stmt4->execute();
$r4=$stmt4->fetch(PDO::FETCH_OBJ);

$_SESSION["ukupno"]=str_replace(",", ".", $_SESSION["ukupno"]);
$dostava=$r4->troskovi;

$_SESSION["ukupno"]+=$dostava;


// unos u tablicu narudzbe

$query5="SELECT * FROM kupci WHERE username=?";
$stmt5=$pdo->prepare($query5);
$stmt5->bindParam(1, $_SESSION["user"]);
$stmt5->execute();
$r5=$stmt5->fetch(PDO::FETCH_OBJ);
$kupac=$r5->br_kupca;

$query6="INSERT INTO narudzbe (kupac, dostava, placanje, ukupan_iznos, ime, prezime, adresa, mjesto, post_br, telefon)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt6=$pdo->prepare($query6);
$stmt6->bindParam(1, $kupac);
$stmt6->bindParam(2, $_POST["dostava"]);
$stmt6->bindParam(3, $_POST["placanje"]);
$stmt6->bindParam(4, $_SESSION["ukupno"]);
$stmt6->bindParam(5, $ime);
$stmt6->bindParam(6, $prezime);
$stmt6->bindParam(7, $adresa);
$stmt6->bindParam(8, $mjesto);
$stmt6->bindParam(9, $postanski_broj);
$stmt6->bindParam(10, $telefon);

$stmt6->execute();

// unos u detalji_narudzbe:

$query7="SELECT * FROM narudzbe ORDER BY datum DESC";
$stmt7=$pdo->prepare($query7);
$stmt7->execute();
$r7=$stmt7->fetch(PDO::FETCH_OBJ);
$nar=$r7->br_narudzbe;

foreach ($_SESSION["kosarica"] as $key => $value) {
  $id=$value["id"];
  $kolicina=$value["količina"];
  $cijena=str_replace(",", ".", $value["cijena"]); 
$detalji=$value; 
// detalji: izbaci količinu, cijenu i id, zadrži detalje
array_pop($detalji);
array_pop($detalji);
array_pop($detalji);
array_shift($detalji);
$detalji=implode(", ", $detalji);
 

  $query8="INSERT INTO detalji_narudzbe (narudzba, proizvod, kolicina, jedinicna_cijena, detalji)
  VALUES (?, ?, ?, ?, ?)";
  $stmt8=$pdo->prepare($query8);
  $stmt8->bindParam(1, $nar);
  $stmt8->bindParam(2, $id);
  $stmt8->bindParam(3, $kolicina);
  $stmt8->bindParam(4, $cijena);
  $stmt8->bindParam(5, $detalji);
  $stmt8->execute();
 


}



header("Location: potvrda.php");

}// kraj nije prazno

else
{
 
 echo '<br><b>NISTE DOBRO UNIJELI NEKO OD TRAŽENIH POLJA!</b>';

}

}//kraj if isset dugme


}// kraj if isset user, pass, kosarica



else {

	header("Location: index.php");
}




?>

</body>

</html>