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
  
for ($i=0; $i <count($_SESSION["kosarica"]) ; $i++) { 
 $value=$_SESSION["kosarica"][$i];

$zadnja_v = end($value);

  array_pop($value);



 if ($value === $_POST) {
    
   $_SESSION["kosarica"][$i]["količina"]=$zadnja_v; //vraća zadnju količinu
   $_SESSION["kosarica"][$i]["količina"]+=1;

$p=1; //prozivod postoji u košarici, uvečaj količinu za 1

   }  



}// kraj for


if (!isset($p)) {
 
$a=$_POST;
  
  print_r($a);
$a["količina"]=1;

  array_push($_SESSION["kosarica"], $a); //dodaj novi proizvod u košarici

}

 


  
       
  } // kraj else isset id
 // header("location: kosarica.php"); 
    



} // kraj if is set id





echo '<pre>';
print_r($_SESSION["kosarica"]);
echo '</pre>';  






?>

</body>

</html>