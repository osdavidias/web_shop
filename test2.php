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

print_r($_POST);
 


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
   

for ($i=0; $i <= count($_SESSION["kosarica"]) ; $i++) { 
  
         $zadnja_v = end($_SESSION["kosarica"][$i]);
         array_pop($_SESSION["kosarica"][$i]);
         
          if ($_SESSION["kosarica"][$i] === $_POST) {
            //povećaj količinu za 1
            $_SESSION["kosarica"][$i]["količina"]=$zadnja_v;
            $_SESSION["kosarica"][$i]["količina"]++;
            $postoji = 1;
          } // zatvori if, provjeru postoji li proizvod u košarici 
else
{
  
$_SESSION["kosarica"][$i]["količina"]=$zadnja_v;
}

          
         }  //zatvori for

// dodaj novi proizvod u košaricu:
       if (!$postoji) {
       $_POST["količina"]=1;
  
  array_push($_SESSION["kosarica"], $_POST);

       }
  }
  
    /*
foreach ($_SESSION["kosarica"] as $key => &$value) {

  // korišteno &$value da bi pomoću foreach petlje mogao mijenjati value array i ubaciti staru količinu na kraj

  // skida i čuva postojeće količine, uspoređuje opcije proizvoda:
$zadnja_v = end($value);

  array_pop($value);
 


  if ($value===$_POST) {


    $value["količina"]=$zadnja_v;
    $value["količina"]+=1;
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
  
  echo '<br>Nije';
  print_r($_POST);
  
 $z=array_merge($_SESSION["kosarica"], $_POST);

       }
       
  } // kraj else isset id
 // header("location: kosarica.php"); 
    


*/
} // kraj if is set id

/*

if (!isset($_SESSION["kosarica"]))
 {
  

  echo '<br><br><h3 align="center">Košarica je prazna!</h3><br>';
}

*/

if (isset($_SESSION["kosarica"])) {
  

echo '<h3 align="center">Proizvodi u košarici:</h3>';
$rbr=0;
foreach ($_SESSION["kosarica"] as $key => $value) {
$rbr++;
echo '<b>'.$rbr.'. </b>';
  foreach ($value as $key => $v) {
    echo $key.': '.$v.', ';

  }
echo '<br>';
}




}// kraj if is set kosarica


echo '<pre>';
print_r($_SESSION);
echo '<pre>';




?>

</body>

</html>