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
<br>

<h1 align="center">KOŠARICA:</h1>
   <nav>
   <a href="index.php">Početna</a> |
   <a href="onama.php">O nama</a>  |
   <a href="gdjesmo.php">Gdje smo</a> |
    <?php
    session_start();
 if (isset($_SESSION["user"]) AND isset($_SESSION["pass"])) {
  echo '<a href="profil_kupca.php">Vaš profil</a> |';
  echo 
'<ul style="float:right;list-style-type:none;">
  <li><a href="logout.php">Logout</a></li>
 </ul>';
 
}
?>
 </nav>

<?php

require "connection.php";

include "kategorije_lista.php";



// izbaci value - dugme:

$posl=$_POST;
array_pop($posl);


 $ukupno=0;


if (isset($_POST['id']))
 {
    $id = $_POST['id'];
  
  
  // ako je košarica prazna
  if (!isset($_SESSION["kosarica"]) OR empty($_SESSION["kosarica"]) )
   { 
     
     
     $posl["količina"]=1;
  $_SESSION["kosarica"]=array();
  array_push($_SESSION["kosarica"], $posl);
  
  

} 



 else {
    // ako ima proizvoda
  
for ($i=0; $i <count($_SESSION["kosarica"]) ; $i++) { 
 $value=$_SESSION["kosarica"][$i];

$zadnja_v = end($value);

  array_pop($value);



 if ($value === $posl) {
    
   $_SESSION["kosarica"][$i]["količina"]=$zadnja_v; //vraća zadnju količinu
   $_SESSION["kosarica"][$i]["količina"]+=1;

$p=1; //prozivod postoji u košarici, uvečaj količinu za 1

   }  



}// kraj for


if (!isset($p)) {
 
$a=$posl;
  
  
$a["količina"]=1;

  array_push($_SESSION["kosarica"], $a); //dodaj novi proizvod u košarici

}

 


  
       
  } // kraj else isset id
 // header("location: kosarica.php"); 
    



} // kraj if is set id





if (isset($_SESSION["kosarica"])) {
  
  

echo '<h3 align="center">Proizvodi u košarici:</h3>';
$rbr=0;
$ukupno=0;




foreach ($_SESSION["kosarica"] as $key => $value) {
 echo '<table border="1" style="border-collapse: collapse; width: 90%">'; 
$rbr++;
echo '<tr>';
echo '<td>';
echo $rbr.'.';
echo '</td>';
// čuvanje količina:
$z=end($value);
array_pop($value);




  foreach ($value as $k => $v) {


    echo '<td>';
    echo $k.': '.$v;
echo '</td>';
  }


echo '<td>';
echo '<form method="post" >'; 


echo 'količina: ';
echo '<input type="number" name="nova" min="1" max="10" value="'.$z.'">';
echo '<button name="uredi" type="submit" value="'.$key.'">Promijeni</button>';




echo '</form>';


echo '</td>';
 echo '<td>';
echo '<form method="post">';
 

  echo '<button name="brisi" type="submit" value="'.$key.'">Ukloni</button>';
 
  echo '</form>';
  echo '</td>';
echo '</tr>';

echo '<table><br>';

// izračun cijene sstavke:
$c=$value["cijena"];
$c=str_replace(",", ".", $c); // zamijena zareza točkom zbog računanja
$c=$c*$z;
$ukupno=$c+$ukupno; //ukupan iznos.

} // kraj foreach session["kosarica"]





}// kraj if is set kosarica

// Brisanje:
if (isset($_POST["brisi"]) AND $_POST["brisi"]!="") {
  $br=$_POST["brisi"];
  unset($_SESSION["kosarica"][$br]);
  
 
  header('Location: kosarica.php');
  
}


// uređivanje količina
if (isset($_POST["uredi"])) {

// korišteno &$value da bih mogao promijeniti izvorni array
 foreach ($_SESSION["kosarica"] as $key => &$value) {
  if ($_POST["uredi"]==$key) {
   $z=$_POST["nova"];
   $_SESSION["kosarica"][$key]["količina"]=$z;
}
 }
  header('Location: kosarica.php');
}

echo '<br>';
$ukupno=str_replace(".", ",", $ukupno);
$_SESSION["ukupno"]=$ukupno;
echo '<br><b>UKUPNO: '.$_SESSION["ukupno"].' kn</b>';

// checkout:
if (isset($_SESSION["kosarica"]) AND !empty($_SESSION["kosarica"]))

{


  if (isset($_SESSION["user"]) AND isset($_SESSION["pass"])) {
  echo '<div align="center"><br><b><a href="blagajna.php">Na blagajnu</a></b></dvi>';
  
}

else {
echo '<div align="center"><br><b><a href="login.php">Na blagajnu</a></b></div>';

}
}// kraj if isset kosarica

else {
echo '<br><br><b>Košarica je prazna!</b>';

}


?>

</body>

</html>