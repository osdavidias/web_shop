<!Doctype-html>

<html>
<head>

<title>Web shop</title>
<meta name="description" content="Web shop trgovina">
<meta name="keywords" content="web shop, trgovina, kupovina, prodaja">
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
<form method="post">
<h2>Unesi korisničko ime i lozinku</h2>
Username:<br>
<input type="text" name="korisnik" id="korisnik">
<br>Password:<br>
<input type="password" name="lozinka" id="lozinka"><br>
<button name="posalji">Unesi</button>
</form>

<?php
include "connection.php";
session_start();

if (isset($_POST["posalji"])) {

$korisnik=$_POST["korisnik"];
$lozinka=$_POST["lozinka"];



$pdo = new PDO ("mysql:host=$host; dbname=$baza", $user, $pass);
$query="SELECT * FROM kupci WHERE username= ? AND password= ?";
$stmt=$pdo->prepare($query);
$stmt->bindParam(1, $korisnik, PDO::PARAM_STR);
$stmt->bindParam(2, $lozinka, PDO::PARAM_STR);
$lozinka=md5($lozinka);
$stmt->execute();

$rezultat=$stmt->fetchAll(PDO::FETCH_OBJ);
if (empty($rezultat) OR !$rezultat)
 {
	echo '<div ><b>Pogrešno korisničko ime ili lozinka!</b></div>';
}
	
else 
 {

	session_start();
	$_SESSION["user"]=$korisnik;
	$_SESSION["pass"]=$lozinka;
	header("location:profil_kupca.php");

}
unset($pdo);

}


?>

<div align="center"><footer>© Web Shop Trgovina </footer></div>
</body>


</html>