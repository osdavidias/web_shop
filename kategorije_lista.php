<?php

try{
$pdo = new PDO ("mysql:host=$host; dbname=$baza", $user, $pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
}
catch (PDOException $e) {
  die ("GREŠKA: Ne mogu se spojiti:".$e->getMessage());
}

$query="SELECT * FROM kategorije ORDER BY naziv_kategorije ASC";
$stmt=$pdo->query($query);
$kategorije=$stmt->fetchAll(PDO::FETCH_OBJ);


echo '<h3>KATEGORIJE:</h3>';
 
foreach ($kategorije as $key => $k) {
  echo '<br><a href="kategorije.php?id='.$k->br_kategorije.'">
  <b>'.$k->naziv_kategorije.'  </a> > </b>';
 
 // potkategorije: 
  $query2="SELECT kategorije.*, potkategorije.* 
FROM potkategorije  JOIN kategorije 
ON potkategorije.kategorija=kategorije.br_kategorije
WHERE br_kategorije=? ORDER BY naziv_potkategorije ASC";
$stmt2=$pdo->prepare($query2);
$stmt2->bindParam(1, $k->br_kategorije);
$stmt2->execute();
$potkategorije=$stmt2->fetchAll(PDO::FETCH_OBJ);
foreach ($potkategorije as $key => $pk) {
  echo '<a href="kategorije.php?id='.$k->br_kategorije.'&pk='.$pk->br_potkategorije.'"> '.$pk->naziv_potkategorije.' | </a> ';

} //kraj potkategorije

}// kraj kategorije

unset($pdo);

?>