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


<h1 align="center">KOŠARICA:</h1>
   <nav>
   <a href="index.php">Početna</a> |
   <a href="onama.php">O nama</a>  |
   <a href="gdjesmo.php">Gdje smo</a> |
 </nav>

<?php

require "connection.php";
session_start();
include "kategorije_lista.php";



// izbaci value - dugme:
array_pop($_POST);


 


if (isset($_POST['id']))
 {
    $id = $_POST['id'];
  
  
  // ako je košarica prazna
  if (!isset($_SESSION["kosarica"]) OR empty($_SESSION["kosarica"]) )
   { 
     
     
     $_POST["količina"]=1;
  $_SESSION["kosarica"]=array();
  array_push($_SESSION["kosarica"], $_POST);
  
  

} 



 else {
    // ako ima proizvoda
   $postoji=0;

foreach ($_SESSION["kosarica"] as $key => &$value) {

  // korišteno &$value da bi pomoću foreach petlje mogao mijenjati value array i ubaciti staru količinu na kraj

  // skida i čuva postojeće količine, uspoređuje opcije proizvoda:
$zadnja_v = end($value);

  array_pop($value);
 


  if ($value===$_POST) {


    $value["količina"]=$zadnja_v; //vraća zadnju količinu
    $value["količina"]+=1; // uvećava za 1
    $postoji=1;
  
}

// ako prozivod nije u košarici, vraća se zadnja količina:
else
{
$value["količina"]=$zadnja_v;
}

} // kraj foreach


// dodaj novi proizvod u košaricu:
    
    if ($postoji<1) {
       $_POST["količina"]=1;
  
  
 array_push($_SESSION["kosarica"], $_POST);

       }
       
  } // kraj else isset id
 // header("location: kosarica.php"); 
    



} // kraj if is set id



if (!isset($_SESSION["kosarica"]))
 {
  

  echo '<br><br><h3 align="center">Košarica je prazna!</h3><br>';
}



if (isset($_SESSION["kosarica"])) {
  
  

echo '<h3 align="center">Proizvodi u košarici:</h3>';
$rbr=0;
$ukupno=0;
echo '<table border="1" style="border-collapse: collapse;">';

foreach ($_SESSION["kosarica"] as $key => $value) {
$rbr++;
echo '<tr>';
echo '<td>';
echo $rbr.'.';
echo '</td>';
// izračun cijene sstavke:

$c=$value["cijena"];
$c=str_replace(",", ".", $c); // zamijena zareza točkom zbog računanja
$c=$c*$value["količina"];
$ukupno=$c+$ukupno; //ukupan iznos.

  foreach ($value as $k => $v) {
    echo '<td>';
    echo $k.': '.$v;
echo '</td>';
  }
  echo '<td>';
  
  echo '<form method="post" action="kosarica_test.php">';
  echo '<button type="submit" name="brisi" value="'.$key.'">Obriši</button>';
 
  echo '</form>';
  echo '</td>';
echo '</tr>';

} // kraj foreach session["kosarica"]
echo '<table>';




}// kraj if is set kosarica




echo '<br>';
$ukupno=str_replace(".", ",", $ukupno);
echo '<b>UKUPNO: '.$ukupno.' kn</b>';

if (isset($_POST["brisi"])) {
    
    for ($i=0; $i <count($_SESSION["kosarica"]) ; $i++) { 
      

    }
}

// brisanje proizvoda iz košarice
if (isset($_POST["brisi"])) {
  $br=$_POST["brisi"];
  unset($_SESSION["kosarica"][$br]);
  header('Location: kosarica_test.php');
}



?>

</body>

</html>