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

if (isset($_SESSION["user"]) AND isset($_SESSION["pass"]))
 {
	
$pdo = new PDO ("mysql:host=$host; dbname=$baza", $user, $pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

$query2="SELECT br_kupca FROM kupci WHERE username=?";
$stmt2=$pdo->prepare($query2);
$stmt2->bindParam(1, $_SESSION["user"]);
$stmt2->execute();
$br_kup=$stmt2->fetch(PDO::FETCH_OBJ);
$br_kup=$br_kup->br_kupca;

$query3="SELECT br_narudzbe FROM narudzbe WHERE kupac=? ORDER BY br_narudzbe DESC";
$stmt3=$pdo->prepare($query3);
$stmt3->bindParam(1, $br_kup);
$stmt3->execute();
$br_nar=$stmt3->fetch(PDO::FETCH_OBJ);
$br_nar=$br_nar->br_narudzbe;



$query="SELECT  narudzbe.*, detalji_narudzbe.*, dostave.*, placanja.*, kupci.ime AS k_ime, kupci.prezime AS k_prezime, kupci.email, kupci.username, proizvodi.naziv_proizvoda FROM narudzbe JOIN detalji_narudzbe ON detalji_narudzbe.narudzba=narudzbe.br_narudzbe
JOIN dostave ON dostave.br_dostave=narudzbe.dostava JOIN placanja ON placanja.br_pl=narudzbe.placanje JOIN kupci ON kupci.br_kupca=narudzbe.kupac JOIN proizvodi ON proizvodi.br_proizvoda=detalji_narudzbe.proizvod WHERE br_narudzbe=?";
$stmt=$pdo->prepare($query);
$stmt->bindParam(1, $br_nar);
$stmt->execute();
$r=$stmt->fetchAll(PDO::FETCH_OBJ); 

// ime, prezime, adresa, ime i prezime kupca isti su za svaki artikl u narudžbi s toga se korsiti $r[0]
$ukupno=str_replace(".", ",", $r[0]->ukupan_iznos);
echo '<br>Poštovani<b> '.$r[0]->k_ime.' '.$r[0]->k_prezime.'</b>, vaša narudžba u ukupnom iznosu od: <b>'.$ukupno.' kn</b> uspješno je zaprimljena.<br>';

echo '<b>Broj narudžbe: </b>'.$r[0]->br_narudzbe.'<br><b> Datum: </b>'.$r[0]->datum.'<br>';
echo '<b>Dostava: </b>'.$r[0]->naziv_dostave.', <b>plaćanje: </b>'.$r[0]->naziv_placanja.'<br>';
echo '<b>Adresa dostave: </b><br>';
echo $r[0]->ime.' '.$r[0]->prezime.',<br>';
echo $r[0]->adresa.', '.$r[0]->post_br.' '.$r[0]->mjesto.'<br><br>';

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
$rbr=0;
$uk=0;
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



}// kraj foreach 

echo '</table></div><br>';  

$tr=str_replace(".", ",", $r[0]->troskovi);
$ukupno=str_replace(".", ",", $r[0]->ukupan_iznos);
echo '<b>Troškovi dostave:</b> '.$tr.' kn';
echo '<br><b>Ukupno:</b> '.$ukupno.' kn';



echo '<br><br>Svoje narudžbe možete pogledati na <a href="profil_kupca.php">vašem korisničkom profilu</a>';
echo '<br><br><br><center><a href="index.php">Povratak na početnu stranicu</a></center>';

// email korisniku s potvrdom narudžbe:

$txt='<html>
<head>
  <title>Vaša narudžba:</title>
</head>';
$txt.='<body><br>Poštovani<b> '.$r[0]->k_ime.' '.$r[0]->k_prezime.'</b>, vaša narudžba u ukupnom iznosu od: <b>'.$ukupno.' kn </b> uspješno je zaprimljena.<br>'
.'<b>Broj narudžbe: </b>'.$r[0]->br_narudzbe.'<br><b> Datum: </b>'.$r[0]->datum.'<br>'
.'<b>Dostava: </b>'.$r[0]->naziv_dostave.', <b> plaćanje: </b>'.$r[0]->naziv_placanja.'<br>'
.'<b>Adresa dostave: </b><br>'
.$r[0]->ime.' '.$r[0]->prezime.',<br>'
.$r[0]->adresa.', '.$r[0]->post_br.' '.$r[0]->mjesto.'<br><br>'
.'<div align="center"><table border="1" style="border-collapse: collapse; width: 90%">' 
.'<tr>'
.'<th>'
.'br.'
.'</th>'
.'<th>Naziv proizvoda:</th>'
.'<th>Opis:</th>'
.'<th>Količina:</th>'
.'<th>Cijena:</th>'
.'<th>Ukupno:</th>'
.'</tr>';
$rbr=0;
$uk=0;
foreach ($r as $key => $value) {
$rbr++;
$k=$value->kolicina;
$c=$value->jedinicna_cijena;
$c=str_replace(".", ",", $c);
$txt.='<tr>'
.'<td align="center">'
.$rbr.'.'
.'</td>'
.'<td align="center">'.$value->naziv_proizvoda.'</td>'
.'<td align="center">'.$value->detalji.'</td>'
.'<td align="center">'.$value->kolicina.'</td>'
.'<td align="center">'.$c.' kn</td>';
$c=str_replace(",", ".", $c);
$uk=$c*$k; 
$uk=str_replace(".", ",", $uk);
$txt.='<td align="center">'.$uk.' kn</td>'
.'</tr>';
}// kraj foreach 

$txt.='</table></div><br>'; 
$tr=str_replace(".", ",", $r[0]->troskovi);
$ukupno=str_replace(".", ",", $r[0]->ukupan_iznos);
$txt.='<b>Troškovi dostave:</b> '.$tr.' kn'
.'<br><b>Ukupno:</b> '.$ukupno.' kn
<br><br>HVALA NA POVJERENJU!</body></html>';
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";


$to = $r[0]->email;
$subject = "Potvrda narudžbe!";
$from = "From: Web Shop <webshop@webshop.hr>";
mail($to, $subject, $txt, $headers); // mail


unset($_SESSION["kosarica"]);
unset($_SESSION["ukupno"]);

if (isset($_SESSION["Payment_Amount"])) {
  unset( "Payment_Amount");
}

}// kraj if isset user, pass



else {

	header("Location: index.php");
}




?>

</body>

</html>