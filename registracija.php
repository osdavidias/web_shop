<!Doctype-html>
<html>
<head>

<title>Web shop registracija</title>
<meta name="description" content="Web shop trgovina">
<meta name="keywords" content="Web shop, trgovina, kupovina, prodaja">
<meta charset="UTF-8">


</head>


<body>


<ul style="float:right;list-style-type:none;">
    <li><a  href="registracija.php">Registracija</a></li>
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

?>
<h2>Registracija kupca:</h2>



<form method="post" enctype="multipart/form-data">

Ime:<br>
<input type="text" name="ime"
value="<?php if(!empty($_POST['ime']))
{
 echo $_POST['ime'];
} ?>" ><br>
Prezime:<br>
<input type="text" name="prezime" value="<?php if(!empty($_POST['prezime']))
{
 echo $_POST['prezime'];
} ?>"><br>
Adresa:<br>
<input type="text" name="adresa" value="<?php if(!empty($_POST['adresa']))
{
 echo $_POST['adresa'];
} ?>"><br>
Poštanski broj:<br>
<input type="text" name="post_broj" value="<?php if(!empty($_POST['post_broj']))
{
 echo $_POST['post_broj'];
} ?>"><br>
Mjesto:<br>
<input type="text" name="mjesto" value="<?php if(!empty($_POST['mjesto']))
{
 echo $_POST['mjesto'];
} ?>"><br>
Telefon:<br>
<input type="text" name="telefon" value="<?php if(!empty($_POST['telefon']))
{
 echo $_POST['telefon'];
} ?>"><br>

Email:<br>
<input type="text" name="mail" value="<?php if(!empty($_POST['mail']))
{
 echo $_POST['mail'];
} ?>"><br>
Korisničko ime:<br>
<input type="text" name="username" value="<?php if(!empty($_POST['username']))
{
 echo $_POST['username'];
} ?>"><br>
Lozinka:<br>
<input type="password" name="password"><br>
Potvrdi lozinku:<br>
<input type="password" name="potvrda"><br>


<br><input type="submit" name="dugme" value="Pošalji">



</form>

<?php
if (isset($_POST["dugme"])) {
include 'connection.php';
$pdo = new PDO ("mysql:host=$host; dbname=$baza", $user, $pass);
$query="SELECT * FROM kupci WHERE username LIKE ? OR email LIKE ?";
$stmt=$pdo->prepare($query);
$stmt->bindParam(1, $_POST["username"]);
$stmt->bindParam(2, $_POST["mail"]);
$stmt->execute();
if ($br=$stmt->rowCount()>0)
{
echo 
  "<b> GREŠKA: Korisničko ime ili email adresa već su registrirani!</b>";
 }
unset($pdo);


$ime=$_POST["ime"];
$prezime=$_POST["prezime"];
$adresa=$_POST["adresa"];
$post_broj=$_POST["post_broj"];
$mjesto=$_POST["mjesto"];
$telefon=$_POST["telefon"];
$mail=$_POST["mail"];
$username=$_POST["username"];
$password=$_POST["password"];
$potvrda=$_POST["potvrda"];


function nije_prazno()
{
  
  $par=func_get_args();
  foreach ($par as $key => $value) {
    if (empty($value)) {
      return 0;
    }

  }

}

if (nije_prazno($ime, $prezime, $adresa, $post_broj, $mjesto, $telefon, $mail, $username, $password, $potvrda)!== 0
  AND $password==$potvrda)
{
  



try
{
$pdo = new PDO ("mysql:host=$host; dbname=$baza", $user, $pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
} 
catch (PDOException $e) {
  die ("GREŠKA: Ne mogu se spojiti:".$e->getMessage());
}
$query="INSERT INTO kupci (ime, prezime, adresa, postanski_broj, mjesto, telefon, email, username, password)";
$query.="VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt=$pdo->prepare($query);

$stmt->bindParam(1, $ime, PDO::PARAM_STR);
$stmt->bindParam(2, $prezime, PDO::PARAM_STR);
$stmt->bindParam(3, $adresa, PDO::PARAM_STR);
$stmt->bindParam(4, $post_broj, PDO::PARAM_STR);
$stmt->bindParam(5, $mjesto, PDO::PARAM_STR);
$stmt->bindParam(6, $telefon, PDO::PARAM_STR);
$stmt->bindParam(7, $mail, PDO::PARAM_STR);
$stmt->bindParam(8, $username, PDO::PARAM_STR);
$stmt->bindParam(9, $password, PDO::PARAM_STR);

$password = md5($password);



$stmt->execute();

unset($pdo);

// email korisniku
$to = $mail;
$subject = "Dobrodošli u web shop!";
$txt = "Doborodošli u naš web shop. Želimo vam ugodnu kupovinu.";
$from = "From: Web Shop <webshop@webshop.hr>";
mail($to, $subject, $txt, $from);



echo '<div ><b>Podaci uspješno unijeti!</b></div>';
}// kraj provjere varijabli

else 
{
  echo '<b><div >GREŠKA: Niste dobro unijeli lozinku ili neko od traženih polja!</div></b>';
} 


}// kraj if isset dugme






?>

<div align="center"><footer>© Web Shop Trgovina </footer></div>
</body>


</html>