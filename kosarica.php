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
		
for ($i=0; $i <= count($_SESSION["kosarica"]) ; $i++) { 
	

		     
				  if ($_SESSION["kosarica"][$i]["id"] == $id) {
					  //povećaj količinu za 1
					  $_SESSION["kosarica"][$i]["količina"]++;
					  $postoji = 1;
				  } // zatvori if, provjeru postoji li proizvod u košarici 
		      
	       }  //zatvori for

// dodaj novi proizvod u košaricu:
		   if (!$postoji) {

			 $_POST["količina"]=1;
	
	array_push($_SESSION["kosarica"], $_POST);

		   }
	}
	
} // kraj if is set id


if (!isset($_SESSION["kosarica"]))
 {
	

	echo '<br><br><h3 align="center">Košarica je prazna!</h3><br>';
}

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




}// kraj foreach








?>

</body>

</html>