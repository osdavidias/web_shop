<?php
session_start();
unset($_SESSION["user"]);
unset($_SESSION["pass"]);
unset($_SESSION["kosarica"]);
unset($_SESSION["ukupno"]);

echo '<h2>Odlogirali ste se!</h2>';

header('Refresh: 2; URL = index.php');



?>